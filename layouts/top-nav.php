<nav class="navbar navbar-expand-lg navbar-dark bg-blue ">

    <a class="navbar-brand " href="<?=url('panel')?>">ایران اخبار</a>
    <button class="navbar-toggler " type="button " data-toggle="collapse " data-target="#navbarSupportedContent " aria-controls="navbarSupportedContent " aria-expanded="false " aria-label="Toggle navigation ">
        <span class="navbar-toggler-icon "></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent ">
        <ul class="navbar-nav mr-auto ">
            <li class="nav-item active ">
                <a class="nav-link " href="<?=url('index.php')?>">خانه<span class="sr-only ">(current)</span></a>
            </li>

            <?php
            global $pdo;
            $queryy = "SELECT * FROM categories";
            $stmtm = $pdo->prepare($queryy);
            $stmtm->execute();
            $categoriess = $stmtm->fetchAll();
            foreach ($categoriess as $categoryy) {?>
            <li class="nav-item active ">
                <a class="nav-link " href="<?=url('category.php?cat_id=')."$categoryy->id"?>"><?=$categoryy->name?></a>
            </li>
            <?php } ?>
        </ul>
    </div>

    <section class="d-inline ">
        <?php

        if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){ ?>
        <a class="text-decoration-none text-white px-2 " href="<?=url('auth/register.php')?>">ثبت نام</a>
        <a class="text-decoration-none text-white " href="<?=url('auth/login.php')?>">ورود</a>
        <?php } else{ ?>
            <a class="text-decoration-none text-white px-2 " href="<?=url('profile')?>">پروفایل</a>
        <a class="text-decoration-none text-white px-2 " href="<?=url('auth/logout.php')?>">خروج</a>
        <?php } ?>

    </section>
</nav>