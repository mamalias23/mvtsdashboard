<?php

class SentryGroupSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('groups')->delete();

		Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Students',
		        'permissions' => array(
		            'student' => 1,
		            'parents' => 0,
		            'guard' => 0,
		            'others' => 0,
		            'school_records_personel' => 0,
		            'department_heads' => 0,
		            'registrar' => 0,
		            'curriculum_departments' => 0,
		            'teachers' => 0,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Parents or Guardians',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 1,
		            'guard' => 0,
		            'others' => 0,
		            'school_records_personel' => 0,
		            'department_heads' => 0,
		            'registrar' => 0,
		            'curriculum_departments' => 0,
		            'teachers' => 0,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Guards',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 0,
		            'guard' => 1,
		            'others' => 0,
		            'school_records_personel' => 0,
		            'department_heads' => 0,
		            'registrar' => 0,
		            'curriculum_departments' => 0,
		            'teachers' => 0,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Other Staffs',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 0,
		            'guard' => 0,
		            'others' => 1,
		            'school_records_personel' => 0,
		            'department_heads' => 0,
		            'registrar' => 0,
		            'curriculum_departments' => 0,
		            'teachers' => 0,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'School Records Personel',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 0,
		            'guard' => 0,
		            'others' => 0,
		            'school_records_personel' => 1,
		            'department_heads' => 0,
		            'registrar' => 0,
		            'curriculum_departments' => 0,
		            'teachers' => 0,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Department Heads',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 0,
		            'guard' => 0,
		            'others' => 0,
		            'school_records_personel' => 0,
		            'department_heads' => 1,
		            'registrar' => 0,
		            'curriculum_departments' => 0,
		            'teachers' => 0,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Registrars',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 0,
		            'guard' => 0,
		            'others' => 0,
		            'school_records_personel' => 0,
		            'department_heads' => 0,
		            'registrar' => 1,
		            'curriculum_departments' => 0,
		            'teachers' => 0,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Curriculum departments',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 0,
		            'guard' => 0,
		            'others' => 0,
		            'school_records_personel' => 0,
		            'department_heads' => 0,
		            'registrar' => 0,
		            'curriculum_departments' => 1,
		            'teachers' => 0,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Teachers',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 0,
		            'guard' => 0,
		            'others' => 0,
		            'school_records_personel' => 0,
		            'department_heads' => 0,
		            'registrar' => 0,
		            'curriculum_departments' => 0,
		            'teachers' => 1,
		            'alumni' => 0,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Alumni',
		        'permissions' => array(
		            'student' => 0,
		            'parents' => 0,
		            'guard' => 0,
		            'others' => 0,
		            'school_records_personel' => 0,
		            'department_heads' => 0,
		            'registrar' => 0,
		            'curriculum_departments' => 0,
		            'teachers' => 0,
		            'alumni' => 1,
		            'admin' => 0,
		        )
		    )
        );

        Sentry::getGroupProvider()->create(
			array(
		        'name'        => 'Admin',
		        'permissions' => array(
		            'student' => 1,
		            'parents' => 1,
		            'guard' => 1,
		            'others' => 1,
		            'school_records_personel' => 1,
		            'department_heads' => 1,
		            'registrar' => 1,
		            'curriculum_departments' => 1,
		            'teachers' => 1,
		            'alumni' => 1,
		            'admin' => 1,
		        )
		    )
        );

		
	}

}