<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->string('ok', 1000)->nullable()->after('name')->comment('Одноклассники');
            $table->string('avito', 1000)->nullable()->after('name');
            $table->string('instagram', 1000)->nullable()->after('name');
            $table->string('site', 1000)->nullable()->after('name')->comment('Сайт');
            $table->string('vk', 1000)->nullable()->after('name')->comment('vk.com');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn(['vk', 'site', 'avito', 'instagram', 'ok']);
        });
    }
};
