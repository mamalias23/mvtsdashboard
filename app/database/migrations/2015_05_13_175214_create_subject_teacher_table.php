<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubjectTeacherTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subject_teacher', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('subject_id', 36)->index();
			$table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
			$table->string('teacher_id', 36)->index();
			$table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subject_teacher');
	}

}
