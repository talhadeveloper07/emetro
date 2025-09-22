<?php

use Illuminate\Support\Facades\Session;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


if (!function_exists('generateOtp')) {
    function generateOtp()
    {
        $otp = rand(100000, 999999);
        $otp = 111111;
        return $otp;
    }
}
if (!function_exists('priceArray')) {
    function priceArray()
    {
        $prices_type_list = [
            'price1' => 'United States Dollar',
            'price4' => 'Canadian Dollar',
            'price2' => 'Australian',
            'price3' => 'Europe',
            'price5' => 'International',
            'price6' => 'Europe 2',
            'price7' => 'Europe 3',
        ];
        return $prices_type_list;
    }
}
if (!function_exists('priceTypeAddress')) {
    function priceTypeAddress( $priceType): ?array
    {
        $usaAddress = "405 State Highway 121<br>
            Suite A250<br>
            Lewisville, Texas 75067<br>
            USA";

        $canadaAddress = "2572 Daniel-Johnson Boulevard<br>
            2nd Floor.<br>
            Laval Quebec H7T 2R3<br>
            Canada";

        $addresses = [
            'price1' => [
                'name' => "E-MetroTel LLC",
                'address' => $usaAddress,
            ],
            'price2' => [
                'name' => "E-MetroTel Australia",
                'address' => $usaAddress,
            ],
            'price3' => [
                'name' => "E-MetroTel Europe",
                'address' => $usaAddress,
            ],
            'price4' => [
                'name' => "E-MetroTel Canada Inc.",
                'address' => $canadaAddress,
            ],
            'price5' => [
                'name' => "E-MetroTel LLC",
                'address' => $usaAddress,
            ],
            'price6' => [
                'name' => "E-MetroTel Europe",
                'address' => $usaAddress,
            ],
            'price7' => [
                'name' => "E-MetroTel Europe",
                'address' => $usaAddress,
            ],
        ];
        if($priceType){
            return $addresses[$priceType] ?? null;
        }else{
            return $addresses['price1'] ?? null;
        }

    }
}

if (!function_exists('timeToDate')) {
    function timeToDate($time)
    {
        if (empty($time)) {
            return '';
        }
        try {
            return Carbon::parse($time)->format('m/d/Y');
        } catch (\Exception $e) {
            return '';
        }
    }
}
if (!function_exists('dateToTime')) {
    function dateToTime($date)
    {
        if (empty($date)) {
            return '';
        }
        try {
            return Carbon::parse($date)->timestamp;
        } catch (\Exception $e) {
            return '';
        }
    }
}
if (!function_exists('timeToDateYMD')) {
    function timeToDateYMD($time)
    {
        if (empty($time)) {
            return '';
        }
        try {
            return Carbon::parse($time)->format('Y-m-d');
        } catch (\Exception $e) {
            return '';
        }
    }
}

