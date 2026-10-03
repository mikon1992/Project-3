<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')
                ->constrained('activities');
            $table->string('participant_name', 120);
            $table->string('email', 150);
            $table->timestamp('registered_at');
            $table->timestamps();

            $table->unique(['activity_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
