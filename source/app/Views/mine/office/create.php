<?php $this->extend('layout/template'); ?>

<?php $this->section('content'); ?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Buat Kantor</h1>

<!-- Outer Row -->
<form method="POST" action="/offices/create">
    <?= csrf_field() ?>
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Kantor</label>
        <div class="col-sm-10">
            <input type="text" class="form-control <?= $validation->hasError('name') ? 'is-invalid' : ''; ?>" id="inputEmail3" name="name" value="<?= old('name'); ?>">
            <div class="invalid-feedback">
                <?= $validation->getError('name'); ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label">Deskripsi</label>
        <div class="col-sm-10">
            <textarea class="form-control <?= $validation->hasError('description') ? 'is-invalid' : ''; ?>" id="exampleFormControlTextarea1" rows="3" name="description"><?= old('description'); ?></textarea>
            <div class="invalid-feedback">
                <?= $validation->getError('description'); ?>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm">
            <a href="/offices" type="submit" class="btn btn-danger px-4">Batal</a>
        </div>
        <div class="col-sm text-right">
            <button type="submit" class="btn btn-primary px-4">Buat</button>
        </div>
    </div>
</form>

<?php $this->endSection(); ?>