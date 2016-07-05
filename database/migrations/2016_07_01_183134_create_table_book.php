<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBook extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('isbn', 13);
            $table->string('author', 100);
            $table->string('title', 100);
            $table->decimal('rating')->nullable();
            $table->date('release_date');
            
            $table->timestamps();
            
            /*$table->unique('isbn');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('book');
    }

}
