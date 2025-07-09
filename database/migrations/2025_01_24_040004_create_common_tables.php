<?php

use App\Models\Bom\Pcf;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Process Classification Framework
        Schema::create('bom_pcf_tiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('level');
            $table->string('description');
            $table->timestamps();
        });
        Schema::create('bom_pcfs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('definition')->nullable();
            $table->string('hierarchy_code');
            $table->foreignId('accountable_id')->nullable()->constrained('org_job_positions')->onDelete('cascade');
            $table->foreignId('pcf_tier_id')->constrained('bom_pcf_tiers')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('bom_pcfs')->onDelete('cascade');
            $table->string('apqc');
            $table->string('shortcode');
            $table->timestamps();
        });
        // Schema::create('bom_pcf_exts', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->foreignId('pcf_id')->constrained('bom_pcfs')->onDelete('cascade');
        //     $table->foreignId('accountable_id')->nullable()->constrained('org_job_positions')->onDelete('cascade');
        //     $table->foreignId('responsible_id')->nullable()->constrained('org_job_roles')->onDelete('cascade');
        //     $table->timestamps();
        // });
        // Process Cluster
        Schema::create('bom_processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->json('workflow');
            $table->foreignId('pcf_id')->constrained('bom_pcfs')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('bom_turtles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('brief');
            $table->longText('description')->nullable();
            $table->foreignId('owner_id')->nullable()->constrained('org_job_positions')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('bom_turtles')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('bom_limbs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type'); // inputs, outputs, process, etc.
            $table->string('url')->nullable();
            $table->string('action')->nullable();
            $table->timestamps();
        });

        Schema::create('bom_limbables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('limb_id');
            $table->unsignedBigInteger('limbable_id');
            $table->string('limbable_type');
            $table->timestamps();
        });

        Schema::create('limb_role', function (Blueprint $table) {
            $table->id();
            $table->foreignId('limb_id')->constrained('bom_limbs')->onDelete('cascade');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->timestamps();
        });

        // Read JSON data
        // $jsonFilePath = url('https://raw.githubusercontent.com/bit-ecosystem/bites/refs/heads/main/curio/standards/2025_02_bom.json');
        // $jsonData = json_decode(file_get_contents($jsonFilePath), true);

        // // Seed data
        // DB::table('bom_pcf_tiers')->insert($jsonData['bom_pcf_tiers']);
        // // DB::table('bom_pcfs')->insert($jsonData['bom_pcfs']);
        // foreach ($jsonData['bom_pcfs'] as $positionData) {
        //     Pcf::create($positionData);
        // }
        // DB::table('bom_pcf_exts')->insert($jsonData['bom_pcf_exts']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('limb_role');
        Schema::dropIfExists('bom_limbables');
        Schema::dropIfExists('bom_limbs');
        Schema::dropIfExists('bom_turtles');
        Schema::dropIfExists('bom_processes');
        Schema::dropIfExists('bom_pcf_exts');
        Schema::dropIfExists('bom_pcfs');
        Schema::dropIfExists('bom_pcf_tiers');
    }
};
