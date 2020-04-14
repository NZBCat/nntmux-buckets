<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::table('users', function (Blueprint $table) {
         // Setting the default to -1 so it doesn't accidentally resolve to a valid entity.
         // Not able to use ->nullable because we want it to fail if an invalid role is resolved.
         $table->integer('role_id')->default(-1);
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      // For some reason SQLite does not like this but since it is only a test migration I feel fine leaving the
      // 'down' method empty.
//      Schema::table('users', function (Blueprint $table) {
//         $table->dropColumn(['role_id']);
//      });
   }
}
