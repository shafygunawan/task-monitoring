<?php

namespace App\Controllers;

use App\Models\AffiliationModel;
use App\Models\AnswerModel;
use App\Models\CommentModel;
use App\Models\OfficeModel;
use App\Models\TaskModel;

class Answer extends BaseController
{
    protected $officeModel;
    protected $affiliationModel;
    protected $taskModel;
    protected $answerModel;
    protected $commentModel;

    public function __construct()
    {
        $this->officeModel = new OfficeModel();
        $this->affiliationModel = new AffiliationModel();
        $this->taskModel = new TaskModel();
        $this->answerModel = new AnswerModel();
        $this->commentModel = new CommentModel();
    }

    public function approved($taskIdentifier, $answerIdentifier)
    {
        $task = $this->taskModel->where('taskIdentifier', $taskIdentifier)->first();
        $oldAnswer = $this->answerModel->where('answerIdentifier', $answerIdentifier)->join('users', 'users.userId = answers.userId')->first();

        // kirim komentar tidak diterima
        $comment = [
            'commentBody' => $oldAnswer['userFirstName'] . ' ' . $oldAnswer['userLastName'] . ' tugas anda diterima:)',
            'taskId' => $task['taskId'],
            'userId' => session('id'),
        ];
        $this->commentModel->save($comment);

        // perbarui status jawaban
        $newAnswer = [
            'answerId' => $oldAnswer['answerId'],
            'answerBody' => $oldAnswer['answerBody'],
            'answerIdentifier' => $oldAnswer['answerIdentifier'],
            'answerStatus' => 'approved',
            'taskId' => $oldAnswer['taskId'],
            'userId' => $oldAnswer['userId']
        ];
        $this->answerModel->save($newAnswer);

        return redirect()->back();
    }

    public function notApproved($taskIdentifier, $answerIdentifier)
    {
        $task = $this->taskModel->where('taskIdentifier', $taskIdentifier)->first();
        $oldAnswer = $this->answerModel->where('answerIdentifier', $answerIdentifier)->join('users', 'users.userId = answers.userId')->first();

        // kirim komentar tidak diterima
        $comment = [
            'commentBody' => $oldAnswer['userFirstName'] . ' ' . $oldAnswer['userLastName'] . ' tugas anda tidak diterima tolong diperbarui:)',
            'taskId' => $task['taskId'],
            'userId' => session('id'),
        ];
        $this->commentModel->save($comment);

        // hapus jawaban
        $this->answerModel->delete($oldAnswer['answerId']);

        return redirect()->back();
    }

    public function save($officeIdentifier, $taskIdentifier)
    {
        // set rules untuk formulir dan pesan kesalahannya
        $rules = [
            'attachment' => 'uploaded[attachment]',
        ];
        $messages = [
            'attachment' => [
                'uploaded' => 'Lampiran tugas wajib diupload!'
            ],
        ];

        // cek apakah formulir tidak tervalidasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput();
        }

        // buat identifier dengan mengenkripsi waktu dan nama office
        $task = $this->taskModel->where('taskIdentifier', $taskIdentifier)->first();
        $answerIdentifier = substr(hash('sha256', time()), 0, 12) . substr(hash('sha256', $taskIdentifier), 0, 12);

        // ambil attachment dan simpan di folder attachment
        $attachment = $this->request->getFile('attachment');
        $attachment->move('attachment');

        // simpan tugas ke dalam database
        $answer = [
            'answerBody' => $_POST['description'],
            'answerAttachment' => $attachment->getName(),
            'answerIdentifier' => $answerIdentifier,
            'answerStatus' => 'process',
            'taskId' => $task['taskId'],
            'userId' => session('id'),
        ];
        $this->answerModel->save($answer);

        // set flashdata dan kembalikan ke halaman detail tugas baru
        session()->setFlashdata('answerSuccess', 'Tugas berhasil dikirim!');
        return redirect()->to('/offices//' . $officeIdentifier . '//' . $taskIdentifier);
    }

    public function delete($officeIdentifier, $taskIdentifier, $answerIdentifier)
    {
        $answer = $this->answerModel->where('answerIdentifier', $answerIdentifier)->first();

        // hapus jawaban
        $this->answerModel->delete($answer['answerId']);

        // set flashdata dan kembalikan ke halaman detail jawaban
        session()->setFlashdata('answerSuccess', 'Tugas Anda berhasil dihapus!');
        return redirect()->to('/offices//' . $officeIdentifier . '//' . $taskIdentifier);
    }
}
