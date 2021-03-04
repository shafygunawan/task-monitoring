<?php

namespace App\Controllers;

use App\Models\AffiliationModel;
use App\Models\AnswerModel;
use App\Models\CommentModel;
use App\Models\OfficeModel;
use App\Models\TaskModel;

class Task extends BaseController
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

    public function detail($officeIdentifier, $taskIdentifier)
    {
        $task = $this->taskModel->where('taskIdentifier', $taskIdentifier)->first();

        // cek apakah user saat ini bukan admin kantor
        if (!$this->currentUserIsAdmin($officeIdentifier)) {
            $answer = $this->answerModel->where([
                'taskId' => $task['taskId'],
                'userId' => session('id')
            ])->first();

            $data = [
                'title' => 'Detail Tugas | Task Monitoring',
                'currentUser' => $this->getCurrentUser(),
                'myOffices' => $this->getCurrentUserOffices(true),
                'notMyOffices' => $this->getCurrentUserOffices(),
                'office' => $this->officeModel->where('officeIdentifier', $officeIdentifier)->first(),
                'validation' => \Config\Services::validation(),
                'task' => $task,
                'answer' => $answer,
                'comments' => $this->commentModel->where('taskId', $task['taskId'])->join('users', 'users.userId = comments.userId')->orderBy('commentId', 'ASC')->findAll()
            ];

            return view('task/detail', $data);
        }

        $approvedAnswers = $this->answerModel->where([
            'taskId' => $task['taskId'],
            'answerStatus' => 'approved'
        ])->join('users', 'users.userId = answers.userId')->findAll();
        $processAnswers = $this->answerModel->where([
            'taskId' => $task['taskId'],
            'answerStatus' => 'process'
        ])->join('users', 'users.userId = answers.userId')->findAll();

        $data = [
            'title' => 'Detail Tugas | Task Monitoring',
            'currentUser' => $this->getCurrentUser(),
            'myOffices' => $this->getCurrentUserOffices(true),
            'notMyOffices' => $this->getCurrentUserOffices(),
            'office' => $this->officeModel->where('officeIdentifier', $officeIdentifier)->first(),
            'validation' => \Config\Services::validation(),
            'task' => $task,
            'approvedAnswers' => $approvedAnswers,
            'processAnswers' => $processAnswers,
            'comments' => $this->commentModel->where('taskId', $task['taskId'])->join('users', 'users.userId = comments.userId')->orderBy('commentId', 'ASC')->findAll()
        ];

        return view('mine/task/detail', $data);
    }

    public function create($officeIdentifier)
    {
        // cek apakah user saat ini bukan admin kantor
        if (!$this->currentUserIsAdmin($officeIdentifier)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman yang Anda cari tidak ditemukan');
        }

        $data = [
            'title' => 'Buat Tugas | Task Monitoring',
            'currentUser' => $this->getCurrentUser(),
            'myOffices' => $this->getCurrentUserOffices(true),
            'notMyOffices' => $this->getCurrentUserOffices(),
            'office' => $this->officeModel->where('officeIdentifier', $officeIdentifier)->first(),
            'validation' => \Config\Services::validation()
        ];

        return view('mine/task/create', $data);
    }

    public function save($officeIdentifier)
    {
        // set rules untuk formulir dan pesan kesalahannya
        $rules = [
            'title' => 'required',
            'deadlines' => 'required'
        ];
        $messages = [
            'title' => [
                'required' => 'Judul Tugas wajib diisi'
            ],
            'deadlines' => [
                'required' => 'Akhir Pengumpulan wajib diisi'
            ]
        ];

        // cek apakah formulir tidak tervalidasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput();
        }

        // buat identifier dengan mengenkripsi waktu dan nama office
        $office = $this->officeModel->where('officeIdentifier', $officeIdentifier)->first();
        $taskIdentifier = substr(hash('sha256', time()), 0, 12) . substr(hash('sha256', $office['officeName']), 0, 12);

        $affiliation = $this->affiliationModel->where([
            'userId' => session('id'),
            'officeId' => $office['officeId']
        ])->first();

        // simpan tugas ke dalam database
        $newTask = [
            'taskTitle' => $_POST['title'],
            'taskDescription' => $_POST['description'],
            'taskDeadlines' => $_POST['deadlines'],
            'taskIdentifier' => $taskIdentifier,
            'officeId' => $office['officeId'],
            'affiliationId' => $affiliation['affiliationId'],
        ];
        $this->taskModel->save($newTask);

        // set flashdata dan kembalikan ke halaman detail tugas baru
        session()->setFlashdata('success', 'Tugas berhasil dibuat!');
        return redirect()->to('/offices//' . $office['officeIdentifier'] . '//' . $taskIdentifier);
    }

    public function edit($officeIdentifier, $taskIdentifier)
    {
        // cek apakah user saat ini bukan admin kantor
        if (!$this->currentUserIsAdmin($officeIdentifier)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman yang Anda cari tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Tugas | Task Monitoring',
            'currentUser' => $this->getCurrentUser(),
            'myOffices' => $this->getCurrentUserOffices(true),
            'notMyOffices' => $this->getCurrentUserOffices(),
            'validation' => \Config\Services::validation(),
            'office' => $this->officeModel->where('officeIdentifier', $officeIdentifier)->first(),
            'task' => $this->taskModel->where('taskIdentifier', $taskIdentifier)->first()
        ];

        return view('mine/task/edit', $data);
    }

    public function update($officeIdentifier, $taskIdentifier)
    {
        // set rules untuk formulir dan pesan kesalahannya
        $rules = [
            'title' => 'required',
            'deadlines' => 'required'
        ];
        $messages = [
            'title' => [
                'required' => 'Judul Tugas wajib diisi!'
            ],
            'deadlines' => [
                'required' => 'Akhir Pengumpulan wajib diisi!'
            ]
        ];

        // cek apakah formulir tidak tervalidasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput();
        }

        // perbarui tugas
        $oldTask = $this->taskModel->where('taskIdentifier', $taskIdentifier)->first();
        $newTask = [
            'taskId' => $oldTask['taskId'],
            'taskTitle' => $_POST['title'],
            'taskDescription' => $_POST['description'],
            'taskDeadlines' => $_POST['deadlines'],
            'taskIdentifier' => $oldTask['taskIdentifier'],
            'officeId' => $oldTask['officeId'],
            'affiliationId' => $oldTask['affiliationId'],
        ];
        $this->taskModel->save($newTask);

        // set flashdata dan kembalikan ke halaman detail tugas
        session()->setFlashdata('success', 'Tugas berhasil diperbarui!');
        return redirect()->to('/offices//' . $officeIdentifier . '//' . $taskIdentifier);
    }

    public function delete($officeIdentifier, $taskIdentifier)
    {
        $task = $this->taskModel->where('taskIdentifier', $taskIdentifier)->first();

        // hapus tugas
        $this->taskModel->delete($task['taskId']);

        // set flashdata dan kembalikan ke halaman detail tugas
        session()->setFlashdata('success', 'Tugas berhasil dihapus!');
        return redirect()->to('/offices//' . $officeIdentifier);
    }

    public function addComment($taskIdentifier)
    {
        // simpan komentar ke database
        $newComment = [
            'commentBody' => $_POST['comment'],
            'taskId' => $this->taskModel->where('taskIdentifier', $taskIdentifier)->first()['taskId'],
            'userId' => session('id'),
        ];
        $this->commentModel->save($newComment);

        return redirect()->back();
    }
}
