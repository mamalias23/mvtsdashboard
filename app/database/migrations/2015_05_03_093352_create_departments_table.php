<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('departments', function(Blueprint $table)
		{
			$table->string('id', 36);
			$table->string('school_year_id', 36);
			$table->string('name');
			$table->foreign('school_year_id')->references('id')->on('school_year')->onDelete('restrict')->onUpdate('cascade');
			$table->timestamps();
			$table->primary('id');
			$table->engine = 'InnoDB';
		});

		DB::unprepared('CREATE TRIGGER departments_insert_trigger 
            BEFORE INSERT ON departments 
            FOR EACH ROW 
            BEGIN 
                SET NEW.created_at = CURRENT_TIMESTAMP(); 
                SET NEW.updated_at = CURRENT_TIMESTAMP(); 
            END;

            CREATE TRIGGER departments_update_trigger 
            BEFORE UPDATE ON departments 
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
		Schema::drop('departments');
		DB::unprepared('DROP TRIGGER IF EXISTS departments_insert_trigger;
            DROP TRIGGER IF EXISTS departments_update_trigger;');
	}

}
