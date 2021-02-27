<?php $this->extend('layout/template'); ?>

<?php $this->section('content'); ?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Semua Kantor</h1>

<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">

    <?php foreach ($offices as $office) : ?>

        <div class="col">
            <!-- Dropdown Card Example -->
            <a href="/offices/<?= $office['officeIdentifier']; ?>">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><?= $office['officeName']; ?></h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Keluar Kantor</a>
                                <a class="dropdown-item" href="#">Laporkan Penyalahgunaan</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <?= $office['officeDescription']; ?>
                    </div>
                </div>
            </a>
        </div>

    <?php endforeach; ?>

</div>

<?php $this->endSection(); ?>