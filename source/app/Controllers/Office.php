<?php

namespace App\Controllers;

use App\Models\AffiliationModel;
use App\Models\OfficeModel;
use App\Models\TaskModel;

class Office extends BaseController
{
    protected $officeModel;
    protected $affiliationModel;

    public function __construct()
    {
        $this->officeModel = new OfficeModel();
        $this->affiliationModel = new AffiliationModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Semua Kantor | Task Monitoring',
            'currentUser' => $this->getCurrentUser(),
            'myOffices' => $this->getCurrentUserOffices(true),
            'notMyOffices' => $this->getCurrentUserOffices(),
        ];

        return view('office/index', $data);
    }

    public function detail($officeIdentifier)
    {
        $office = $this->officeModel->where('officeIdentifier', $officeIdentifier)->first();

        $taskModel = new TaskModel();
        $tasks = $taskModel->where('officeId', $office['officeId'])->orderBy('taskId', 'DESC')->findAll();

        $data = [
            'title' => 'Offices | Task Monitoring',
            'currentUser' => $this->getCurrentUser(),
            'myOffices' => $this->getCurrentUserOffices(true),
            'notMyOffices' => $this->getCurrentUserOffices(),
            'office' => $office,
            'tasks' => $tasks,
        ];

        // cek apakah user saat ini bukan admin kantor
        if (!$this->currentUserIsAdmin($officeIdentifier)) {
            return view('office/detail', $data);
        }

        return view('mine/office/detail', $data);
    }

    public function join()
    {
        // cek apakah kode undangan kantor tidak benar
        $office = $this->officeModel->where('officeInvitationCode', $_POST['invitationCode'])->first();
        if (!isset($office)) {
            return false;
        }

        // cek apakah user saat ini telah bergabung ke kantor
        $affiliation = $this->affiliationModel->where([
            'userId' => session('id'),
            'officeId' => $office['officeId']
        ])->first();
        if (isset($affiliation)) {
            return false;
        }

        // simpan keanggotaan baru user saat ini
        $newAffiliation = [
            'userId' => session('id'),
            'officeId' => $office['officeId'],
            'affiliationLevel' => 'member'
        ];
        $this->affiliationModel->save($newAffiliation);

        // set flashdata dan kembalikan pengenal kantor
        session()->setFlashdata('success', 'Anda telah bergabung dengan kantor!');
        return $office['officeIdentifier'];
    }

    public function create()
    {
        $data = [
            'title' => 'Buat Kantor | Task Monitoring',
            'currentUser' => $this->getCurrentUser(),
            'myOffices' => $this->getCurrentUserOffices(true),
            'notMyOffices' => $this->getCurrentUserOffices(),
            'validation' => \Config\Services::validation()
        ];

        return view('mine/office/create', $data);
    }

    public function save()
    {
        // set rules untuk formulir dan pesan kesalahannya
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name' => [
                'required' => 'Nama Kantor wajib diisi'
            ]
        ];

        // cek apakah formulir tidak tervalidasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput();
        }

        // buat identifier dan invitation code dengan mengenkripsi waktu dan nama office
        $officeName = $_POST['name'];
        $officeIdentifier = substr(hash('sha256', time()), 0, 12) . substr(hash('sha256', $officeName), 0, 12);
        $officeInvitationCode = substr(hash('sha256', time() + 60 * 60), 0, 6);

        // simpan kantor ke dalam database
        $newOffice = [
            'officeName' => $officeName,
            'officeDescription' => $_POST['description'],
            'officeIdentifier' => $officeIdentifier,
            'officeInvitationCode' => $officeInvitationCode
        ];
        $this->officeModel->save($newOffice);

        // simpan affiliation ke dalam databse
        $office = $this->officeModel->where('officeIdentifier', $officeIdentifier)->first();
        $newAffiliation = [
            'userId' => session('id'),
            'officeId' => $office['officeId'],
            'affiliationLevel' => 'admin'
        ];
        $this->affiliationModel->save($newAffiliation);

        // set flashdata dan kembalikan ke halaman detail kantor baru
        session()->setFlashdata('success', 'Kantor berhasil dibuat!');
        return redirect()->to('/offices//' . $office['officeIdentifier']);
    }

    public function edit($officeIdentifier)
    {
        // cek apakah user saat ini bukan admin kantor
        if (!$this->currentUserIsAdmin($officeIdentifier)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman yang anda cari tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Kantor | Task Monitoring',
            'currentUser' => $this->getCurrentUser(),
            'myOffices' => $this->getCurrentUserOffices(true),
            'notMyOffices' => $this->getCurrentUserOffices(),
            'validation' => \Config\Services::validation(),
            'office' => $this->officeModel->where('officeIdentifier', $officeIdentifier)->first()
        ];

        return view('mine/office/edit', $data);
    }

    public function update($officeIdentifier)
    {
        // set rules untuk formulir dan pesan kesalahannya
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name' => [
                'required' => 'Nama Kantor wajib diisi'
            ]
        ];

        // cek apakah formulir tidak tervalidasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput();
        }


        $oldOffice = $this->officeModel->where('officeIdentifier', $officeIdentifier)->first();
        // simpan kantor baru ke dalam database
        $newOffice = [
            'officeId' => $oldOffice['officeId'],
            'officeName' => $_POST['name'],
            'officeDescription' => $_POST['description'],
            'officeIdentifier' => $oldOffice['officeIdentifier'],
            'officeInvitationCode' => $oldOffice['officeInvitationCode']
        ];
        $this->officeModel->save($newOffice);

        // set flashdata dan kembalikan ke halaman detail kantor baru
        session()->setFlashdata('success', 'Kantor berhasil diperbarui!');
        return redirect()->to('/offices//' . $officeIdentifier);
    }

    public function leave($officeIdentifier)
    {
        $office = $this->officeModel->where('officeIdentifier', $officeIdentifier)->first();

        // cek apakah user saat ini bukan admin kantor
        if (!$this->currentUserIsAdmin($officeIdentifier)) {

            // hapus kenggotaan user saat ini
            $affiliation = $this->affiliationModel->where([
                'userId' => $this->getCurrentUser()['userId'],
                'officeId' => $office['officeId']
            ])->first();
            $this->affiliationModel->delete($affiliation['affiliationId']);

            // set flashdata dan kembalikan ke halaman semua kantor
            session()->setFlashdata('success', 'Anda telah keluar dari kantor!');
            return redirect()->to('/offices');
        }

        // hapus kantor dan hapus semua keanggotaan pada kantor
        $this->affiliationModel->where('officeId', $office['officeId'])->delete();
        $this->officeModel->delete($office['officeId']);

        // set flashdata dan kembalikan ke halaman semua kantor
        session()->setFlashdata('success', 'Kantor berhasil dihapus!');
        return redirect()->to('/offices');
    }
}
