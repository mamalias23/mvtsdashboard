<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnnouncementsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announcements', function(Blueprint $table)
		{
            $table->string('id', 36);
            $table->string('school_year_id', 36);
            $table->integer('sender_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->enum('status', array(1,2,3))->default(1); //1 = pending, 2 = approved, 3 = rejected
			$table->timestamps();
            $table->primary('id');
            $table->foreign('school_year_id')->references('id')->on('school_year')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->engine = 'InnoDB';
		});

        DB::unprepared('CREATE TRIGGER announcements_insert_trigger
            BEFORE INSERT ON announcements
            FOR EACH ROW
            BEGIN
                SET NEW.created_at = CURRENT_TIMESTAMP();
                SET NEW.updated_at = CURRENT_TIMESTAMP();
            END;

            CREATE TRIGGER announcements_update_trigger
            BEFORE UPDATE ON announcements
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
		Schema::drop('announcements');
        DB::unprepared('DROP TRIGGER IF EXISTS announcements_insert_trigger;
            DROP TRIGGER IF EXISTS announcements_update_trigger;');
	}

}
