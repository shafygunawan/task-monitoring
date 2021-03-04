<?php

namespace App\Filters;

use App\Models\OfficeModel;
use App\Models\TaskModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class TaskFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // ambil identifier tugas
        $taskIdentifier = current_url(true)->getPath();
        $taskIdentifier = substr($taskIdentifier, 33, 24);
        // ambil identifier office
        $officeIdentifier = current_url(true)->getPath();
        $officeIdentifier = substr($officeIdentifier, 8, 24);

        // cek apakah identifier tugas = create-task
        if ($taskIdentifier == 'create-task') {
            return;
        }

        // cek apakah tugas identifier cocok dengan data asli
        $officeModel = new OfficeModel();
        $office = $officeModel->where('officeIdentifier', $officeIdentifier)->first();
        $taskModel = new TaskModel();
        $task = $taskModel->where([
            'taskIdentifier' => $taskIdentifier,
            'officeId' => $office['officeId']
        ])->first();

        // cek apakah tugas tidak ada
        if (!isset($task)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman yang Anda cari tidak ditemukan!');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
