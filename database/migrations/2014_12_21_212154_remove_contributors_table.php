<?php

use Illuminate\Database\Migrations\Migration;

class RemoveContributorsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('contributors');
    }
}
