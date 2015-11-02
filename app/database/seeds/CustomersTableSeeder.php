<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CustomersTableSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();
		$faker = Faker::create();

		foreach(range(1, 5) as $index)
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

			$customer = Customer::create([
				'name' => $faker->company,
				'industry_type' => $faker->numberBetween(1,3),
				'secretary_id' => $faker->numberBetween(5,7)
			]);
			$customer->contactInfo()->save($contactInfo);

			$representative = CustomerRepresentative::create([
		        'first_name' => $faker->firstName,
		        'last_name' => $faker->lastName,
		        'middle_initial' => strtoupper($faker->randomLetter),
		        'company_position' => 'CEO'
			]);

		    $contactInfo = ContactInfo::create([
		      'email' => $faker->email
		    ]);
		    $contactNumber = new ContactNumber([
		      'type' => $faker->numberBetween(1,3),
		      'number' => $faker->phoneNumber
		    ]);

		    $contactInfo->contactNumbers()->save($contactNumber);
			$representative->contactInfo()->save($contactInfo);
			$customer->representatives()->save($representative);
		}
	}

}
