<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSomeFieldsOnUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->boolean('guardian')->after('picture')->nullable();
            $table->string('guardian_full_name')->after('guardian')->nullable();
            $table->string('guardian_mobile', 14)->after('guardian_full_name')->nullable();

            $table->boolean('mother')->after('guardian_mobile')->nullable();
            $table->string('mother_full_name')->after('mother')->nullable();
            $table->string('mother_mobile', 14)->after('mother_full_name')->nullable();

            $table->boolean('father')->after('mother_mobile')->nullable();
            $table->string('father_full_name')->after('father')->nullable();
            $table->string('father_mobile', 14)->after('father_full_name')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
            $table->dropColumn('guardian');
            $table->dropColumn('guardian_full_name');
            $table->dropColumn('guardian_mobile');
            $table->dropColumn('mother');
            $table->dropColumn('mother_full_name');
            $table->dropColumn('mother_mobile');
            $table->dropColumn('father');
            $table->dropColumn('father_full_name');
            $table->dropColumn('father_mobile');
		});
	}

}
