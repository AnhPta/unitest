<?php

use App\Repositories\Branches\Branch;

$allStatus = Branch::ALL_STATUS;

$factory->define(Branch::class, function (Faker\Generator $faker) use ($allStatus){
    // $allCityId     = \App\Repositories\Cities\City::all()->pluck('id')->toArray();

    return [
        'name'        => $faker->unique()->company,
        'address'     => $faker->unique()->address,
        'phone'       => '0'.$faker->randomNumber($nbDigits = 9),
        'email'       => $faker->unique()->companyEmail,
        'website'     => $faker->unique()->url,
        'facebook'    => 'facebook.com/'.$faker->unique()->company,
        'instagram'   => $faker->unique()->company,
        'zalo'        => $faker->unique()->company,
        'description' => $faker->realText($maxNbChars = 100),
        'about'       => $faker->realText($maxNbChars = 200),
        'tax_number'  => $faker->unique()->ean8,
        'bank'        => $faker->company,
        // 'city_id'     => $faker->randomElement($allCityId),
        // 'district_id' => rand(1, 63),
        'city_id'     => 2,
        'district_id' => 4,
        'status'      => $faker->randomElement($allStatus),
    ];
});
