<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('method', 10)->default('GET');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
