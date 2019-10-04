<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->change();
            $table->string('username', 40)->default('');
            $table->string('password')->default('');
            $table->smallInteger('type', false, true)->default(1);
            $table->dateTime('created_at')->nullable()->default(null)->change();
            $table->dateTime('updated_at')->nullable()->default(null)->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('image_url', 'spam_count');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('github_url', 'github_username');
        });

        if (! app()->runningUnitTests()) {
            DB::statement('UPDATE users SET username = LOWER(name), github_username = name');
        }

        Schema::table('users', function (Blueprint $table) {
            $table->unique('username');
            $table->index('email');
            $table->index('username');
        });

        if (! app()->runningUnitTests()) {
            // Migrate moderators
            DB::statement('UPDATE users SET type = 2 WHERE id IN (
                SELECT user_id FROM role_user WHERE role_id = 2
            )');

            // Migrate admins
            DB::statement('UPDATE users SET type = 3 WHERE id IN (
                SELECT user_id FROM role_user WHERE role_id = 3
            )');
        }

        // Refactor replies
        Schema::rename('forum_replies', 'replies');
        Schema::table('replies', function (Blueprint $table) {
            $table->string('replyable_type')->default('');
            $table->dateTime('created_at')->nullable()->default(null)->change();
            $table->dateTime('updated_at')->nullable()->default(null)->change();
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
        Schema::table('replies', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('replies', function (Blueprint $table) {
            $table->index('author_id');
            $table->index('replyable_id');
            $table->integer('author_id')->unsigned()->change();
            $table->foreign('author_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
        });

        // Clean up forum threads
        Schema::rename('forum_threads', 'threads');
        Schema::table('threads', function (Blueprint $table) {
            $table->unique('slug');
            $table->dateTime('created_at')->nullable()->default(null)->change();
            $table->dateTime('updated_at')->nullable()->default(null)->change();
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
            $table->integer('author_id')->unsigned()->change();
            $table->foreign('author_id')
                ->references('id')->on('users')
                ->onDelete('CASCADE');
        });
        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn(
                'category_slug',
                'most_recent_reply_id',
                'reply_count',
                'is_question',
                'pinned',
                'laravel_version'
            );
        });
        Schema::table('threads', function (Blueprint $table) {
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

        // Make slugs lowercase
        if (! app()->runningUnitTests()) {
            DB::statement('UPDATE tags SET slug = LOWER(slug)');
        }

        Schema::table('taggables', function (Blueprint $table) {
            $table->string('taggable_type')->default('');
            $table->dateTime('created_at')->nullable()->default(null)->change();
            $table->dateTime('updated_at')->nullable()->default(null)->change();
        });
        Schema::table('taggables', function (Blueprint $table) {
            $table->dropIndex('tagged_items_thread_id_index');
            $table->dropIndex('tagged_items_tag_id_index');
        });
        Schema::table('taggables', function (Blueprint $table) {
            $table->renameColumn('thread_id', 'taggable_id');
        });

        if (! app()->runningUnitTests()) {
            DB::table('taggables')->update(['taggable_type' => 'threads']);
        }

        Schema::table('taggables', function (Blueprint $table) {
            $table->index('taggable_id');
            $table->index('tag_id');
            $table->integer('tag_id')->unsigned()->change();
            $table->foreign('tag_id')
                ->references('id')->on('tags')
                ->onDelete('CASCADE');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('forum', 'description');
            $table->unique('name');
            $table->unique('slug');
            $table->index('slug');
        });

        // Add new tags
        if (! app()->runningUnitTests()) {
            DB::table('tags')->insert([
                ['name' => 'Laravel', 'slug' => 'laravel'],
                ['name' => 'Lumen', 'slug' => 'lumen'],
                ['name' => 'Spark', 'slug' => 'spark'],
                ['name' => 'Forge', 'slug' => 'Forge'],
                ['name' => 'Envoyer', 'slug' => 'envoyer'],
                ['name' => 'Homestead', 'slug' => 'homestead'],
                ['name' => 'Valet', 'slug' => 'valet'],
                ['name' => 'Socialite', 'slug' => 'socialite'],
                ['name' => 'Mix', 'slug' => 'mix'],
                ['name' => 'Dusk', 'slug' => 'dusk'],
            ]);
        }

        // Remove unused tables
        Schema::drop('comments');
        Schema::drop('comment_tag');
        Schema::drop('pastes');
        Schema::drop('role_user');
        Schema::drop('roles');
    }
}