if (!function_exists('get_site_status_options')) {
    /**
     * Get the list of available site status options.
     *
     * @return array
     */
    function get_site_status_options(): array
    {
        return [
            'In Service',
            'Retired',
            'Demo-Lab',
            'Assigned',
            'Demo with Service',
            'Blacklisted',
            'Activated',
        ];
    }
}
if (!function_exists('get_configuration_options')) {
    /**
     * Get the list of available configuration options.
     *
     * @return array
     */
    function get_configuration_options(): array
    {
        return [
            'Standalone',
            'Active Standby',
            'Cold / Warm Standby',
            'SRG Local',
            'SRG Remote',
            'Main Network Node',
            'Secondary Network Node',
            'Network Branch',
            'DSM16',
        ];
    }
}
if (!function_exists('isEmptyHostFields')) {
    function isEmptyHostFields($record)
    {

        return empty($record->retired_host_id1) &&
            empty($record->retired_host_note1) &&
            empty($record->retired_host_id2) &&
            empty($record->retired_host_note2) &&
            empty($record->retired_host_id3) &&
            empty($record->retired_host_note3) &&
            empty($record->retired_host_id4) &&
            empty($record->retired_host_note4);
    }
}
if (!function_exists('hasRole')) {
    function hasRole($roles)
    {
        $userRoles = Session::get('roles', []); // Get roles from session, default to an empty array

        if (!is_array($userRoles)) {
            return false;
        }

        return !empty(array_intersect((array) $roles, $userRoles));
    }
}
if (!function_exists('getProductSubTypes')) {
    function getProductSubTypes()
    {
        $subtypes =[
            'Service' => ['software monthly', 'software annual','hardware annual','one time charge'],
            'Hardware' => ['published', 'component'],
            'Software' => ['base','extension','application']
        ];

        return $subtypes;
    }
}
if (!function_exists('getAllCounties')) {
    function getAllCounties(): array
    {
        return Cache::rememberForever('countries_sorted_array', function () {
            return DB::table('countries')
                ->select('id', 'iso2', 'name')
                ->orderByRaw("
                    CASE
                        WHEN iso2 = 'US' THEN 0
                        WHEN iso2 = 'CA' THEN 1
                        ELSE 2
                    END, name
                ")
                ->get()
                ->map(fn($row) => (array) $row)
                ->all();
        });
    }
}
if (!function_exists('getCountryStates')) {
    function getCountryStates(string $countryCode): array
    {
        return Cache::rememberForever("states_of_{$countryCode}", function () use ($countryCode) {
            return DB::table('states')
                ->select('id', 'state_code', 'name')
                ->where('country_code', $countryCode)
                ->orderBy('name')
                ->get()
                ->map(fn($row) => (array) $row)
                ->all();
        });
    }
}
if (!function_exists('getCountryCurrency')) {
    function getCountryCurrency(string $countryCode): array
    {
        return Cache::rememberForever("currencies_of_{$countryCode}", function () use ($countryCode) {
            $countryId = DB::table('countries')
                ->where('iso2', $countryCode)
                ->value('id');

            if (!$countryId) {
                return []; // Country not found, return empty array
            }

            return DB::table('currencies')
                ->select('id', 'code', 'name', 'symbol', 'symbol_native', 'precision')
                ->where('country_id', $countryId)
                ->orderBy('name')
                ->get()
                ->map(fn($row) => (array) $row)
                ->all();
        });
    }
}
if (!function_exists('getCountryByCode')) {
    function getCountryByCode(string $code): string
    {
        return Cache::rememberForever("country_name_{$code}", function () use ($code) {
            return DB::table('countries')
                ->where('iso2', $code)
                ->value('name') ?? $code;
        });
    }
}
if (!function_exists('getCurrencyByCode')) {
    function getCurrencyByCode(string $code): string
    {
        return Cache::rememberForever("curency_name_{$code}", function () use ($code) {
            return DB::table('currencies')
                ->where('code', $code)
                ->value('name') ?? $code;
        });
    }
}

if (!function_exists('getStateByCode')) {
    function getStateByCode(string $code): string
    {
        return Cache::rememberForever("state_name_{$code}", function () use ($code) {
            return DB::table('states')
                ->where('state_code', $code)
                ->value('name') ?? $code;
        });
    }
}
if (!function_exists('convertToTitle')) {
    function convertToTitle($status) {
        return ucwords(str_replace('_', ' ', $status));
    }
}
if (!function_exists('convertToSnakeCase')) {
    function convertToSnakeCase($title) {
        return strtolower(str_replace(' ', '_', $title));
    }
}
if (!function_exists('getTransactionStatus')) {
    function getTransactionStatus($status)
    {
        $data=convertToTitle($status);
        if($status=="unpaid"){
            $data='<span class="badge  me-1"></span>'. convertToTitle($status);
        } elseif($status=="succeeded"){
            $data='<span class="badge bg-success me-1"></span>'. convertToTitle($status);
        } elseif($status=="paid"){
            $data='<span class="badge bg-success me-1"></span>'. convertToTitle($status);
        }elseif($status=="failed"){
            $data='<span class="badge bg-danger me-1"></span>'. convertToTitle($status);
        }elseif($status=="refunded"){
            $data='<span class="badge bg-warning me-1"></span>'. convertToTitle($status);
        }elseif($status=="partial_refunded"){
            $data='<span class="badge bg-warning me-1"></span>'. convertToTitle($status);
        }elseif($status=="overdue"){
            $data='<span class="badge bg-danger me-1"></span>'. convertToTitle($status);
        }else{
            $data='<span class="badge  me-1"></span>'. convertToTitle($status);
        }
        return $data;
    }
}

if (!function_exists('getLogEvent')) {
    function getLogEvent($event)
    {
        $data='<span class="badge  me-1"></span>'. convertToTitle($event);
        if($event=="wallet"){
            $data='<span class="badge bg-success me-1">'.convertToTitle($event).'</span>' ;
        }elseif($event=="emtpay"){
            $data='<span class="badge bg-warning me-1">'. convertToTitle($event).'</span>';
        }elseif($event=="invoice"){
            $data='<span class="badge bg-primary me-1">'. convertToTitle($event).'</span>';
        }
        return $data;
    }
}


if (!function_exists('encrypt_id')) {
    function encrypt_id($id)
    {
        $encrypt_key="shabeer pullambalavan";
        $encrypted = @bin2hex(openssl_encrypt($id, 'AES-128-CBC', $encrypt_key));
        return $encrypted;
    }
}



if (!function_exists('calculateDiscount')) {
    function calculateDiscount($product_id,$discounts)

    {
        $discount_mapping = \App\Models\OldProductDiscountMapping::where('product_id', $product_id)
            ->pluck('discount_id')
            ->toArray();
        if($discounts){
            $type=$discounts['type'];
            $discount_array=$discounts[$type];
            if (!empty($discount_mapping)) {
                foreach ($discount_mapping as $discount_id) {
                    if (isset($discount_array[$discount_id])) {
                        return (float)$discount_array[$discount_id]; // return percentage
                    }
                }
            }
        }

        return 0;
    }
}
