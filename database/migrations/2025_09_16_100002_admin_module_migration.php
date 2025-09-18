<?php

use Bites\Common\Enums\OrgStructureType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->boolean('isCustomer')->default(false);
            $table->boolean('isSupplier')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('org_structures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->enum('type', array_column(OrgStructureType::cases(), 'value'));
            $table->foreignId('company_id')->constrained()->onDelete('cascade'); // Foreign key to company
            $table->foreignId('parent_id')->nullable()->constrained('org_structures')->onDelete('cascade'); // Self-referencing parent
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('job_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_structures_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('org_structures_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('home_location_id')->nullable()->constrained('locations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('cost_centers');
        Schema::dropIfExists('job_positions');
        Schema::dropIfExists('assets');
    }
};
