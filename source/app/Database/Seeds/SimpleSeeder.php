<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use DateTime;

date_default_timezone_set('Asia/Jakarta');

class SimpleSeeder extends Seeder
{
	public function run()
	{
		$currentDateTime = new DateTime();
		$currentDateTime = Time::instance($currentDateTime);
		$currentDateTime = $currentDateTime->toDateTimeString();

		// user seeder
		$userPassword = hash('sha256', 'admin123');
		$data = [
			'userFirstName' => 'Shafy',
			'userLastName'    => 'Gunawan',
			'userEmail'    => 'shafygunawan@gmail.com',
			'userPassword'    => $userPassword,
			'userCreatedAt'    => $currentDateTime,
			'userUpdatedAt'    => $currentDateTime,
		];

		$this->db->table('users')->insert($data);

		// office seeder
		$officeName = 'Kecamatan Pademawu';
		$officeIdentifier = substr(hash('sha256', time()), 0, 12) . substr(hash('sha256', 'Kecamatan Pademawu'), 0, 12);
		$officeInvitationCode = substr(hash('sha256', time()), 0, 6);
		$data = [
			'officeName' => $officeName,
			'officeDescription' => 'Kantor Kecamatan Pademawu untuk mengontrol tugas dibawah kecamatan',
			'officeIdentifier' => $officeIdentifier,
			'officeInvitationCode' => $officeInvitationCode,
			'officeCreatedAt' => $currentDateTime,
			'officeUpdatedAt' => $currentDateTime,
		];

		$this->db->table('offices')->insert($data);

		// affiliation seeder
		$data = [
			'userId' => 1,
			'officeId' => 1,
			'affiliationLevel' => 'admin',
			'affiliationCreatedAt' => $currentDateTime,
			'affiliationUpdatedAt' => $currentDateTime,
		];

		$this->db->table('affiliations')->insert($data);
	}
}
