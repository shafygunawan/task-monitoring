<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $title; ?></title>

    <!-- Custom fonts for this template-->
    <link href="/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/sb-admin-2/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                        <?php if (session()->getFlashdata('success')) : ?>
                                            <div class="alert alert-success" role="alert">
                                                <?= session()->getFlashdata('success'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (session()->getFlashdata('failed')) : ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?= session()->getFlashdata('failed'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <form class="user" method="POST" action="/">
                                        <?= csrf_field() ?>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Alamat Email" name="email" value="<?= old('email'); ?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('email'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" id="exampleInputPassword" placeholder="Password" name="password">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('password'); ?>
                                            </div>
                                        </div>
                                        <div class=" form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="rememberMe">
                                                <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Lupa Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="/register">Buat Akun!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/jquery/jquery.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/sb-admin-2/js/sb-admin-2.min.js"></script>

</body>

</html>