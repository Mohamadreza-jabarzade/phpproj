<?php
global $pdo;
require_once "../../functions/helpers.php";
require "../../functions/pdo_connection.php";
require_once '../../functions/check_login.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $query = 'select * from posts where id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);
    $post = $stmt->fetch();
    if (!$post){
        redirect('/panel/post/');
    }
}

if (isset($_POST["title"])
    and isset($_POST["body"])
    and isset($_POST["cat_name"])
    and $_FILES["image"]["name"] == "") {
    if ($_POST["title"] == ""
        or $_POST["body"] == ""
        or $_POST["cat_name"] == "") {
        echo "please fill all fields";
    } else {
        $query = "select * from categories where name = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_POST["cat_name"]]);
        $row = $stmt->fetch();
        $cat_id = $row->id;
        if ($stmt->rowCount() > 0) {
            $query = "update posts set title = ?, body = ?, cat_id = ? ,updated_at = now() where id = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$_POST["title"], $_POST["body"], $cat_id, $_GET['id']]);
            redirect('panel/post');
        } else {
            echo "dase mored nazar vojod nadare";
        }
    }
}
elseif (isset($_POST["title"])
    and isset($_POST["body"])
    and isset($_POST["cat_name"])
    and isset($_FILES["image"]) and $_FILES["image"]["name"] != "") {
    if ($_POST["title"] == ""
        or $_POST["body"] == ""
        or $_POST["cat_name"] == "") {
        echo "please fill all field";
    } else {
        $basePath = dirname(dirname(__DIR__));
        $allowed_ext = array("jpg", "jpeg", "png");
        $image_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $image='/assets/images/posts/'.date("YmdHis").'.'.$image_ext;
        if (in_array($image_ext, $allowed_ext)) {
            if (file_exists($basePath.$image)) {
                unlink($basePath.$image);
            }
            $image_upload = move_uploaded_file($_FILES['image']['tmp_name'],$basePath . $image);
            if (!$image_upload) {
                echo "Sorry, there was an error uploading your file.";
                die();
            }
            else{
                $query = "select * from categories where name = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_POST["cat_name"]]);
                $row = $stmt->fetch();
                $cat_id = $row->id;
                if ($stmt->rowCount() > 0) {
                    $query = "update posts set title = ?, body = ?, cat_id = ? ,image = ? ,updated_at = now() where id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$_POST["title"], $_POST["body"], $cat_id, $image, $_GET['id']]);
                    redirect('panel/post');
                }
            }
        }
        else{
            echo "the uploaded file is not an image.";
        }
    }
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

                <form action="<?=url('panel/post/edit.php?id=').$_GET['id']?>" method="post" enctype="multipart/form-data">
                    <section class="form-group">
                        <label for="title">عنوان</label>
                        <input type="text" value="<?=$post->title?>" class="form-control" name="title" id="title" placeholder="title ..." value="w">
                    </section>
                    <section class="form-group">
                        <label for="image">عکس</label>
                        <br>
                        <input type="file" class="form-control" name="image" id="image" style="display: none;">
                        <div class="border p-2">
                        <button type="button" class="mr-2 btn btn-secondary" id="customButton">انتخاب فایل</button>
                        <span id="fileName">عکس مورد نظر خود را انتخاب کنید</span>
                        </div>
                        <br>
                        
                        <!-- Image Preview -->
                        <img id="preview" src="<?=asset($post->image)?>" width="100px" height="100px">
                    </section>

                    <script>
                        document.getElementById('customButton').addEventListener('click', function() {
                            document.getElementById('image').click();
                        });

                        document.getElementById('image').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                document.getElementById('fileName').textContent = file.name;
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    document.getElementById('preview').src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

                    <section class="form-group">
                        <label for="cat_id">دسته بندی</label>
                        <select  class="form-control" name="cat_name" id="cat_id">
                            <?php
                            $query = 'select * from categories';
                            $stmt = $pdo->prepare($query);
                            $stmt->execute();
                            $categories = $stmt->fetchAll();
                            foreach ($categories as $category) {
                                        if ($category->id == $post->cat_id) {?>
                                            <option selected="selected"><?php
                                                 echo $category->name;?>
                                            </option>
                                            <?php
                                        }
                                        else{
                                        ?>
                                        <option>
                                        <?=$category->name?>
                                        </option>
                                        <?php }
                                        ?>
                            <?php } ?>
                        </select>
                    </section>
                    <section class="form-group">
                        <label for="body">متن</label>
                        <textarea class="form-control" name="body" id="body" rows="5" placeholder="body ..."><?=$post->body?></textarea>
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