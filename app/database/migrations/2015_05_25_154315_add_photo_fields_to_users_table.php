<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPhotoFieldsToUsersTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {

            $table->dropColumn('photo');
            $table->string('photo_file_name')->after('status')->nullable();
            $table->integer('photo_file_size')->after('status')->nullable();
            $table->string('photo_content_type')->after('status')->nullable();
            $table->timestamp('photo_updated_at')->after('status')->nullable();

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {

            $table->dropColumn('photo_file_name');
            $table->dropColumn('photo_file_size');
            $table->dropColumn('photo_content_type');
            $table->dropColumn('photo_updated_at');

        });
    }

}
