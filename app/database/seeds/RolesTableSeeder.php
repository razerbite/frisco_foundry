<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class RolesTableSeeder extends Seeder {

	public function run()
	{
		$admin = Role::firstOrCreate(['name'=>'Admin']);
		$secretary = Role::firstOrCreate(['name'=>'Secretary']);
		$technicalReviewer = Role::firstOrCreate(['name'=>'Technical Reviewer']);
		$executive = Role::firstOrCreate(['name'=>'Executive']);
    $procurement = Role::firstOrCreate(['name'=>'Procurement']);

    // Users
    $manageUsers = Permission::firstOrCreate([
      'name' => 'manage_users',
      'display_name' => 'Manage users'
    ]);

    // Customers
    $manageCustomers = Permission::firstOrCreate([
      'name' => 'manage_customers',
      'display_name' => 'Manage customers'
    ]);

    // Quotations
    $viewSales = Permission::firstOrCreate([
      'name' => 'view_sales',
      'display_name' => 'View sales module'
    ]);
    $createQuotations = Permission::firstOrCreate([
      'name' => 'create_quotations',
      'display_name' => 'Create quotations'
    ]);
    $viewQuotationRequest = Permission::firstOrCreate([
      'name' => 'view_request',
      'display_name' => 'View quotation request'
    ]);
    $editQuotationRequest = Permission::firstOrCreate([
      'name' => 'edit_request',
      'display_name' => 'Edit quotation request'
    ]);

    // Bill of materials
    $viewBom = Permission::firstOrCreate([
      'name' => 'view_bom',
      'display_name' => 'View bill of materials'
    ]);
    $editBom = Permission::firstOrCreate([
      'name' => 'edit_bom',
      'display_name' => 'Review quotations'
    ]);

    // Approval
    $viewApproval = Permission::firstOrCreate([
      'name' => 'view_approval',
      'display_name' => 'View approval'
    ]);
    $editApproval = Permission::firstOrCreate([
      'name' => 'edit_approval',
      'display_name' => 'Approve quotations'
    ]);
    $seePricing = Permission::firstOrCreate([
      'name' => 'see_pricing',
      'display_name' => 'See prices'
    ]);

    // Summary
    $viewSummary = Permission::firstOrCreate([
      'name' => 'view_summary',
      'display_name' => 'View quotation summary'
    ]);
    $editSummary = Permission::firstOrCreate([
      'name' => 'edit_summary',
      'display_name' => 'Edit quotation summary'
    ]);

    // Direct Award
    $directAward = Permission::firstOrCreate([
      'name' => 'direct_award',
      'display_name' => 'Can issue direct awards'
    ]);

    $admin->perms()->sync([
      $manageUsers->id
    ]);

    $secretary->perms()->sync([
      $viewSales->id,
      $manageCustomers->id,
      $viewQuotationRequest->id,
      $editQuotationRequest->id,
      $createQuotations->id,
      $viewSummary->id,
      $editSummary->id
    ]);

    $technicalReviewer->perms()->sync([
      $viewSales->id,
      $viewBom->id,
      $editBom->id,
      $directAward->id
    ]);

    $executive->perms()->sync([
      $viewSales->id,
      $manageCustomers->id,
      $editQuotationRequest->id,
      $viewQuotationRequest->id,
      $viewBom->id,
      $editBom->id,
      $viewApproval->id,
      $editApproval->id,
      $seePricing->id,
      $viewSummary->id,
      $editSummary->id,
      $directAward->id
    ]);

    $procurement->perms()->sync([
      $viewSales->id,
      $seePricing->id
    ]);

	}

}
