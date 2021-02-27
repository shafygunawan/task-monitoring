<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOffices extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'officeId'          => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'officeName'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
			],
			'officeDescription' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'officeIdentifier' => [
				'type' => 'CHAR',
				'constraint' => '24',
			],
			'officeInvitationCode' => [
				'type' => 'CHAR',
				'constraint' => '6',
			],
			'officeCreatedAt' => [
				'type' => 'DATETIME',
			],
			'officeUpdatedAt' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('officeId', true);
		$this->forge->createTable('offices');
	}

	public function down()
	{
		$this->forge->dropTable('offices');
	}
}
