<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFileFieldsToQuotationMaterialsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('quotation_materials', function(Blueprint $table) {     
            
            $table->timestamp('file_updated_at')->after('price_per_unit')->nullable();
            $table->string('file_content_type')->after('price_per_unit')->nullable();
            $table->integer('file_file_size')->after('price_per_unit')->nullable();
            $table->string('file_file_name')->after('price_per_unit')->nullable();

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotation_materials', function(Blueprint $table) {

            $table->dropColumn('file_file_name');
            $table->dropColumn('file_file_size');
            $table->dropColumn('file_content_type');
            $table->dropColumn('file_updated_at');

        });
    }

}
