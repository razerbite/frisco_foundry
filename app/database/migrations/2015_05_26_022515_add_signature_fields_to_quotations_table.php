<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSignatureFieldsToQuotationsTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotations', function(Blueprint $table) {

            $table->dropColumn('signature');
            $table->timestamp('signature_updated_at')->after('price')->nullable();
            $table->string('signature_content_type')->after('price')->nullable();
            $table->integer('signature_file_size')->after('price')->nullable();
            $table->string('signature_file_name')->after('price')->nullable();

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotations', function(Blueprint $table) {

            $table->dropColumn('signature_file_name');
            $table->dropColumn('signature_file_size');
            $table->dropColumn('signature_content_type');
            $table->dropColumn('signature_updated_at');

        });
    }

}
