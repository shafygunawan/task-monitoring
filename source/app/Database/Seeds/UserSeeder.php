<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use DateTime;

date_default_timezone_set('Asia/Jakarta');

class UserSeeder extends Seeder
{
	public function run()
	{
		$currentDateTime = new DateTime();
		$currentDateTime = Time::instance($currentDateTime);
		$currentDateTime = $currentDateTime->toDateTimeString();

		$userPassword = hash('sha256', 'admin');
		$data = [
			'userFirstName' => 'Shafy',
			'userLastName'    => 'Gunawan',
			'userEmail'    => 'shafygunawan@gmail.com',
			'userPassword'    => $userPassword,
			'userCreatedAt'    => $currentDateTime,
			'userUpdatedAt'    => $currentDateTime,
		];

		$this->db->table('users')->insert($data);
	}
}
