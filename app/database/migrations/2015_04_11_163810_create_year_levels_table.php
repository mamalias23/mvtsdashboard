<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYearLevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::table('school_year')->delete();
		Schema::create('year_levels', function($table) {
            $table->string('id', 36);
            $table->string('school_year_id', 36);
            $table->integer('level');
            $table->string('description',100);
            $table->timestamps();
            $table->primary('id');
            $table->foreign('school_year_id')->references('id')->on('school_year')->onDelete('restrict')->onUpdate('cascade');
            $table->engine = 'InnoDB';
        });

        DB::unprepared('CREATE TRIGGER year_levels_insert_trigger 
            BEFORE INSERT ON year_levels 
            FOR EACH ROW 
            BEGIN 
                SET NEW.created_at = CURRENT_TIMESTAMP(); 
                SET NEW.updated_at = CURRENT_TIMESTAMP(); 
            END;

            CREATE TRIGGER year_levels_update_trigger 
            BEFORE UPDATE ON year_levels 
            FOR EACH ROW 
            BEGIN 
                SET NEW.created_at = OLD.created_at; 
                SET NEW.updated_at = CURRENT_TIMESTAMP(); 
            END;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('year_levels');
        DB::unprepared('DROP TRIGGER IF EXISTS year_levels_insert_trigger;
            DROP TRIGGER IF EXISTS year_levels_update_trigger;');
	}

}
