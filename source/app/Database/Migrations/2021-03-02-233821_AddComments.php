<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddComments extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'commentId'          => [
				'type'           => 'INT',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'commentBody' => [
				'type' => 'TEXT',
			],
			'taskId' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'userId' => [
				'type'           => 'INT',
				'unsigned'       => true,
			],
			'commentCreatedAt' => [
				'type' => 'DATETIME',
			],
			'commentUpdatedAt' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addKey('commentId', true);
		$this->forge->addForeignKey('taskId', 'tasks', 'taskId', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('userId', 'users', 'userId', 'CASCADE', 'CASCADE');
		$this->forge->createTable('comments');
	}

	public function down()
	{
		$this->forge->dropTable('comments');
	}
}
