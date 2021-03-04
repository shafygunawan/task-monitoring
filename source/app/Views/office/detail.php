<?php $this->extend('layout/template'); ?>

<?php $this->section('content'); ?>

<div class="col-sm">
    <!-- Tombol Kembali -->
    <a href="/offices" class="btn btn-danger mb-4">
        <i class="fas fa-arrow-left fa-fw"></i>
        Kembali
    </a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<!-- Dropdown Card Example -->
<div class="card bg-primary text-white shadow mb-4 office-card">
    <!-- Card Body -->
    <div class="card-body pb-5">
        <div class="d-flex flex-row align-items-center justify-content-between mb-3">
            <h6 class="m-0 font-weight-bold"><?= $office['officeName']; ?></h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="/offices/<?= $office['officeIdentifier']; ?>" data-toggle="modal" data-target="#leaveModal">Keluar Kantor</a>
                </div>
            </div>
        </div>
        <?= $office['officeDescription']; ?>
    </div>
</div>

<!-- Task Card -->
<?php foreach ($tasks as $task) : ?>

    <a href="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>">
        <div class="card mb-2">
            <div class="card-body d-flex flex-row justify-content-between py-4">
                <div class="row no-gutters align-items-center">
                    <div class="col-auto mr-4">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                    <div class="col">
                        <?= $task['taskTitle']; ?>
                        <small class="d-block"><?= $task['taskCreatedAt']; ?></small>
                    </div>
                </div>
            </div>
            <div class="card-footer p-1">
                <a href="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>" class="d-block py-2 px-4 text-muted small">Tambahkan komentar dinas</a>
            </div>
        </div>
    </a>

<?php endforeach; ?>

<!-- Modal Keluar Office -->
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingin Keluar dari Kantor?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Jika Anda keluar dari kantor semua tugas dan chat yang berkaitan dengan kantor akan dihapus. Tindakan ini tidak dapat diurungkan!</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="/offices/<?= $office['officeIdentifier']; ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" class="btn btn-primary">Keluar Kantor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>