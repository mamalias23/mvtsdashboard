<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSectionIdOnStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('students', function(Blueprint $table)
		{
            $table->string('section_id', 36)->after('user_id');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('students', function(Blueprint $table)
		{
            $table->dropForeign('students_section_id_foreign');
            $table->dropColumn('section_id');
		});
	}

}
