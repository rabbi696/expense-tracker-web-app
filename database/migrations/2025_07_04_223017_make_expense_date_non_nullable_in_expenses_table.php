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
        Schema::table('expenses', function (Blueprint $table) {
            // Update existing null values to a default before making it non-nullable
            // For example, set to current date or a specific past date
            \DB::table('expenses')->whereNull('expense_date')->update(['expense_date' => now()]);

            $table->date('expense_date')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->date('expense_date')->nullable()->change();
        });
    }
};
