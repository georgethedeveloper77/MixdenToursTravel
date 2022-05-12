<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Flight\Models\Airport;

class Update241To242 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(Airport::getTableName(), function (Blueprint $table) {
            if (!Schema::hasColumn(Airport::getTableName(), 'country')) {
                $table->string('country', 20)->nullable();
                $table->string('status', 30)->nullable()->default('publish');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
