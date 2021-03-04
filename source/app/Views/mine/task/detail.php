<?php $this->extend('layout/template'); ?>

<?php $this->section('content'); ?>

<!-- Tombol Kembali -->
<a href="/offices/<?= $office['officeIdentifier']; ?>" class="btn btn-danger mb-4">
    <i class="fas fa-arrow-left fa-fw"></i>
    Kembali
</a>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-body d-flex flex-row justify-content-between py-4">
        <div class="row no-gutters align-items-center">
            <div class="col-auto mr-4">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
            <div class="col">
                <small class="d-block mb-2">Dibuat <?= $task['taskCreatedAt']; ?> | Tenggat <?= $task['taskDeadlines']; ?></small>
                <h6 class="font-weight-bold"><?= $task['taskTitle']; ?></h6>
                <p class="m-0"><?= $task['taskDescription']; ?></p>
            </div>
        </div>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>/edit">Ubah</a>
                <a class="dropdown-item" href="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>" data-toggle="modal" data-target="#deleteModal">Hapus Tugas</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card mb-2">
            <div class="card-body row row-cols-1 justify-content-between py-4">
                <h6 class="font-weight-bold mb-4 col">Tugas Anggota</h6>

                <!-- tugas-tugas anggota yang diterima-->
                <?php foreach ($approvedAnswers as $approvedAnswer) : ?>

                    <div class="col mb-4">
                        <div class="row">
                            <div class="col-auto pr-1">
                                <img class="img-profile rounded-circle" src="/sb-admin-2/img/undraw_profile.svg" height="35px">
                            </div>
                            <div class="col mt-n1">
                                <p class="m-0 small pl-2"><?= $approvedAnswer['userFirstName'] . ' ' . $approvedAnswer['userLastName']; ?> (diterima)</p>
                                <div class="card bg-gray-100 d-inline-block mb-2">
                                    <div class="card-body py-1 px-3">
                                        <a href="/attachment/<?= $approvedAnswer['answerAttachment']; ?>" download class="btn btn-link"><?= $approvedAnswer['answerAttachment']; ?></a>
                                        <p class="m-0"><?= $approvedAnswer['answerBody']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

                <!-- tugas-tugas anggota yang menunggu persetujuan -->
                <?php foreach ($processAnswers as $processAnswer) : ?>

                    <div class="col mb-4">
                        <div class="row">
                            <div class="col-auto pr-1">
                                <img class="img-profile rounded-circle" src="/sb-admin-2/img/undraw_profile.svg" height="35px">
                            </div>
                            <div class="col mt-n1">
                                <p class="m-0 small pl-2"><?= $processAnswer['userFirstName'] . ' ' . $processAnswer['userLastName']; ?></p>
                                <div class="card bg-gray-100 d-inline-block mb-2">
                                    <div class="card-body py-1 px-3">
                                        <a href="/attachment/<?= $processAnswer['answerAttachment']; ?>" download class="btn btn-link"><?= $processAnswer['answerAttachment']; ?></a>
                                        <p class="m-0"><?= $processAnswer['answerBody']; ?></p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <form class="mr-2" action="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>/<?= $processAnswer['answerIdentifier']; ?>/is-approved" method="POST">
                                        <button class="btn btn-primary">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>/<?= $processAnswer['answerIdentifier']; ?>/is-approved" method="POST">
                                        <input type="hidden" name="_method" value="DELETE" />
                                        <button class="btn btn-danger">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
    <div class="col-lg">
        <div class="card mb-2">

            <div class="card-body row row-cols-1 justify-content-between py-4">

                <!-- komentar anggota -->
                <?php foreach ($comments as $comment) : ?>

                    <div class="col mb-3">
                        <div class="row">
                            <div class="col-auto pr-1">
                                <img class="img-profile rounded-circle" src="/sb-admin-2/img/undraw_profile.svg" height="35px">
                            </div>
                            <div class="col mt-n1">
                                <p class="m-0 small pl-2"><?= $comment['userFirstName'] . ' ' . $comment['userLastName']; ?></p>
                                <div class="card bg-gray-100 d-inline-block">
                                    <div class="card-body py-1 px-3">
                                        <p class="m-0"><?= $comment['commentBody']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

                <form class="col mt-4" action="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>/add-comment" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" id="exampleInputPassword1" required placeholder="Komentar Anda . . ." name="comment" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<!-- Modal Hapus Tugas -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin Ingin Menghapus Tugas?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Jika Anda menghapus tugas semua data kemajuan akan terhapus. Tindakan ini tidak dapat diurungkan!</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>" method="post">
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" class="btn btn-primary">Hapus Tugas</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>