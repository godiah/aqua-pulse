<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->enum('level', ['info', 'warning', 'error', 'critical'])->default('info');
            $table->string('type')->nullable(); // e.g., 'mqtt_error', 'connection_error', etc.
            $table->string('message');
            $table->text('details')->nullable(); // JSON or additional details
            $table->string('source')->default('mqtt'); // mqtt, javascript, system, etc.
            $table->timestamp('logged_at')->useCurrent();
            $table->timestamps();

            // Indexes for faster queries
            $table->index('device_id');
            $table->index('level');
            $table->index('logged_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_logs');
    }
};
