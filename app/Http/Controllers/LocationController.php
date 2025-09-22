<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class LocationController extends HelperController
{
    public function getCountries()
    {
        return response()->json(Cache::rememberForever('countries_sorted_array', function () {
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
        }));
    }

    public function getStates($countryCode)
    {
        return response()->json(Cache::rememberForever("states_of_{$countryCode}", function () use ($countryCode) {
            return DB::table('states')
                ->select('id', 'state_code', 'name')
                ->where('country_code', $countryCode)
                ->orderBy('name')
                ->get()
                ->map(fn($row) => (array) $row)
                ->all();
        }));
    }

    public function getCurrencies($countryCode)
    {
        return response()->json( Cache::rememberForever("currencies_of_{$countryCode}", function () use ($countryCode) {
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
        }));
    }

    public function getCities($countryCode, $stateCode)
    {
        $cities = City::where([
                'country_code' => $countryCode,
                'state_code'   => $stateCode
        ])->get();

        return response()->json($cities);
    }
}
