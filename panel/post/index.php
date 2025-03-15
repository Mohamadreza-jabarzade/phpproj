<?php
require_once "../../functions/helpers.php";
require_once "../../functions/pdo_connection.php";
require_once '../../functions/check_login.php';

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

                <section class="mb-2 d-flex justify-content-between align-items-center">
                    <h2 class="h4">پست ها</h2>
                    <a href="create.php" class="btn btn-sm btn-success">ساخت پست جدید</a>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-">
                        <thead>

                        <tr>
                            <th>آیدی</th>
                            <th>عکس</th>
                            <th>عنوان</th>
                            <th>دسته</th>
                            <th>متن</th>
                            <th>وضعیت</th>
                            <th>تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        global $pdo;
                        $query = "SELECT * FROM posts";
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $posts = $stmt->fetchAll();
                        foreach ($posts as $post) {?>
                        <tr>
                            <td><?=$post->id?></td>
                            <td><img style="width: 90px;" src="<?=asset($post->image)?>"></td>
                            <td><?=$post->title?></td>
                            <td><?php
                                $query="SELECT name FROM categories WHERE id=$post->cat_id";
                                $stmt = $pdo->prepare($query);
                                $stmt->execute();
                                $cat = $stmt->fetch();
                                echo $cat->name;
                                ?></td>
                            <td><?=substr($post->body,0,50)." "."..."?></td>
                            <td>
                                <?php
                                if($post->status == 10){?>
                                <span class="text-success">فعال</span>
                                    <?php
                                    }
                                ?>
                                <?php
                                if($post->status != 10){?>
                                    <span class="text-danger">غیرفعال</span>
                                    <?php
                                }
                                ?>
                                </td>
                            <td>
                                <a href='<?=url('panel/post/change-status.php?id=')."$post->id"?>' class="btn btn-warning btn-sm"><?php 
                                if($post->status != 10){
                                    echo "فعال کردن";
                                }else{
                                    echo "غیرفعال کردن";
                                }
                                ?>
                                </a>
                                <a href='<?=url('panel/post/edit.php?id=')."$post->id"?>' class="btn btn-info btn-sm">ویرایش</a>
                                <a href='<?=url('panel/post/delete.php?id=')."$post->id"?>' class="btn btn-danger btn-sm">حذف</a>
                            </td>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </section>


            </section>
        </section>
    </section>





</section>

<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>
</html>