<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAffiliations extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'affiliationId'          => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'userId' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'officeId' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'affiliationLevel' => [
				'type' => 'ENUM("admin","member")',
			],
			'affiliationCreatedAt' => [
				'type' => 'DATETIME',
			],
			'affiliationUpdatedAt' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('affiliationId', true);
		$this->forge->addForeignKey('userId', 'users', 'userId', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('officeId', 'offices', 'officeId', 'CASCADE', 'CASCADE');
		$this->forge->createTable('affiliations');
	}

	public function down()
	{
		$this->forge->dropTable('affiliations');
	}
}
