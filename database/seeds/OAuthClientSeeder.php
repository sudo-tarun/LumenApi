<?php

use App\Course;
use App\Student;
use App\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OAuthClientSeeder extends Seeder
{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		for ($i = 0; $i < 10; $i++) {
			DB::table('oauth_clients')->insert(
				[
					'id' => "id$i",
					'secret' => "secret$i",
					'name' => "Test client $i"

				]
			);
		}
	}
}
