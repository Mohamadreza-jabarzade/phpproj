<?php
global $pdo;
require_once "../../functions/helpers.php";
require "../../functions/pdo_connection.php";
require_once '../../functions/check_login.php';

if(!isset($_GET["id"])){
    redirect("panel/category");
}
if(isset($_GET["id"]) && !empty($_GET["id"])){
    $query = "SELECT * FROM categories WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET["id"]]);
    $row = $stmt->fetch();
}
if(isset($_POST["name"]) && !empty($_POST["name"])){
    $query = "UPDATE categories SET name = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST["name"], $_GET["id"]]);
    redirect("panel/category");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP panel</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
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

                <form action="<?=url('panel/category/edit.php?id=')."$row->id"?>" method="post">
                    <section class="form-group">
                        <label for="name">نام</label>

                        <input type="text" value="<?=$row->name?>" class="form-control" name="name" id="name" placeholder="name ..." value="">
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">بروزرسانی</button>
                    </section>
                </form>

            </section>
        </section>
    </section>

</section>

<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>