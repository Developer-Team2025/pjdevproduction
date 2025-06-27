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
        Schema::connection('greyzone_consulting')->create('google_sheet_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('inquiry_type')->nullable();
            $table->string('country')->default('Africa');
            $table->boolean('accept_privacy')->default(false);
            $table->timestamp('date_now')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('greyzone_consulting')->dropIfExists('google_sheet_submissions');
    }
};
