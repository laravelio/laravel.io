<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NextVersion extends Migration
{
    public function up()
    {
        // Purge soft deletes records
        if (! app()->runningUnitTests()) {
            DB::table('forum_replies')
                ->join('forum_threads', 'forum_replies.thread_id', '=', 'forum_threads.id')
                ->whereNotNull('forum_threads.deleted_at')
                ->delete();
            DB::table('tagged_items')
                ->join('forum_threads', 'tagged_items.thread_id', '=', 'forum_threads.id')
                ->whereNotNull('forum_threads.deleted_at')
                ->delete();
            DB::table('forum_threads')->whereNotNull('deleted_at')->delete();
            DB::table('forum_replies')->whereNotNull('deleted_at')->delete();
            DB::table('users')->whereNotNull('deleted_at')->delete();
            DB::table('tagged_items')->whereRaw('thread_id NOT IN (SELECT id FROM forum_threads)')->delete();
            DB::table('forum_threads')
                ->whereRaw('solution_reply_id NOT IN (SELECT id FROM forum_replies)')
                ->update(['solution_reply_id' => null]);
        }

        // Create password_resets table
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Clean up users
        Schema::table('users', function(Blueprint $table) {
            $table->string('email')->unique()->change();
            $table->string('username', 40)->default('');
            $table->string('password')->default('');
            $table->smallInteger('type', false, true)->default(1);
            $table->dateTime('created_at')->nullable()->default(NULL)->change();
            $table->dateTime('updated_at')->nullable()->default(NULL)->change();
        });
        Schema::table('users', function(Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('image_url');
        });

        if (! app()->runningUnitTests()) {
            DB::statement('UPDATE users SET username = name');
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
            $table->index('email');
            $table->index('username');
        });

        // Refactor replies
        Schema::rename('forum_replies', 'replies');
        Schema::table('replies', function (Blueprint $table) {
            $table->string('replyable_type')->default('');
            $table->dateTime('created_at')->nullable()->default(NULL)->change();
            $table->dateTime('updated_at')->nullable()->default(NULL)->change();
        });

        if (! app()->runningUnitTests()) {
            DB::table('replies')->update(['replyable_type' => 'threads']);
        }

        Schema::table('replies', function (Blueprint $table) {
            $table->dropIndex('forum_replies_author_id_index');
            $table->dropIndex('forum_replies_thread_id_index');
        });
        Schema::table('replies', function (Blueprint $table) {
            $table->renameColumn('thread_id', 'replyable_id');
        });
        Schema::table('replies', function(Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('replies', function (Blueprint $table) {
            $table->index('author_id');
            $table->index('replyable_id');
        });

        // Clean up forum threads
        Schema::rename('forum_threads', 'threads');
        Schema::table('threads', function (Blueprint $table) {
            $table->unique('slug');
            $table->dateTime('created_at')->nullable()->default(NULL)->change();
            $table->dateTime('updated_at')->nullable()->default(NULL)->change();
        });
        Schema::table('threads', function (Blueprint $table) {
            $table->dropIndex('forum_threads_author_id_index');
            $table->dropIndex('forum_threads_most_recent_reply_id_index');
            $table->dropIndex('forum_threads_solution_reply_id_index');
        });
        Schema::table('threads', function (Blueprint $table) {
            $table->integer('solution_reply_id')->unsigned()->change();
            $table->foreign('solution_reply_id')
                ->references('id')->on('replies')
                ->onDelete('SET NULL');
        });
        Schema::table('threads', function(Blueprint $table) {
            $table->dropColumn(
                'category_slug', 'most_recent_reply_id', 'reply_count', 'is_question', 'pinned', 'laravel_version'
            );
        });
        Schema::table('threads', function(Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('threads', function (Blueprint $table) {
            $table->index('author_id');
            $table->index('slug');
            $table->index('solution_reply_id');
        });

        // Refactor tags
        Schema::rename('tagged_items', 'taggables');

        // Fix timestamps on taggables
        if (! app()->runningUnitTests()) {
            DB::statement('UPDATE taggables, threads SET taggables.created_at = threads.created_at, taggables.updated_at = threads.updated_at WHERE taggables.thread_id = threads.id');
        }

        Schema::table('taggables', function(Blueprint $table) {
            $table->string('taggable_type')->default('');
            $table->dateTime('created_at')->nullable()->default(NULL)->change();
            $table->dateTime('updated_at')->nullable()->default(NULL)->change();
        });
        Schema::table('taggables', function (Blueprint $table) {
            $table->dropIndex('tagged_items_thread_id_index');
            $table->dropIndex('tagged_items_tag_id_index');
        });
        Schema::table('taggables', function(Blueprint $table) {
            $table->renameColumn('thread_id', 'taggable_id');
        });

        if (! app()->runningUnitTests()) {
            DB::table('taggables')->update(['taggable_type' => 'threads']);
        }

        Schema::table('taggables', function (Blueprint $table) {
            $table->index('taggable_id');
            $table->index('tag_id');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('forum');
            $table->unique('name');
            $table->unique('slug');
            $table->text('description')->nullable(false)->change();
            $table->index('slug');
        });

        // Remove unused tables
        Schema::drop('comments');
        Schema::drop('comment_tag');
        Schema::drop('pastes');
        Schema::drop('role_user');
        Schema::drop('roles');
    }
}
