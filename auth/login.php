<?php
session_start();
global $pdo;
require_once '../functions/helpers.php';
require_once '../functions/pdo_connection.php';
global $err;

if (isset($_SESSION['user']) || isset($_SESSION['admin'])) {
    unset($_SESSION['user']);
    unset($_SESSION['admin']);
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        if (strlen($_POST["password"]) < 8 ) {
            $err = "حداقل طول کاراکتر های رمز باید 8 رقم باشد";
        }else{
        $query = "select * from users where email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_POST['email']]);
        $row = $stmt->fetch();
        if ($row) {
            if (password_verify($_POST['password'], $row->password)) {
                if ($row->admin === 1){
                    $_SESSION['admin'] = $row->email;
                    redirect('panel');
                }
                else {
                    $_SESSION['user'] = $row->email;
                    redirect('index.php');
                }
            }
        }
        else {
            $err = "نام کاربری یا رمز عبور اشتباه است";
        }
        }
        }else{
            $err = "لطفا یک ایمیل معتبر وارد کنید";
        }
    }
    else{
        $err = "لطفا فرم را کامل پر کنید";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP tutorial</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
</head>

<body>
<section id="app">

    <section style="height: 100vh; background-color: #138496;" class="d-flex justify-content-center align-items-center">
        <section style="width: 20rem;">
            <h1 class="bg-warning text-center rounded-top px-2 mb-0 py-3 h5">خوش آمدید</h1>
            <section class="bg-light my-0 px-2"><small class="text-danger"><?php
                    if (isset($err) && $err != "" && $err != null) {
                        echo $err;
                    }
                    ?></small></section>
            <form class="pt-3 pb-1 px-2 bg-light rounded-bottom" action="<?=url('auth/login.php')?>" method="post">
                <section class="text-right form-group">
                    <label for="email">ایمیل</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="example@gmail.com" required>
                </section>
                <section class="text-right form-group">
                    <label for="password">رمز عبور</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="password...">
                </section>
                <section class="mt-4 mb-2 d-flex justify-content-between">
                    <input type="submit" class="btn w-25 p-1 text-center btn-success btn-sm" value="ورود">
                    <a class="" href="<?=url('auth/register.php')?>">ثبت نام</a>
                </section>
            </form>
        </section>
    </section>

</section>
<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>