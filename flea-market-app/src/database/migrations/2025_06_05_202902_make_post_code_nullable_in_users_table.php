<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePostCodeNullableInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('post_code')->nullable()->change();
            $table->string('address')->nullable()->change(); 
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('post_code')->nullable(false)->change();
            $table->string('address')->nullable(false)->change();
        });
    }
}
