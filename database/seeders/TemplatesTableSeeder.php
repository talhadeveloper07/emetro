<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplatesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('templates')->insert([
            [
                'id' => 1,
                'template_name' => 't4x_default',
                'vendor' => 'Yealink',
                'model' => 'T4x_Series',
                're_seller' => null,
                'modified_date' => '2023-10-23',
                'file_location' => 'public://template/default/yealink_t4x_default.cfg',
                'file_id' => 0,
                'file_name' => '',
                'is_default' => 0,
            ],
            [
                'id' => 2,
                'template_name' => 't5x_default',
                'vendor' => 'Yealink',
                'model' => 'T5x_Series',
                're_seller' => null,
                'modified_date' => '2023-10-23',
                'file_location' => 'public://template/default/yealink_t5x_default.cfg',
                'file_id' => 0,
                'file_name' => '',
                'is_default' => 0,
            ],
            [
                'id' => 3,
                'template_name' => 'cp_default',
                'vendor' => 'Yealink',
                'model' => 'Conference_Phones',
                're_seller' => null,
                'modified_date' => '2023-10-23',
                'file_location' => 'public://template/default/yealink_cp_default.cfg',
                'file_id' => 0,
                'file_name' => '',
                'is_default' => 0,
            ],
            [
                'id' => 4,
                'template_name' => 'grp_default',
                'vendor' => 'Grandstream',
                'model' => 'GRP_IP_Phones',
                're_seller' => null,
                'modified_date' => '2023-10-23',
                'file_location' => 'public://template/default/grandstream_grp_default.xml',
                'file_id' => 0,
                'file_name' => '',
                'is_default' => 0,
            ],
            [
                'id' => 5,
                'template_name' => 'gxp_default',
                'vendor' => 'Grandstream',
                'model' => 'GXP_IP_Phones',
                're_seller' => null,
                'modified_date' => '2023-10-23',
                'file_location' => 'public://template/default/grandstream_gxp_default.xml',
                'file_id' => 0,
                'file_name' => '',
                'is_default' => 0,
            ],
            [
                'id' => 6,
                'template_name' => 'gds_default',
                'vendor' => 'Grandstream',
                'model' => 'GDS_Door_Phones',
                're_seller' => null,
                'modified_date' => '2023-10-23',
                'file_location' => 'public://template/default/grandstream_gds_default.xml',
                'file_id' => 0,
                'file_name' => '',
                'is_default' => 0,
            ],
            [
                'id' => 7,
                'template_name' => 'gsc_default',
                'vendor' => 'Grandstream',
                'model' => 'GSC_Speaker_Intercom',
                're_seller' => null,
                'modified_date' => '2023-10-23',
                'file_location' => 'public://template/default/grandstream_gsc_default.xml',
                'file_id' => 0,
                'file_name' => '',
                'is_default' => 0,
            ],
        ]);
    }
}
