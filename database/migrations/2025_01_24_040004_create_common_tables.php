<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cmn_notes', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->morphs('noteable');
            $table->timestamps();
        });

        Schema::create('cmn_photos', function (Blueprint $table) {
            $table->id();
            $table->morphs('imageable');
            $table->string('key');
            $table->string('title');
            $table->string('value')->nullable(); // Store the value as a string
            $table->string('criteria')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable(); // Reference to parent attribute
            $table->timestamps();
        });

        Schema::create('cmn_files', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('name');
            $table->string('type')->nullable();
            $table->morphs('fileable');
            $table->timestamps();
        });

        Schema::create('cmn_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->morphs('taskable');
            $table->timestamps();
        });

        Schema::create('cmn_measurements', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->decimal('value', 10, 2);
            $table->string('unit')->nullable();
            $table->morphs('measurable');
            $table->timestamps();
        });
        Schema::create('cmn_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamp('start');
            $table->timestamp('end')->nullable();
            $table->string('url')->nullable();
            $table->string('color')->nullable();
            $table->boolean('all_day')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cmn_notes');
        Schema::dropIfExists('cmn_photos');
        Schema::dropIfExists('cmn_files');
        Schema::dropIfExists('cmn_tasks');
        Schema::dropIfExists('cmn_measurements');
        Schema::dropIfExists('cmn_events');
    }
};
