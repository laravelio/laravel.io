<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class, 'author_id');

            $table->unsignedBigInteger('editable_id');
            $table->string('editable_type');

            $table->timestamp('edited_at');
        });
    }
}
