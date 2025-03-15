<?php
session_start();
global $pdo;
global $have;
global $date_post;
global $post;
global $thisuser;
require_once 'functions/helpers.php';
require_once 'functions/pdo_connection.php';

    //comment insert ----------
    if (isset($_POST['comment']) && !empty($_POST['comment']) && isset($_GET['id']) && !empty($_GET['id'])) {
        $comment = $_POST['comment'];
        $post_id = $_GET['id'];
        $user_id = $_POST['id'];
        $query = 'INSERT INTO comments (text, post_id, user_id,created_at) VALUES(?, ?, ?,now())';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$comment, $post_id, $user_id]);
    }
    //comment insert ----------

    //comment show ----------


    $query = 'SELECT comments.*, users.first_name 
              FROM comments 
              JOIN users ON comments.user_id = users.id 
              WHERE comments.post_id = ?';

    $comments = $pdo->prepare($query);
    $comments->execute([$_GET['id']]);
    $comments = $comments->fetchAll();

    //comment show ----------
    if (isset($_SESSION['admin'])) {
        $query = 'SELECT * FROM users WHERE email = ?';
        $thisuser = $pdo->prepare($query);
        $thisuser->execute([$_SESSION['admin']]);
        $thisuser = $thisuser->fetch(PDO::FETCH_OBJ);
    }
    elseif(isset($_SESSION['user'])) {
        $query = 'SELECT * FROM users WHERE email = ?';
        $thisuser = $pdo->prepare($query);
        $thisuser->execute([$_SESSION['user']]);
        $thisuser = $thisuser->fetch(PDO::FETCH_OBJ);
    }

    if(!isset($_GET['id']) && empty($_GET['id'])) {
    redirect('index.php');
    }
    else{
    $query = 'select posts.*,categories.name from posts inner join categories on posts.cat_id = categories.id where posts.id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);
    $post = $stmt->fetch();
    if (!$post){
        $have = false;
    }else{
        $year = substr($post->updated_at,0,4);
        $month = substr($post->updated_at,5,2);
        $day = substr($post->updated_at,8,2);
        if (!checkdate($month, $day, $year)) {
            $date_post = $post->created_at;
        }
        else{
            $date_post = $post->updated_at;
        }
        $have = true;
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
    <?php require_once 'layouts/top-nav.php'; ?>
    <section class="container my-5">
        <!-- Example row of columns -->
        <section class="row">
            <?php if ($have) {?>
            <section class="col-md-12">
                <img src="<?=asset($post->image)?>" alt="" width="200" height="200" >
                <h1><?=$post->title?></h1>
                <h5 class="d-flex justify-content-between align-items-center">
                    <a href="<?=url('category.php?cat_id=')."$post->cat_id"?>"><?=$post->name?></a>
                    <span class="date-time"><?=$date_post?></span>
                </h5>
                <article class="text-right bg-article p-3"><?=$post->body?></article>
                <?php } else{?>
                <section>post not found!</section>
                <?php } ?>
            </section>
        </section>
        <br>
        <br>
        <p class="text-center">کامنت ها</p>
        <section class="row mt-4 border rounded p-2 mb-3">
            <?php if (isset($_SESSION['user']) or isset($_SESSION['admin'])) {?>
            <section class="col-md-12">
                <h4>افزودن نظر</h4>
                <form method="post" action="<?=url('detail.php?id='.$_GET['id'])?>">
                    <div class="form-group">
                        <label for="comment_name">نام:</label>
                        <input type="text" class="form-control" id="comment_name" value="<?=$thisuser->first_name." ".$thisuser->last_name?>" name="name" required>
                        <input type="hidden" name="id" value="<?=$thisuser->id?>">
                    </div>
                    <div class="form-group">
                        <label for="comment_body">نظر شما:</label>
                        <textarea class="form-control" id="comment_body" name="comment" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ارسال نظر</button>
                </form>
            </section>
            <?php
            }else{
                ?>
            <section class="col-md-12">
            <p class="text-center m-1">برای ثبت نظر لطفا وارد سایت شوید</p>
            </section>
                <?php }
            ?>
        </section>

        <?php foreach ($comments as $comment) { ?>

        <br>
        <section class="row border p-3">
            <section class="col-md-12">
                <section class="d-flex justify-content-end">
                    <?php
                    $query = 'select * from users where id = ?';
                    $user = $pdo->prepare($query);
                    $user->execute([$comment->user_id]);
                    $user = $user->fetch(PDO::FETCH_OBJ);

                    if ($user->admin == 1) {?>

                        <p style="width: 20rem" class="text-center text-dark bg-warning col-md-1 jus">مدیر</p>
                    <?php } ?>
                <p class="text-center bg-article col-md-1 jus"><?=$comment->first_name?></p>

                </section>
                    <article class="text-right bg-article p-3"><?=$comment->text?></article>
            </section>
        </section>
        <?php } ?>



    </section>

</section>
<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>