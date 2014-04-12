<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GithubTokensCreateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('github_tokens', function($t) {
            $t->create();
            $t->increments('id');
            $t->integer('user_id');
            $t->string('access_token');
            $t->string('granted_scopes');
            $t->string('token_type');
            $t->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('github_tokens');
	}

}
