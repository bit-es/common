<?php

use Bites\Common\Enums\LocationType;
use Bites\Common\Enums\MeasurementCategory;
use Bites\Common\Enums\MeasurementInputType;
use Bites\Common\Enums\MeasurementUnitType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurement_configs', function (Blueprint $table) {
            $table->id();
            $table->enum('category', array_column(MeasurementCategory::cases(), 'value'))->nullable();
            $table->string('for_model')->nullable();
            $table->string('segment')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('input_type', array_column(MeasurementInputType::cases(), 'value'))->nullable();
            $table->enum('unit_type', array_column(MeasurementUnitType::cases(), 'value'))->nullable();
            $table->string('input_option')->nullable();
            $table->string('unit_option')->nullable();
            $table->boolean('single_record')->default(true);
            $table->timestamps();
        });
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('measurement_config_id')->constrained()->cascadeOnDelete();
            $table->morphs('measurable');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('value')->nullable();
            $table->string('unit')->nullable();
            $table->timestamps();
        });
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('type', array_column(LocationType::cases(), 'value'));
            $table->foreignId('parent_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->morphs('movable'); // adds movable_type and movable_id
            $table->foreignId('from_location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('to_location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->timestamp('moved_at')->nullable();
            $table->timestamps();
        });
        Schema::create('snapshots', function (Blueprint $table) {
            $table->id();
            $table->morphs('snapshotable'); // typically user
            $table->string('photo_tag');
            $table->string('title');
            $table->string('value')->nullable(); // Store the value as a string
            $table->string('criteria')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable(); // Reference to parent attribute
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('snapshots');
        Schema::dropIfExists('movements');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('measurements');
        Schema::dropIfExists('measurement_configs');
    }
};
