<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name', 40)->nullable();
            $table->string('bio', 150)->nullable();
            $table->string('url')->nullable();
            $table->string('image', 100)->default("profile/9urmwoiffoe8fum8effisehfefjaw98ummffefc4hlw7.jpeg");
            $table->timestamps();
            $table->index('user_id');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
