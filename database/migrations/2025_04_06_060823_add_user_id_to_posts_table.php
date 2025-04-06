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
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // create the column

            // Throws Execption but when adding nullable to the previous line it will not
            $table->foreign('user_id')->references('id')->on('users'); // apply foreign key contrains
        });
    }

    
};
