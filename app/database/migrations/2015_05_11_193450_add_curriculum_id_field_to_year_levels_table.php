<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCurriculumIdFieldToYearLevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('year_levels', function(Blueprint $table)
		{
			$table->string('curriculum_id', 36)->after('id');
			$table->foreign('curriculum_id')->references('id')->on('curriculums')->onDelete('cascade')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('year_levels', function(Blueprint $table)
		{
			$table->dropColumn('curriculum_id');
		});
	}

}
