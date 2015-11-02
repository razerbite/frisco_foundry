<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class LookupsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 3) as $index)
		{
			Lookups::create([
                'key' => 'industry_type',
                'key_id' => $index,
                'value' => 'Option ' . $index
			]);
		}

        // Contact number types - Contact numbers
        Lookups::create([ 'key'=>'customer_status', 'key_id'=>1, 'value'=>'Active' ]);
        Lookups::create([ 'key'=>'customer_status', 'key_id'=>2, 'value'=>'Inactive' ]);

        // Contact number types - Contact numbers
        Lookups::create([ 'key'=>'contact_no_type', 'key_id'=>1, 'value'=>'Mobile' ]);
        Lookups::create([ 'key'=>'contact_no_type', 'key_id'=>2, 'value'=>'Work' ]);
        Lookups::create([ 'key'=>'contact_no_type', 'key_id'=>3, 'value'=>'Landline' ]);

        // Unit of Measurements - Quotations
        Lookups::create([ 'key'=>'unit_of_measurement', 'key_id'=>1, 'value'=>'Piece' ]);
        Lookups::create([ 'key'=>'unit_of_measurement', 'key_id'=>2, 'value'=>'Set' ]);
        Lookups::create([ 'key'=>'unit_of_measurement', 'key_id'=>3, 'value'=>'Lot' ]);

        // Type of work - Quotations
        Lookups::create([ 'key'=>'type_of_work', 'key_id'=>1, 'value'=>'Fabrication' ]);
        Lookups::create([ 'key'=>'type_of_work', 'key_id'=>2, 'value'=>'Repair' ]);
        Lookups::create([ 'key'=>'type_of_work', 'key_id'=>3, 'value'=>'Supply' ]);
        Lookups::create([ 'key'=>'type_of_work', 'key_id'=>4, 'value'=>'Fabrication & Repair' ]);
        Lookups::create([ 'key'=>'type_of_work', 'key_id'=>5, 'value'=>'Supply & Repair' ]);
        Lookups::create([ 'key'=>'type_of_work', 'key_id'=>6, 'value'=>'Fabrication, Repair, & Supply' ]);

        // Contact number types - Contact numbers
        Lookups::create([ 'key'=>'quotation_status', 'key_id'=>1, 'value'=>'New' ]);
        Lookups::create([ 'key'=>'quotation_status', 'key_id'=>2, 'value'=>'Bill Of Materials' ]);
        Lookups::create([ 'key'=>'quotation_status', 'key_id'=>3, 'value'=>'Pending Approval' ]);
        Lookups::create([ 'key'=>'quotation_status', 'key_id'=>4, 'value'=>'Approved' ]);

        // Warranty duration - Contact numbers
        Lookups::create([ 'key'=>'warranty_duration', 'key_id'=>1, 'value'=>'Days' ]);
        Lookups::create([ 'key'=>'warranty_duration', 'key_id'=>2, 'value'=>'Months' ]);
        Lookups::create([ 'key'=>'warranty_duration', 'key_id'=>3, 'value'=>'Years' ]);

        // Discount types - Discounts
        Lookups::create([ 'key'=>'discount_type', 'key_id'=>1, 'value'=>'Percent' ]);
        Lookups::create([ 'key'=>'discount_type', 'key_id'=>2, 'value'=>'Pesos' ]);

        // Discount modifications - Discounts
        Lookups::create([ 'key'=>'discount_modification', 'key_id'=>1, 'value'=>'Lot Price' ]);
        Lookups::create([ 'key'=>'discount_modification', 'key_id'=>2, 'value'=>'Per Piece' ]);

	}

}
