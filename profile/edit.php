<?php
session_start();
require_once '../functions/helpers.php';
require_once '../functions/pdo_connection.php';
global $pdo;

//fill with old about
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$_SESSION['user']]);
$about = $stmt->fetch();

if ($about->phone == null) {
    $havephone = false;
}
else{
    $havephone = true;
}
//fill with old about


$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate first name
    $first_name = trim($_POST["first_name"]);
    if (empty($first_name)) {
        $errors[] = "نام الزامی است.";
    }

    // Validate last name
    $last_name = trim($_POST["last_name"]);
    if (empty($last_name)) {
        $errors[] = "نام خانوادگی الزامی است.";
    }

    // Validate age (between 10 and 120)
    $age = intval($_POST["age"]);
    if ($age < 10 || $age > 120) {
        $errors[] = "سن باید بین 10 تا 120 سال باشد.";
    }

    // Validate phone number (Iranian format: starts with 09 and has 11 digits)
    $phone = trim($_POST["phone"]);
    if (!preg_match("/^09[0-9]{9}$/", $phone)) {
        $errors[] = "شماره تلفن معتبر نیست. لطفاً یک شماره معتبر وارد کنید (مثال: 09031344366).";
    }

    // If no errors, update the database (this is just a placeholder, update according to your DB)
    if (empty($errors) && isset($_SESSION["user"])) {
        // Update query (modify based on your DB structure)
        $query = "UPDATE users SET first_name = ?, last_name = ?, age = ?, phone = ? WHERE email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$first_name, $last_name, $age, $phone, $_SESSION['user']]);

        // Redirect to profile page
        header("Location: " . url('profile'));
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ویرایش پروفایل</title>

    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
</head>
<body class="bg-light">

<section id="app">
    <?php require_once '../layouts/top-nav.php' ?>
</section>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg w-100" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="text-center text-primary mb-4">ویرایش پروفایل</h3>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form id="profileForm" action="<?=url("profile/edit.php")?>" method="POST">
                <div class="mb-3">
                    <label for="first_name" class="form-label">نام</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$about->first_name?>" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">نام خانوادگی</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$about->last_name?>" required>
                </div>
                <div class="mb-3">
                    <label for="age" class=" form-label">سن</label>
                    <input type="number" class=" text-center form-control" id="age" name="age" min="10" max="120" value="<?=$about->age?>" required>
                </div>
                <?php
                if($havephone)  {
                    ?>
                    <div class="mb-3">
                        <label for="phone" class="form-label">شماره تلفن</label>
                        <input  class="text-center form-control" name="phone" value="<?=$about->phone?>">
                    </div>
                        <?php
                }else{
                    ?>
                <div class="mb-3">
                    <label for="phone" class="form-label">شماره تلفن</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                    <div class="invalid-feedback">شماره تلفن باید 11 رقم باشد و با 09 شروع شود ❌</div>
                </div>
                <?php
                }
                ?>

                <!-- Add Profile Picture Input -->
                <div class="mb-3">
                    <label for="profile_pic" class="form-label">عکس پروفایل</label>
                    <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <a href="<?= url('profile') ?>" class="btn btn-secondary">بازگشت به پروفایل</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("phone").addEventListener("input", function() {
        let phoneInput = this;
        let phonePattern = /^09[0-9]{9}$/;  // شماره باید با 09 شروع شود و 11 رقم باشد

        if (phonePattern.test(phoneInput.value)) {
            phoneInput.classList.remove("is-invalid");
            phoneInput.classList.add("is-valid");
        } else {
            phoneInput.classList.remove("is-valid");
            phoneInput.classList.add("is-invalid");
        }
    });
</script>

</body>
</html>
