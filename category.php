<?php
session_start();
require_once 'functions/helpers.php';
require_once 'functions/pdo_connection.php';
global $pdo;
global $category;
global $id;

if(isset($_GET['cat_id']) && $_GET['cat_id'] != ''){
    $query = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $query->execute([$_GET['cat_id']]);
    $category = $query->fetch();
    if($category){
        $id = $_GET['cat_id'];
    }
    else{
        $error = "Category not found";
    }
}
else{
    $error = "Category not found";
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
    <?php require_once 'layouts/top-nav.php'; ?>
    <section class="container my-5">

        <section class="row">
            <section class="col-12">
                <?php
                if(isset($error)){
                    echo "<h1>$error</h1>";
                }else{
                ?>
                <h1><?=$category->name?></h1>
                <?php } ?>
                <hr>
            </section>
        </section>
        <section class="row">
            <?php
            $query = "SELECT * FROM posts where cat_id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$id]);
            $posts = $stmt->fetchAll();
            if ($stmt->rowCount() > 0){


            foreach($posts as $post){
               ?>

            <section class="col-md-4">
                <section class="mb-2 overflow-hidden" style="max-height: 15rem;"><img class="img-fluid" src="<?=asset($post->image)?>" alt=""></section>
                <h2 class="h5 text-truncate"><?=$post->title?></h2>
                <p><?=substr($post->body,0,29)."..."?></p>
                <p><a class="btn btn-primary" href="<?=url('detail.php?id=')."$post->id"?>" role="button">نمایش خبر »</a></p>
            </section>
                <?php
            }
            }else{
            ?>
        </section>

        <section class="row">
            <section class="col-12">
                <h1>.اخباری برای این دسته بندی پیدا نشد</h1>
            </section>
        </section>
        <?php
        }
        ?>
    </section>
</section>


<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>