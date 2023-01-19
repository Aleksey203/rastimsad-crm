<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->string('instagram', 255)->nullable()->after('contact_numbers');
            $table->string('telegram', 255)->nullable()->after('contact_numbers');
            $table->string('vk', 255)->nullable()->after('contact_numbers')->comment('vk.com');
            $table->longText('emails')->nullable()->after('name')->change();
        });
    }

    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->longText('emails')->after('name')->change();
            $table->dropColumn(['vk', 'telegram', 'instagram']);
        });
    }
};
