<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mac')->insert([
            [
                'id' => 2,
                'mac' => '805EC0534166',
                'vendor' => 'Yealink',
                'model' => 'T4x_series',
                'template_name' => 't4x_default',
                're_seller' => '485',
                'modified_date' => '2023-10-17',
            ],
            [
                'id' => 4,
                'mac' => 'D4CC70223301',
                'vendor' => 'Yealink',
                'model' => 'Conference_Phones',
                'template_name' => 'cp_default',
                're_seller' => '485',
                'modified_date' => '2023-10-25',
            ],
            [
                'id' => 14,
                'mac' => '14AEDB10F0E2',
                'vendor' => 'Fanvil',
                'model' => 'X_and_XU',
                'template_name' => 'fan_default',
                're_seller' => '485',
                'modified_date' => '2023-10-30',
            ],
            [
                'id' => 15,
                'mac' => '0004F2D0BE23',
                'vendor' => 'Grandstream',
                'model' => 'GXP_IP_Phones',
                'template_name' => 'grp_default',
                're_seller' => '485',
                'modified_date' => '2023-10-30',
            ],
            [
                'id' => 16,
                'mac' => '000AE405BE15',
                'vendor' => 'Snom',
                'model' => 'D_Series',
                'template_name' => 'cp_default',
                're_seller' => '485',
                'modified_date' => '2023-10-30',
            ],
            [
                'id' => 17,
                'mac' => '0004F2D0BE26',
                'vendor' => 'Grandstream',
                'model' => 'GSC_Speaker_Intercom',
                'template_name' => 'gxp_default',
                're_seller' => '485',
                'modified_date' => '2023-10-30',
            ],
            [
                'id' => 18,
                'mac' => '0004F2D0BE25',
                'vendor' => 'Grandstream',
                'model' => 'GRP_IP_Phones',
                'template_name' => 'gds_default',
                're_seller' => '485',
                'modified_date' => '2023-10-30',
            ],
            [
                'id' => 19,
                'mac' => '0004F2D0BE24',
                'vendor' => 'Grandstream',
                'model' => 'GDS_Door_Phones',
                'template_name' => 'gsc_default',
                're_seller' => '485',
                'modified_date' => '2023-10-30',
            ],
            [
                'id' => 20,
                'mac' => '805EC053417E',
                'vendor' => 'Yealink',
                'model' => 'T5x_Series',
                'template_name' => 't5x_default',
                're_seller' => '485',
                'modified_date' => '2023-10-30',
            ],
        ]);
    }
}
