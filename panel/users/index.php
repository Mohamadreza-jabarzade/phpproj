<?php
    require_once '../../functions/helpers.php';
require_once '../../functions/check_login.php';
require_once '../../functions/pdo_connection.php';
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
                    <h2 class="h4">کاربران</h2>

                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-">
                        <thead>
                        <tr>
                            <th>آیدی</th>
                            <th>نام</th>
                            <th>تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        global $pdo;
                        $query = 'SELECT * FROM users';
                        $stmt = $pdo->prepare($query);
                        $stmt->execute();
                        $users = $stmt->fetchAll();
                        foreach ($users as $user) {?>

                            <tr>
                                <td><?=$user->id?></td>
                                <td><?=$user->first_name?></td>
                                <td>
                                    <a href="<?=url('panel/users/info.php')."?id=$user->id"?>" class="btn btn-info btn-sm">اطلاعات</a>
                                    <a href="<?=url('panel/users/delete.php')."?id=$user->id"?>" class="btn btn-danger btn-sm">حذف</a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>

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