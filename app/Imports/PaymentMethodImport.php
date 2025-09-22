<?php

namespace App\Imports;

use App\Http\Controllers\HelperController;
use App\Models\Organization;
use App\Models\PaymentMethod;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Stripe\Stripe;

class PaymentMethodImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        // Initialize Stripe

        foreach ($rows as $row) {
            try {
                // Fetch card details from Stripe
                $cardDetails = $this->getCardDetails($row['payment_method'],$row['reseller_id']);
//                dd($cardDetails);
                $captureResponse = [];
                if (!empty($row['stripe_customer_obj'])) {
                    try {
                        $captureResponse = json_decode($row['stripe_customer_obj'], true);
                        if (!is_array($captureResponse)) {
                            $captureResponse = [
                                "id"=> $row['payment_method'],
                                "object"=> "card",
                            ];
                        }
                    } catch (\Exception $e) {
                        $captureResponse = [
                            "id"=> $row['payment_method'],
                            "object"=> "card",
                        ];
                    }
                }

                // Add card object to capture_response
                $captureResponse['card'] = [
                    'brand'         => $cardDetails['brand'] ?? null,
                    'country'       => $cardDetails['country'] ?? null,
                    'display_brand' => $cardDetails['display_brand'] ?? $cardDetails['brand'] ?? null,
                    'exp_month'     => $cardDetails['exp_month'] ?? null,
                    'exp_year'      => $cardDetails['exp_year'] ?? null,
                    'last4'         => $cardDetails['last4'] ?? null,
                ];
                PaymentMethod::updateOrCreate(
                    [
                        'user_id'           => $row['uid'],
                        'org_id'            => $row['reseller_id'],
                        'customer_id'       => $row['stripe_id'],
                        'payment_method_id' => $row['payment_method'],
                    ],
                    [
                        'capture_response'  => json_encode($captureResponse),
                        'gateway'           => 'stripe',
                        'brand'             => $cardDetails['brand'] ?? null,
                        'last4'             => $cardDetails['last4'] ?? null,
                        'exp_month'         => $cardDetails['exp_month'] ?? null,
                        'exp_year'          => $cardDetails['exp_year'] ?? null,
                        'card_holder_name'  => $cardDetails['card_holder_name'] ?? null,
                        'is_default'        => $cardDetails['default'] ?? false,
                        'updated_at'        => now(),
                    ]
                );
            } catch (\Exception $e) {
                continue; // Skip invalid rows
            }
        }

    }

    private function getCardDetails($paymentMethodId,$org_id)
    {

        try {
            $org = Organization::where('org_id',$org_id)->first();
            Stripe::setApiKey(getStripeSecret($org->country ?? ""));
            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
            return [
                'brand'             => $paymentMethod->card->brand ?? null,
                'country'           => $paymentMethod->card->country ?? null,
                'display_brand'     => $paymentMethod->card->brand ?? null,
                'exp_month'         => $paymentMethod->card->exp_month ?? null,
                'exp_year'          => $paymentMethod->card->exp_year ?? null,
                'last4'             => $paymentMethod->card->last4 ?? null,
                'card_holder_name'  => $paymentMethod->billing_details->name ?? null,
            ];
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Handle rate limit by retrying after a delay
            sleep(2); // Wait 2 seconds
            return $this->getCardDetails($paymentMethodId); // Retry
        } catch (\Exception $e) {

            return [];
        }
    }
    public function chunkSize(): int
    {
        return 1000; // Process 1000 rows at a time
    }
}
