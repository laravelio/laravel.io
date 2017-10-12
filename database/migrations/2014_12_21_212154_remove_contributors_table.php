<?php

use Illuminate\Database\Migrations\Migration;

class RemoveContributorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('contributors');
    }
}
