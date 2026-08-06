<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->foreignId('inspector_id')->constrained()->onDelete('cascade');
            $table->string('result')->nullable();
            $table->timestamps();
        });
        Schema::create('inspection_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->string('parameter')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
        Schema::create('non_conformities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('corrective_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('non_conformity_id')->constrained()->onDelete('cascade');
            $table->string('action')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspections');
        Schema::dropIfExists('inspection_results');
        Schema::dropIfExists('non_conformities');
        Schema::dropIfExists('corrective_actions');
    }
};
