<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'id' => str_random(14),
        'title' => $faker->sentence(15, true),
		'author' => $faker->name,
		'content' => $faker->paragraphs(10, true),
		// 'featured' => rand(0, 1),
		'created_by' => 'superadmin',
        'posted_at' => $faker->dateTimeBetween('-5months', 'now', 'Asia/Manila'),
    ];
});