<?php
global $pdo;
require_once "../../functions/helpers.php";
require "../../functions/pdo_connection.php";
require_once '../../functions/check_login.php';
       if (isset($_POST["title"])
       and isset($_POST["body"])
       and isset($_FILES["image"])
       and isset($_POST["cat_name"])) {
            if ($_FILES["image"]['name'] == ""
            or $_POST["title"] == ""
            or $_POST["body"] == ""
            or $_POST["cat_name"] == "") {
                echo "please fill all fields";
            }
            else {
                $query = "select * from categories where name = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_POST["cat_name"]]);
                if ($stmt->rowCount() > 0) {
                    $row = $stmt->fetch();
                    $cat_id = $row->id;
                    $basePath = dirname(dirname(__DIR__));
                    $allowed_ext = array("jpg", "jpeg", "png");
                    $image_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                    $image='/assets/images/posts/'.date("YmdHis").'.'.$image_ext;
                    if (in_array($image_ext, $allowed_ext)) {
                        $image_upload = move_uploaded_file($_FILES['image']['tmp_name'],$basePath . $image);
                        if (!$image_upload) {
                            echo "Sorry, there was an error uploading your file.";
                            die();
                        }
                    }
                    $query = "insert into posts (title, body, cat_id, image ,created_at) values (?, ?, ?, ?, now())";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$_POST["title"], $_POST["body"], $cat_id, $image]);

                }
                else{
                    echo "dase mored nazar vojod nadare";
                }
            }
           redirect('panel/post');
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

                <form action="<?=url('panel/post/create.php')?>" method="post" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="title ...">
                    </section>
                    <section class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                    </section>
                    <section class="form-group">
                        <label for="cat_id">Category</label>
                        <select class="form-control" name="cat_name" id="cat_name">
                            <?php
                            $query = 'select * from categories';
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            $categories = $stmt->fetchAll();
                            ?>
                            <option selected="selected"></option>
                            <?php
                                foreach($categories as $category){ ?>

                            <option>
                                <?= $category->name ?>
                            </option>
                            <?php } ?>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" name="body" id="body" rows="5" placeholder="body ..."></textarea>
                    </section>
                    <section class="form-group">
                        <button type="submit" class="btn btn-primary">Create</button>
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