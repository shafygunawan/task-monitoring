<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'userId'          => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'userFirstName'       => [
				'type'       => 'VARCHAR',
				'constraint' => '50',
			],
			'userLastName' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
			],
			'userEmail' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'userPassword' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'userCreatedAt' => [
				'type' => 'DATETIME',
			],
			'userUpdatedAt' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('userId', true);
		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
