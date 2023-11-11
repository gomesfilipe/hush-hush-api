<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Evaluation;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->enum('status', Evaluation::statusEvaluationValues());
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('comment_id')->constrained()->cascadeOnDelete();
            $table->unique(['user_id', 'comment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
