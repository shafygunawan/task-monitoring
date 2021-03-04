<?php $this->extend('layout/template'); ?>

<?php $this->section('content'); ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Kantor Saya</h1>

<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">

    <?php foreach ($myOffices as $myOffice) : ?>

        <div class="col">
            <!-- Dropdown Card Example -->
            <a href="/offices/<?= $myOffice['officeIdentifier']; ?>">
                <div class="card shadow mb-4 offices-card">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                        <h6 class="m-0 font-weight-bold text-white"><?= $myOffice['officeName']; ?></h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="/offices/<?= $myOffice['officeIdentifier']; ?>/create-task">Buat Tugas</a>
                                <a class="dropdown-item" href="/offices/<?= $myOffice['officeIdentifier']; ?>/edit">Ubah</a>
                                <a class="dropdown-item" href="/offices/<?= $myOffice['officeIdentifier']; ?>" data-toggle="modal" data-target="#deleteModal">Hapus Kantor</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <?= $myOffice['officeDescription']; ?>
                    </div>
                </div>
            </a>
        </div>

    <?php endforeach; ?>

</div>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Kantor</h1>

<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">

    <?php foreach ($notMyOffices as $notMyOffice) : ?>

        <div class="col">
            <!-- Dropdown Card Example -->
            <a href="/offices/<?= $notMyOffice['officeIdentifier']; ?>">
                <div class="card shadow mb-4 offices-card">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                        <h6 class="m-0 font-weight-bold text-white"><?= $notMyOffice['officeName']; ?></h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="/offices/<?= $notMyOffice['officeIdentifier']; ?>" data-toggle="modal" data-target="#leaveModal">Keluar Kantor</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <?= $notMyOffice['officeDescription']; ?>
                    </div>
                </div>
            </a>
        </div>

    <?php endforeach; ?>

</div>

<!-- Modal Hapus Office -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingin Menghapus Kantor?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Jika Kantor dihapus semua member akan dibubarkan. Tindakan ini tidak dapat diurungkan!</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form action="/offices" method="post">
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" class="btn btn-primary">Hapus Kantor</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
                <form action="/offices" method="post">
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" class="btn btn-primary">Keluar Kantor</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom JS -->
<script>
    // dapatkan element tombol delete dan form pada modal delete
    let deleteButtons = document.querySelectorAll('[data-target="#deleteModal"]');
    let deleteModal = document.querySelector('#deleteModal form');

    // ambil href dari tombol delete yang diklik kemudian jadikan sebagai action form pada modal delete
    deleteButtons.forEach(deleteButton => {
        deleteButton.addEventListener('click', () => {
            let actionLink = deleteButton.getAttribute('href');
            deleteModal.setAttribute('action', actionLink);
        });
    });

    // dapatkan element tombol leave dan form pada modal leave
    let leaveButtons = document.querySelectorAll('[data-target="#leaveModal"]');
    let leaveModal = document.querySelector('#leaveModal form');

    // ambil href dari tombol leave yang diklik kemudian jadikan sebagai action form modal leave
    leaveButtons.forEach(leaveButton => {
        leaveButton.addEventListener('click', () => {
            let actionLink = leaveButton.getAttribute('href');
            leaveModal.setAttribute('action', actionLink);
        });
    });
</script>

<?php $this->endSection(); ?>