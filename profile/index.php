<?php
require_once '../functions/helpers.php';
session_start();
if (!isset($_SESSION['user'])){
redirect('auth/login.php');
}

require_once '../functions/pdo_connection.php';
global $err;
global $pdo;
global $row;


//change password handle

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $hash = password_hash($new_password, PASSWORD_DEFAULT);
    $query = 'SELECT password FROM users WHERE email = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user']]);
    $row = $stmt->fetch();
    if (password_verify($current_password, $row->password)) {
        if ($new_password == $confirm_password) {
            $query = 'UPDATE users SET password = ? WHERE email = ?';
            $stmt = $pdo->prepare($query);

            $stmt->execute([$hash, $_SESSION['user']]);
        }
    }
}

//change password handle

if (isset($_SESSION['user'])) {
    $user_email = $_SESSION['user'];
}
if (isset($_SESSION['admin'])) {
    $admin_email = $_SESSION['admin'];
}
if(isset($admin_email) && $admin_email != "" && $admin_email != null) {
  $query = "SELECT * FROM users WHERE email = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$admin_email]);
  $row = $stmt->fetch();
  if (!$row) {
      $err = "مشکلی در حساب کاربری شما وجود دارد.";
  }
}
if(isset($user_email) && $user_email != "" && $user_email != null) {
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_email]);
    $row = $stmt->fetch();
    if (!$row) {
        $err = "مشکلی در حساب کاربری شما وجود دارد.";
    }
}
?>
<!doctype html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>panel profile</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
</head>
<body class="bg-light text-end">

<section id="app">
    <?php require_once '../layouts/top-nav.php'; ?>
</section>

<?php if (isset($err) && $err != ""): ?>
    <div class="alert alert-danger text-center"><?= $err ?></div>
<?php endif; ?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg w-75 text-end" style="direction: rtl;">
        <div class="card-body">
            <h2 class="card-title text-center text-dark">اطلاعات حساب کاربری</h2>


            <!-- Profile Info Section -->
            <ul class="text-right list-group list-group-flush">
                <li class="list-group-item"><strong>نام:</strong> <?= $row->first_name ?></li>
                <li class="list-group-item"><strong>نام خانوادگی:</strong> <?= $row->last_name ?></li>
                <li class="list-group-item"><strong>ایمیل:</strong> <?= $row->email ?></li>
                <li class="list-group-item"><strong>موبایل:</strong> <?=!empty($row->phone) ? $row->phone : "ثبت نشده" ?></li>
                <li class="list-group-item"><strong> سن:</strong> <?= !empty($row->age) ? $row->age : "ثبت نشده" ?></li></ul>

            <!-- Edit Profile Button -->
            <div class="d-flex justify-content-center mt-3">
                <a href="<?= url('profile/edit.php') ?>" class="btn btn-primary">ویرایش پروفایل</a>
            </div>

            <!-- Change Password Section -->
            <div class="mt-5">
                <h3 class="text-center text-dark">تغییر رمز عبور</h3>
                <form action="<?=url('profile/index.php')?>" method="POST">
                    <div class="text-right mb-3">
                        <label for="current-password" class="form-label">رمز عبور فعلی</label>
                        <input type="password" class="form-control" id="current-password" name="current_password" required>
                    </div>
                    <div class="text-right mb-3">
                        <label  for="new-password" class="form-label">رمز عبور جدید</label>
                        <input type="password" class="form-control" id="new-password" name="new_password" required>
                    </div>
                    <div class="text-right mb-3">
                        <label for="confirm-password" class="form-label">تأیید رمز عبور جدید</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                    </div>
                    <div class=" d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">تغییر رمز عبور</button>
                    </div>
                </form>
            </div>

            <!-- Log Out Button -->
            <div class="d-flex justify-content-center mt-3">
                <a href="<?= url('auth/logout.php') ?>" class="btn btn-danger">خروج از حساب</a>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>
