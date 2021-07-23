<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            '1 Robert Yen Male 1975/8/8 robert.yen@linecorp.com',
            '2 Cid Change Male 1990/10/10 cid.change@linecorp.com',
            '3 Miki Lai Female 1993/4/5 miki.lai@linecorp.com',
            '4 Sherry Chen Female 1993/8/8 sherry.lai@linecorp.com',
            '5 Peter Wang Male 1950/12/22 peter.wang@linecorp.com',
        ];

        foreach ($rows as $row) {
            [$id, $first_name, $last_name, $gender, $date_of_birthday, $email] = explode(' ', $row);
            Member::create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'date_of_birthday' => $date_of_birthday,
                'email' => $email,
            ]);
        }
    }
}
