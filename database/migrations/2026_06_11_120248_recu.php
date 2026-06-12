<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recu_id')->nullable()->constrained('recu')->nullOnDelete();
            $table->string('text_source');
            $table->json('payload_ia')->nullable();
            $table->string('status')->default('en_attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recu');
    }
};
