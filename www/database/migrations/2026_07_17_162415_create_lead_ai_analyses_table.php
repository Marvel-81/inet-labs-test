<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lead_ai_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')
                ->constrained('leads')
                ->onDelete('cascade');
            $table->string('parameter', 100);
            $table->text('decoded_value');
            $table->timestamps();


            $table->index(['lead_id', 'parameter']);
            $table->index('parameter');

            $table->unique(['lead_id', 'parameter']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_ai_analyses');
    }
};
