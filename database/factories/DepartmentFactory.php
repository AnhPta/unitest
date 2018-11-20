<?php

$factory->define(App\Repositories\Departments\Department::class, function (Faker\Generator $faker) {
	return [
		'name'      => 'Phòng '.$faker->name,
		'branch_id' => function () use ($faker) {
            return factory(\App\Repositories\Branches\Branch::class)->create([
            ])->id;
        }
	];
});
