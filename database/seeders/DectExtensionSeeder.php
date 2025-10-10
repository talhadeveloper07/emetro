<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DectExtensionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('dect_extension')->insert([
            [
                'id' => 1,
                'extension' => '527',
                'secret' => 'St@ve829Pa1en',
                'display_name' => 'Steve Pallen',
                'index' => '0',
                'mac' => '232334342323',
            ],
            [
                'id' => 2,
                'extension' => '515',
                'secret' => 'UCX515',
                'display_name' => 'Julia wifi',
                'index' => '1',
                'mac' => '232334342323',
            ],
            [
                'id' => 3,
                'extension' => '597',
                'secret' => 'v1rtua7Fax',
                'display_name' => 'virtual fax',
                'index' => '2',
                'mac' => '232334342323',
            ],
            [
                'id' => 4,
                'extension' => '553',
                'secret' => '(emt5656)',
                'display_name' => 'Joseph Abraham - SIP',
                'index' => '19',
                'mac' => '232334342323',
            ],
            [
                'id' => 5,
                'extension' => '558',
                'secret' => 'hqucx558',
                'display_name' => 'Misha Vodsedalek',
                'index' => '4',
                'mac' => '232334342323',
            ],
            [
                'id' => 6,
                'extension' => '544',
                'secret' => 'abc123',
                'display_name' => 'May SIP',
                'index' => '5',
                'mac' => '232334342323',
            ],
            [
                'id' => 7,
                'extension' => '641',
                'secret' => '8R549!$z',
                'display_name' => 'Tim SIP',
                'index' => '6',
                'mac' => '232334342323',
            ],
            [
                'id' => 8,
                'extension' => '705',
                'secret' => '38ca1d16a68ba18b9b9061abfd066af9',
                'display_name' => 'Marketing',
                'index' => '7',
                'mac' => '232334342323',
            ],
            [
                'id' => 9,
                'extension' => '525',
                'secret' => 'z01p3r2020',
                'display_name' => 'PaulSIP',
                'index' => '8',
                'mac' => '232334342323',
            ],
            [
                'id' => 10,
                'extension' => '529',
                'secret' => 'Br549!$z',
                'display_name' => 'Glenn VTech',
                'index' => '9',
                'mac' => '232334342323',
            ],
            [
                'id' => 11,
                'extension' => '644',
                'secret' => 'BR549!$',
                'display_name' => 'Tim SIP2',
                'index' => '10',
                'mac' => '232334342323',
            ],
            [
                'id' => 12,
                'extension' => '639',
                'secret' => '0f6fd61be23e5e5631a2fb4ebfd04816',
                'display_name' => 'Guy SIP J189',
                'index' => '11',
                'mac' => '232334342323',
            ],
            [
                'id' => 13,
                'extension' => '671',
                'secret' => 'oak417',
                'display_name' => 'Infinity 277',
                'index' => '12',
                'mac' => '232334342323',
            ],
            [
                'id' => 29,
                'extension' => '672',
                'secret' => 'oak417',
                'display_name' => 'Infinity 277',
                'index' => '13',
                'mac' => '232334342323',
            ],
        ]);
    }
}
