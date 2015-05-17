<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTeacherIdToSectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sections', function(Blueprint $table)
		{
			$table->string('teacher_id', 36)->nullable()->after('year_level_id');
			$table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sections', function(Blueprint $table)
		{
			$table->dropForeign('sections_teacher_id_foreign');
			$table->dropColumn('teacher_id');
		});
	}

}
