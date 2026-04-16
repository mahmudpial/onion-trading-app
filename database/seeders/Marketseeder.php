<?php

namespace Database\Seeders;

use App\Models\Market;
use Illuminate\Database\Seeder;

class MarketSeeder extends Seeder
{
    public function run(): void
    {
        $markets = [
            ['name' => 'রাজশাহী শাহেব বাজার', 'division' => 'Rajshahi', 'open_days' => ['Saturday', 'Tuesday', 'Thursday']],
            ['name' => 'নওগাঁ পুরাতন বাজার', 'division' => 'Rajshahi', 'open_days' => ['Sunday', 'Wednesday']],
            ['name' => 'পাবনা হাট', 'division' => 'Rajshahi', 'open_days' => ['Monday', 'Friday']],
            ['name' => 'সিরাজগঞ্জ বড় বাজার', 'division' => 'Rajshahi', 'open_days' => ['Saturday', 'Wednesday']],
            ['name' => 'নাটোর বনপাড়া হাট', 'division' => 'Rajshahi', 'open_days' => ['Sunday', 'Thursday']],
            ['name' => 'ঢাকা কাওরান বাজার', 'division' => 'Dhaka', 'open_days' => ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']],
            ['name' => 'ঢাকা শ্যামবাজার', 'division' => 'Dhaka', 'open_days' => ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']],
            ['name' => 'খুলনা বড় বাজার', 'division' => 'Khulna', 'open_days' => ['Tuesday', 'Friday']],
            ['name' => 'চট্টগ্রাম খাতুনগঞ্জ', 'division' => 'Chittagong', 'open_days' => ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']],
        ];

        foreach ($markets as $data) {
            Market::firstOrCreate(
                ['name' => $data['name']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}