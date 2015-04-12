<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table) {
            $table->string('username')->after('email');
            $table->string('middle_initial',1)->after('last_name');
            $table->enum('gender',array('male','female'))->after('middle_initial');
            $table->date('birthdate')->after('gender');
            $table->string('mobile_number',14)->after('birthdate');
            $table->string('full_address')->after('mobile_number');
            $table->string('picture')->after('full_address');
        });

        DB::unprepared('CREATE TRIGGER users_insert_trigger 
            BEFORE INSERT ON users 
            FOR EACH ROW 
            BEGIN 
                SET NEW.created_at = CURRENT_TIMESTAMP(); 
                SET NEW.updated_at = CURRENT_TIMESTAMP(); 
            END;

            CREATE TRIGGER users_update_trigger 
            BEFORE UPDATE ON users 
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
		Schema::table('users', function($table) {
            $table->dropColumn('username');
            $table->dropColumn('middle_initial');
            $table->dropColumn('gender');
            $table->dropColumn('birthdate');
            $table->dropColumn('mobile_number');
            $table->dropColumn('full_address');
            $table->dropColumn('picture');
        });

        DB::unprepared('DROP TRIGGER IF EXISTS users_insert_trigger;
            DROP TRIGGER IF EXISTS users_update_trigger;');
	}

}
