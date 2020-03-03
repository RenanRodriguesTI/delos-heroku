<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Delos\Dgp\Entities\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
        'admission' => $faker->date(),
        'role_id' => $faker->randomElement(DB::table('roles')->select()->pluck('id')->all()),
        'supplier_number' => $faker->randomNumber(7)
    ];
});

$factory->define(Delos\Dgp\Entities\Expense::class, function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->randomElement(DB::table('users')->select()->pluck('id')->all()),
        'request_id' => $faker->randomElement(DB::table('requests')->whereNull('deleted_at')->whereNotNull('project_id')->select()->pluck('id')->all()),
        'invoice' => $faker->text(10),
        'issue_date' => $faker->dateTimeThisMonth()->format('d/m/Y'),
        'value' => $faker->randomFloat(2),
        'payment_type_id' => $faker->randomElement(DB::table('payment_types')->select()->pluck('id')->all()),
        'description' => $faker->text(30),
        'original_name' => $faker->text(10),
        's3_name' => $faker->text(5),
        'exported' => false
    ];
});

$factory->define(Delos\Dgp\Entities\DebitMemo::class, function (Faker\Generator $faker) {
    return [
        'number' => $faker->randomNumber(4)
    ];
});

$factory->define(Delos\Dgp\Entities\Group::class, function (Faker\Generator $faker) {
    $cod = $faker->unique()->numberBetween(1, 99);
    $cod = str_pad($cod, 2, '0', STR_PAD_LEFT);

    return [
        'cod' => $cod,
        'name' => $faker->company
    ];
});

$factory->define(Delos\Dgp\Entities\Client::class, function (Faker\Generator $faker) {
    return [
        'cod' => $faker->unique()->numberBetween(100,999),
        'name' => $faker->company,
        'group_id' => $faker->numberBetween(1, 10)
    ];
});

$factory->define(Delos\Dgp\Entities\Task::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence()
    ];
});

$factory->define(Delos\Dgp\Entities\ProjectType::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence(),
        'group_company_id' => $faker->randomElement(DB::table('group_companies')->select()->pluck('id')->all())
    ];
});

$factory->define(Delos\Dgp\Entities\Place::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});

$factory->define(Delos\Dgp\Entities\Activity::class, function (Faker\Generator $faker) {
    return [
        'start' => $faker->dateTime,
        'end' => $faker->dateTime,
        'project_id' => $faker->numberBetween(1, 10),
        'user_id' => $faker->numberBetween(1, 10),
        'task_id' => $faker->numberBetween(1, 10),
        'place_id' => $faker->numberBetween(1, 10),
        'note' => $faker->paragraph,
    ];
});

$factory->define(Delos\Dgp\Entities\FinancialRating::class, function (Faker\Generator $faker) {
    return [
        'cod' => $faker->randomNumber(2),
        'description' => $faker->sentence()
    ];
});

$factory->define(Delos\Dgp\Entities\Project::class, function (Faker\Generator $faker) {
    $start = $faker->dateTimeBetween('-2 years', 'now');
    $ownerId = $faker->randomElement(DB::table('users')->select()->pluck('id')->all());
    $coOwnerId = $faker->randomElement(DB::table('users')->select()->pluck('id')->all());
    $coOwnerId = $ownerId == $coOwnerId ? null : $coOwnerId;

    return [
        'cod' => $faker->unique()->randomNumber(2),
        'company_id' => $faker->randomElement(DB::table('companies')->select()->pluck('id')->all()),
        'project_type_id' => $faker->randomElement(DB::table('project_types')->select()->pluck('id')->all()),
        'financial_rating_id' => $faker->numberBetween(1, 2),
        'owner_id' => $ownerId,
        'co_owner_id' => $coOwnerId,
        'budget' => $faker->numberBetween(100, 10000),
        'start' => $start->format('d/m/Y'),
        'finish' => $faker->dateTimeBetween('tomorrow', '+ 2 years')->format('d/m/Y'),
        'proposal_value' => $faker->numberBetween(5000, 9999999),
        'proposal_number' => $faker->numerify("######/{$start->format('y')}")
    ];
});

$factory->define(Delos\Dgp\Entities\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->jobTitle
    ];
});

$factory->define(Delos\Dgp\Entities\Permission::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->sentence
    ];
});