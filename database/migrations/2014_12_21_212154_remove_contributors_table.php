<?php

use Illuminate\Database\Migrations\Migration;

class RemoveContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('contributors');
    }
}
