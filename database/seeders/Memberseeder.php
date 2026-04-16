<?php

namespace Database\Seeders;

use App\Models\Market;
use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'মো. রফিকুল ইসলাম', 'phone' => '01711234561', 'market_name' => 'রাজশাহী শাহেব বাজার'],
            ['name' => 'আব্দুল করিম', 'phone' => '01811234562', 'market_name' => 'নওগাঁ পুরাতন বাজার'],
            ['name' => 'শহীদুল হক', 'phone' => '01911234563', 'market_name' => 'পাবনা হাট'],
            ['name' => 'মো. আব্দুল জলিল', 'phone' => '01612345674', 'market_name' => 'সিরাজগঞ্জ বড় বাজার'],
            ['name' => 'মো. হাসানুজ্জামান', 'phone' => '01512345675', 'market_name' => 'নাটোর বনপাড়া হাট'],
            ['name' => 'রহিম মিয়া', 'phone' => '01312345676', 'market_name' => 'ঢাকা কাওরান বাজার'],
            ['name' => 'সুমন হোসেন', 'phone' => '01412345677', 'market_name' => 'ঢাকা শ্যামবাজার'],
            ['name' => 'মো. ইব্রাহীম', 'phone' => '01712345678', 'market_name' => 'খুলনা বড় বাজার'],
            ['name' => 'জসিম উদ্দিন', 'phone' => '01812345679', 'market_name' => 'চট্টগ্রাম খাতুনগঞ্জ'],
        ];

        foreach ($members as $data) {
            $market = Market::where('name', $data['market_name'])->first();
            if (!$market)
                continue;

            Member::firstOrCreate(
                ['phone' => $data['phone']],
                [
                    'name' => $data['name'],
                    'market_id' => $market->id,
                    'is_active' => true,
                ]
            );
        }
    }
}