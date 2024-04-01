<?php

use App\Models\TestComponent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_components', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('sort');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });

        TestComponent::create([
            'name' => 'LISTENING',
            'sort' => 1,
            'created_by' => 1,
            'created_at' => now(),
        ]);
        TestComponent::create([
            'name' => 'SPEAKING',
            'sort' => 2,
            'created_by' => 1,
            'created_at' => now(),
        ]);
        TestComponent::create([
            'name' => 'READING',
            'sort' => 3,
            'created_by' => 1,
            'created_at' => now(),
        ]);
        TestComponent::create([
            'name' => 'WRITING',
            'sort' => 4,
            'created_by' => 1,
            'created_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_components');
    }
};
