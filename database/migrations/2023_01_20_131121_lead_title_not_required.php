<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('title', 255)->nullable()->after('id')->change();
        });
        DB::table('attributes')
            ->where('code', 'title')
            ->where('entity_type', 'leads')
            ->update(['is_required' => 0]);
    }

    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('title', 255)->after('id')->change();
        });
        DB::table('attributes')
            ->where('code', 'title')
            ->where('entity_type', 'leads')
            ->update(['is_required' => 1]);
    }
};
