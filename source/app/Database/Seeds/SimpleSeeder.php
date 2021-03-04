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
			[
				'userFirstName' => 'Shafy',
				'userLastName'    => 'Gunawan',
				'userEmail'    => 'shafygunawan@gmail.com',
				'userPassword'    => $userPassword,
				'userCreatedAt'    => $currentDateTime,
				'userUpdatedAt'    => $currentDateTime,
			],
			[
				'userFirstName' => 'Mukhlis',
				'userLastName'    => 'Rahman',
				'userEmail'    => 'mukhlisrahman@gmail.com',
				'userPassword'    => $userPassword,
				'userCreatedAt'    => $currentDateTime,
				'userUpdatedAt'    => $currentDateTime,
			],
		];

		$this->db->table('users')->insertBatch($data);

		// office seeder
		$officeName = 'Kecamatan Pademawu';
		$officeIdentifier = substr(hash('sha256', time()), 0, 12) . substr(hash('sha256', $officeName), 0, 12);
		$officeInvitationCode = substr(hash('sha256', time() + 60), 0, 6);

		$officeName2 = 'Kecamatan Galis';
		$officeIdentifier2 = substr(hash('sha256', time() + 60), 0, 12) . substr(hash('sha256', $officeName2), 0, 12);
		$officeInvitationCode2 = substr(hash('sha256', time() + 60 + 60), 0, 6);

		$data = [
			[
				'officeName' => $officeName,
				'officeDescription' => 'Kantor Kecamatan Pademawu untuk mengontrol tugas dibawah kecamatan',
				'officeIdentifier' => $officeIdentifier,
				'officeInvitationCode' => $officeInvitationCode,
				'officeCreatedAt' => $currentDateTime,
				'officeUpdatedAt' => $currentDateTime,
			],
			[
				'officeName' => $officeName2,
				'officeDescription' => 'Kantor Kecamatan Galis untuk mengontrol tugas dibawah kecamatan',
				'officeIdentifier' => $officeIdentifier2,
				'officeInvitationCode' => $officeInvitationCode2,
				'officeCreatedAt' => $currentDateTime,
				'officeUpdatedAt' => $currentDateTime,
			]
		];

		$this->db->table('offices')->insertBatch($data);

		// affiliation seeder
		$data = [
			[
				'userId' => 1,
				'officeId' => 1,
				'affiliationLevel' => 'admin',
				'affiliationCreatedAt' => $currentDateTime,
				'affiliationUpdatedAt' => $currentDateTime,
			],
			[
				'userId' => 2,
				'officeId' => 2,
				'affiliationLevel' => 'admin',
				'affiliationCreatedAt' => $currentDateTime,
				'affiliationUpdatedAt' => $currentDateTime,
			],
			[
				'userId' => 1,
				'officeId' => 2,
				'affiliationLevel' => 'member',
				'affiliationCreatedAt' => $currentDateTime,
				'affiliationUpdatedAt' => $currentDateTime,
			]
		];

		$this->db->table('affiliations')->insertBatch($data);

		// task seeder
		$data = [
			'taskTitle' => 'Tugas Pertama',
			'taskDescription' => 'Ini adalah tugas pertama',
			'taskDeadlines' => $currentDateTime,
			'taskIdentifier' => substr(hash('sha256', time() + 60), 0, 12) . substr(hash('sha256', $officeName), 0, 12),
			'officeId' => 1,
			'affiliationId' => 1,
			'taskCreatedAt' => $currentDateTime,
			'taskUpdatedAt' => $currentDateTime,
		];

		$this->db->table('tasks')->insert($data);
	}
}
