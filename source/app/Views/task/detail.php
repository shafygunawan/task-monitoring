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
    </div>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card mb-2">
            <div class="card-body row row-cols-1 justify-content-between py-4">

                <!-- jawaban tugas saya -->
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h6 class="font-weight-bold mb-4">Tugas Anda</h6>
                        </div>
                        <div class="col">
                            <p class="text-right small"><?= (isset($answer['answerStatus'])) ? $answer['answerStatus'] : ''; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?php if (session()->getFlashdata('answerSuccess')) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= session()->getFlashdata('answerSuccess'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!isset($answer['answerStatus'])) : ?>

                        <form action="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>/create-answer" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="exampleFormControlFile1">Upload file</label>
                                <input type="file" class="form-control-file  <?= $validation->hasError('attachment') ? 'is-invalid' : ''; ?>" id="exampleFormControlFile1" name="attachment">
                                <div class="invalid-feedback">
                                    <?= $validation->getError('attachment'); ?>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control" id="exampleInputPassword1" name="description" placeholder="Deskripsi . . .">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                        </form>

                    <?php endif; ?>
                </div>

                <?php if (isset($answer)) : ?>

                    <div class="col mb-2">
                        <a href="/attachment/<?= $answer['answerAttachment']; ?>" class="btn btn-link"><?= $answer['answerAttachment']; ?></a>
                    </div>

                    <?php if ($answer['answerStatus'] == 'process') : ?>

                        <form action="/offices/<?= $office['officeIdentifier']; ?>/<?= $task['taskIdentifier']; ?>/<?= $answer['answerIdentifier']; ?>" method="POST" class="col">
                            <input type="hidden" name="_method" value="DELETE" />
                            <button class="btn btn-secondary btn-block">Batalkan Pengiriman</button>
                        </form>

                    <?php endif; ?>

                <?php endif; ?>

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

<?php $this->endSection(); ?>