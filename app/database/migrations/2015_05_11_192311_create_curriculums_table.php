<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurriculumsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('curriculums', function(Blueprint $table)
		{
			$table->string('id', 36);
			$table->string('name');
			$table->integer('user_id')->unsigned();
			$table->string('school_year_id', 36);
			$table->foreign('school_year_id')->references('id')->on('school_year')->onDelete('restrict')->onUpdate('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
			$table->timestamps();
			$table->primary('id');
			$table->engine = 'InnoDB';
		});

		DB::unprepared('CREATE TRIGGER curriculums_insert_trigger 
            BEFORE INSERT ON curriculums 
            FOR EACH ROW 
            BEGIN 
                SET NEW.created_at = CURRENT_TIMESTAMP(); 
                SET NEW.updated_at = CURRENT_TIMESTAMP(); 
            END;

            CREATE TRIGGER curriculums_update_trigger 
            BEFORE UPDATE ON curriculums
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
		Schema::drop('curriculums');
		DB::unprepared('DROP TRIGGER IF EXISTS curriculums_insert_trigger;
            DROP TRIGGER IF EXISTS curriculums_update_trigger;');
	}

}
