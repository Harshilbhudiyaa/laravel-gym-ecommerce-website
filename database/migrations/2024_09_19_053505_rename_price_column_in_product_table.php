<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePriceColumnInProductTable extends Migration
{
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->renameColumn('Price', 'price'); // Rename 'Price' to 'price'
        });
    }

    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->renameColumn('price', 'Price'); // Revert back if needed
        });
    }
}