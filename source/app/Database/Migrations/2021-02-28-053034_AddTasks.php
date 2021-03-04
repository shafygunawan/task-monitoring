<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTasks extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'taskId'          => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'taskTitle' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
			],
			'taskDescription' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'taskDeadlines' => [
				'type' => 'DATETIME',
			],
			'taskIdentifier' => [
				'type' => 'CHAR',
				'constraint' => '24',
			],
			'officeId' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'affiliationId' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'taskCreatedAt' => [
				'type' => 'DATETIME',
			],
			'taskUpdatedAt' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('taskId', true);
		$this->forge->addForeignKey('officeId', 'offices', 'officeId', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('affiliationId', 'affiliations', 'affiliationId', 'CASCADE', 'CASCADE');
		$this->forge->createTable('tasks');
	}

	public function down()
	{
		$this->forge->dropTable('tasks');
	}
}
