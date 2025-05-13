<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('carts', function ($table) {
            $table->string('size')->nullable()->after('product_id');
            $table->string('variant')->nullable()->after('size');
        });
    }

    public function down()
    {
        Schema::table('carts', function ($table) {
            $table->dropColumn(['size', 'variant']);
        });
    }

};
