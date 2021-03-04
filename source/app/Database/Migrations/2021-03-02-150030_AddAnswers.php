<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAnswers extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'answerId'          => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'answerBody' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'answerAttachment' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'answerIdentifier' => [
				'type' => 'CHAR',
				'constraint' => '24',
			],
			'answerStatus' => [
				'type' => 'ENUM("approved","process")',
			],
			'taskId' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'userId' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'answerCreatedAt' => [
				'type' => 'DATETIME',
			],
			'answerUpdatedAt' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('answerId', true);
		$this->forge->addForeignKey('taskId', 'tasks', 'taskId', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('userId', 'users', 'userId', 'CASCADE', 'CASCADE');
		$this->forge->createTable('answers');
	}

	public function down()
	{
		$this->forge->dropTable('answers');
	}
}
