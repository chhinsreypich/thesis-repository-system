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
        Schema::create('theses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('dept_id')->constrained('departments')->onDelete('cascade');
            $table->text('abstract');
            $table->text('description');

            // theses will be posted by "hods" or "student"
            // so using "User" table instead of "hods" table or "student" table 
            // note: "User" table contain all user roles (admin, hod, student) 
            $table->foreignId('posted_by')->constrained('users')->onDelete('cascade');

            // if thesis is posted by "hod" -> verify_by = null
            // if thesis is posted by "student" -> verify_by = hod_id (who verify the thesis)
            $table->foreignId('verify_by')->nullable()->constrained('hods')->nullOnDelete();

            $table->date('submission_date');
            $table->string('image')->nullable();
            $table->timestamps();


            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theses');
    }
};
