<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('activities', function(Blueprint $table)
		{
            $table->string('id', 36);
            $table->integer('user_id')->unsigned();
            $table->string('type');
            $table->string('title');
            $table->text('body');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
			$table->timestamps();
            $table->primary('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->engine = 'InnoDB';
		});

        DB::unprepared('CREATE TRIGGER activities_insert_trigger
            BEFORE INSERT ON activities
            FOR EACH ROW
            BEGIN
                SET NEW.created_at = CURRENT_TIMESTAMP();
                SET NEW.updated_at = CURRENT_TIMESTAMP();
            END;

            CREATE TRIGGER activities_update_trigger
            BEFORE UPDATE ON activities
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
		Schema::drop('activities');
        DB::unprepared('DROP TRIGGER IF EXISTS activities_insert_trigger;
            DROP TRIGGER IF EXISTS activities_update_trigger;');
	}

}
