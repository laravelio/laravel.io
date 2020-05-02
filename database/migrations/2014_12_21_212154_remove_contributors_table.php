<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class RemoveContributorsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('contributors');
    }
}
