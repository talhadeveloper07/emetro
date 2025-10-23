<?php

namespace App\Traits;

use App\Models\Variable;

trait PhoneCodesTrait
{
    /**
     * Get phone product codes from the database.
     *
     * @return array
     */
    public function getPhoneProductCodes(): array
    {
        $variable = Variable::where('name', 'phone_product_codes')->first();

        if (!$variable) {
            return [];
        }

        // Unserialize stored value if it's serialized
        $codes = is_string($variable->value) ? unserialize($variable->value) : $variable->value;

        // If somehow not an array, explode by line breaks
        if (!is_array($codes)) {
            $codes = explode("\n", $codes);
        }

        // Trim each code and remove empty values
        $codes = array_map('trim', array_filter($codes));

        return $codes;
    }

    /**
     * Save phone product codes to the database.
     *
     * @param array $codes
     * @return void
     */
    public function getPhoneProductCodesForSql(): string
    {
        $codes = $this->getPhoneProductCodes();
        return "'" . implode("','", $codes) . "'";
    }
}
