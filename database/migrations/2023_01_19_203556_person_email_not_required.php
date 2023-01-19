<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::table('attributes')->where('type', 'email')->update(['is_required' => 0]);
    }

    public function down()
    {
        DB::table('attributes')->where('type', 'email')->update(['is_required' => 1]);
    }
};
