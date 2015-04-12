<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolRecordsPersonelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('school_personels_record', function($table) {
            $table->string('id', 36);
            $table->string('school_year_id', 36);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
            $table->primary('id');
            $table->foreign('school_year_id')->references('id')->on('school_year')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->engine = 'InnoDB';
        });

        DB::unprepared('CREATE TRIGGER school_personels_record_insert_trigger 
            BEFORE INSERT ON school_personels_record 
            FOR EACH ROW 
            BEGIN 
                SET NEW.created_at = CURRENT_TIMESTAMP(); 
                SET NEW.updated_at = CURRENT_TIMESTAMP(); 
            END;

            CREATE TRIGGER school_personels_record_update_trigger 
            BEFORE UPDATE ON school_personels_record 
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
		Schema::drop('school_personels_record');
        DB::unprepared('DROP TRIGGER IF EXISTS school_personels_record_insert_trigger;
            DROP TRIGGER IF EXISTS school_personels_record_update_trigger;');
	}

}
