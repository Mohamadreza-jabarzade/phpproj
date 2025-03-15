<?php
require_once '../../functions/helpers.php';
require_once '../../functions/check_login.php';
require_once '../../functions/pdo_connection.php';
global $pdo;

//show information handle

if (isset($_GET['id']) && is_numeric($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $query = 'SELECT * FROM `users` where `id` = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $user = $stmt->fetch();
}

?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اطلاعات کاربر</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
    <style>
        body {  text-align: right; }
    </style>
</head>
<body>
<section id="app">

    <?php require_once '../layouts/top-nav.php'; ?>

    <section class="container-fluid">
        <section class="row">
            <section class="col-md-2 p-0">
                <?php require_once '../layouts/sidebar.php'; ?>
            </section>
            <section class="col-md-10 pt-3">
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                                <div class="card-header bg-primary text-white text-center">
                                    <h4>اطلاعات کاربر</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="text-right list-group list-group-flush">
                                        <li class="text-right list-group-item"><?=$user->first_name?><strong> : نام </strong></li>
                                        <li class="text-right list-group-item"><?=$user->last_name?><strong> : نام خانوادگی </strong></li>
                                        <li class="list-group-item"><strong>: سن</strong><?=$user->age?></li>
                                        <li class="text-right list-group-item"><?=$user->email?><strong> : ایمیل </strong></li>
                                        <li class="list-group-item"><strong>: تلفن</strong><?=$user->phone?></li>

                                    </ul>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="#" class="btn btn-warning btn-sm">ویرایش</a>
                                    <a href="#" class="btn btn-danger btn-sm">حذف</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>

</section>

<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>
