<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolYearTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('school_year', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
			$table->engine = 'InnoDB';
		});

		DB::unprepared('CREATE TRIGGER school_year_insert_trigger 
			BEFORE INSERT ON school_year 
			FOR EACH ROW 
			BEGIN 
				SET NEW.created_at = CURRENT_TIMESTAMP(); 
				SET NEW.updated_at = CURRENT_TIMESTAMP(); 
			END;

			CREATE TRIGGER school_year_update_trigger 
			BEFORE UPDATE ON school_year 
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
		Schema::drop('school_year');
		DB::unprepared('DROP TRIGGER IF EXISTS school_year_insert_trigger;
			DROP TRIGGER IF EXISTS school_year_update_trigger;');
	}

}
