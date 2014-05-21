<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MemberRoleRenameUserIdColumnToMemberId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('member_role', function($table) {
            $table->renameColumn('user_id', 'member_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('member_role', function($table) {
            $table->renameColumn('member_id', 'user_id');
        });
	}

}
