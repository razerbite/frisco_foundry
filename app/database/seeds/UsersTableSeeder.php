<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;
class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

    // Get roles
    $admin = Role::find(1);
    $secretary = Role::find(2);
    $technical = Role::find(3);
    $executive = Role::find(4);
    $procurement = Role::find(5);

    $contactNumber = new ContactNumber([
      'type' => $faker->numberBetween(1,3),
      'number' => $faker->phoneNumber
    ]);

    $contactInfo = ContactInfo::create([
      'address_1' => $faker->streetAddress,
      'address_2' => $faker->streetName,
      'zip' => $faker->postcode,
      'email' => $faker->email
    ]);
    $contactInfo->contactNumbers()->save($contactNumber);

    $gat = User::create([
      'username' => 'Gatix',
      'email' => 'gat@outlook.ph',
      'password' => Hash::make('Sand1gan'),
      'first_name' => 'Gat',
      'last_name' => 'Manuel',
      'company_name' => 'Gatix',
      'company_position' => 'Dev'
    ]);
    $gat->attachRoles([$admin, $secretary, $technical, $executive, $procurement]);
    $gat->contactInfo()->save($contactInfo);

    // Admins
    foreach(range(1, 3) as $index)
    {
      $contactNumber = new ContactNumber([
        'type' => $faker->numberBetween(1,3),
        'number' => $faker->phoneNumber
      ]);

      $contactInfo = ContactInfo::create([
        'address_1' => $faker->streetAddress,
        'address_2' => $faker->streetName,
        'zip' => $faker->postcode,
        'email' => $faker->email
      ]);
      $contactInfo->contactNumbers()->save($contactNumber);

      $user = User::create([
        'username' => 'admin_'.$index,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_initial' => strtoupper($faker->randomLetter),
        'company_name' => $faker->company,
        'password' => Hash::make('password'),
        'company_position' => 'Admin'
      ]);

      $user->attachRole($admin);
      $user->contactInfo()->save($contactInfo);
    }

    // Secretaries
    foreach(range(1, 3) as $index)
    {
      $contactNumber = new ContactNumber([
        'type' => $faker->numberBetween(1,3),
        'number' => $faker->phoneNumber
      ]);

      $contactInfo = ContactInfo::create([
        'address_1' => $faker->streetAddress,
        'address_2' => $faker->streetName,
        'zip' => $faker->postcode,
        'email' => $faker->email
      ]);
      $contactInfo->contactNumbers()->save($contactNumber);

      $user = User::create([
        'username' => 'secretary_'.$index,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_initial' => strtoupper($faker->randomLetter),
        'company_name' => $faker->company,
        'password' => Hash::make('password'),
        'company_position' => 'Secretary'
      ]);

      $user->attachRole($secretary);
      $user->contactInfo()->save($contactInfo);
    }

    // Technicals
    foreach(range(1, 3) as $index)
    {
      $contactNumber = new ContactNumber([
        'type' => $faker->numberBetween(1,3),
        'number' => $faker->phoneNumber
      ]);

      $contactInfo = ContactInfo::create([
        'address_1' => $faker->streetAddress,
        'address_2' => $faker->streetName,
        'zip' => $faker->postcode,
        'email' => $faker->email
      ]);
      $contactInfo->contactNumbers()->save($contactNumber);

      $user = User::create([
        'username' => 'technical_'.$index,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_initial' => strtoupper($faker->randomLetter),
        'company_name' => $faker->company,
        'password' => Hash::make('password'),
        'company_position' => 'Technical Reviewer'
      ]);

      $user->attachRole($technical);
      $user->contactInfo()->save($contactInfo);
    }

    // Executives
    foreach(range(1, 3) as $index)
    {
      $contactNumber = new ContactNumber([
        'type' => $faker->numberBetween(1,3),
        'number' => $faker->phoneNumber
      ]);

      $contactInfo = ContactInfo::create([
        'address_1' => $faker->streetAddress,
        'address_2' => $faker->streetName,
        'zip' => $faker->postcode,
        'email' => $faker->email
      ]);

      $contactInfo->contactNumbers()->save($contactNumber);

      $user = User::create([
        'username' => 'executive_'.$index,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_initial' => strtoupper($faker->randomLetter),
        'company_name' => $faker->company,
        'password' => Hash::make('password'),
        'company_position' => 'Executive'
      ]);

      $user->attachRole($executive);
      $user->contactInfo()->save($contactInfo);
    }

    // Procurement
    foreach(range(1, 3) as $index)
    {
      $contactNumber = new ContactNumber([
        'type' => $faker->numberBetween(1,3),
        'number' => $faker->phoneNumber
      ]);

      $contactInfo = ContactInfo::create([
        'address_1' => $faker->streetAddress,
        'address_2' => $faker->streetName,
        'zip' => $faker->postcode,
        'email' => $faker->email
      ]);

      $contactInfo->contactNumbers()->save($contactNumber);

      $user = User::create([
        'username' => 'procurement_'.$index,
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_initial' => strtoupper($faker->randomLetter),
        'company_name' => $faker->company,
        'password' => Hash::make('password'),
        'company_position' => 'Procurement'
      ]);

      $user->attachRole($procurement);
      $user->contactInfo()->save($contactInfo);
    }

	}

}
