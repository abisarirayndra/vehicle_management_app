<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->after('address')->unsigned();
            $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        DB::table('roles')->insert([

            'id' =>1,
            'role' =>'Admin',
        ]);
        DB::table('roles')->insert([

            'id' =>2,
            'role' =>'Manager',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
