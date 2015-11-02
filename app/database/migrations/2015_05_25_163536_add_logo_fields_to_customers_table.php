<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLogoFieldsToCustomersTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function(Blueprint $table) {

            $table->timestamp('logo_updated_at')->after('status')->nullable();
            $table->string('logo_content_type')->after('status')->nullable();
            $table->integer('logo_file_size')->after('status')->nullable();
            $table->string('logo_file_name')->after('status')->nullable();

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function(Blueprint $table) {

            $table->dropColumn('logo_file_name');
            $table->dropColumn('logo_file_size');
            $table->dropColumn('logo_content_type');
            $table->dropColumn('logo_updated_at');

        });
    }

}
