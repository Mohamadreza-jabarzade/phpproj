<?php
global $pdo;
require_once '../functions/helpers.php';
require_once '../functions/pdo_connection.php';




class handle
{
    protected $errors = [];

    public function set_empty_err($error,$err_text)
    {
         $this->errors[$error][] = $err_text;
    }
    public function set_validity_err($error,$err_text){
        $this->errors[$error][] = $err_text;
    }

    public function count_errors(){
        return count($this->errors);
    }
    public function has($error){
        return isset($this->errors[$error]);
    }
    public function get($error)
    {
        if($this->has($error)){
            return $this->errors[$error][0];
        }
        return null;
    }

}
$errr = new handle();



if(isset($_POST["email"]) &&
    isset($_POST["password"]) &&
    isset($_POST["confirm"]) &&
    isset($_POST["first_name"]) &&
    isset($_POST["last_name"])){
    if(empty($_POST["email"])){
      $errr->set_empty_err("email","Email is required");
    }
    if(empty($_POST["password"])){
        $errr->set_empty_err("password","Password is required");
    }
    if(empty($_POST["confirm"])){
        $errr->set_empty_err("confirm_password","Confirm password is required");
    }
    if(empty($_POST["first_name"])){
        $errr->set_empty_err("first_name","first_name is required");
    }
    if(empty($_POST["last_name"])){
        $errr->set_empty_err("last_name","last_name is required");
    }
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $errr->set_validity_err("email","Invalid email format");
    }
    if ($errr->count_errors() == 0){

        if ($_POST["password"] == $_POST["confirm"]) {
            if (strlen($_POST["password"]) < 8 ) {
                $errr->set_validity_err("password","Password must be at least 8 characters long");
            }
            else{
                $query = 'select * from users where email = ?';
                $stmt = $pdo->prepare($query);
                $stmt->execute([$_POST["email"]]);
                $user = $stmt->fetch();
                if ($user) {
                    $errr -> set_validity_err("email","This email is already taken");
                }
                else{
                    $query = 'insert into users (email,password,first_name,last_name , created_at) values (?,?,?,?,now())';
                    $stmt = $pdo->prepare($query);
                    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    $stmt->execute([$_POST["email"],$hash ,$_POST["first_name"],$_POST["last_name"]]);
                    redirect('auth/login.php');
                }
            }
        }
        else{
            $errr->set_validity_err("confirm_password","confirm not matched with password.");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>register page</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
</head>

<body>
<section id="app">

    <section style="height: 100vh; background-color: #138496;" class="d-flex justify-content-center align-items-center">
        <section class="text-right" style="width: 25rem;">
            <h1 class="bg-warning text-center rounded-top px-2 mb-0 py-3 h5">ثبت نام</h1>

            <form class="p-3 pt-3 pb-1 px-2 bg-light rounded-bottom" action="<?=url('auth/register.php')?>" method="post">
                <section class="form-group">
                    <label for="email">ایمیل</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="example@gmail.com">
                    <section class="bg-light my-0 px-2"><small class="text-danger"><?php
                            if ($errr->has("email")) {
                                echo $errr->get("email");
                            }
                            ?></small></section>
                </section>
                <section class="form-group">
                    <label for="first_name">نام</label>
                    <input type="text" class="text-center form-control" name="first_name" id="first_name" placeholder="نام">
                    <section class="bg-light my-0 px-2"><small class="text-danger"><?php
                            if ($errr->has("first_name")) {
                                echo $errr->get("first_name");
                            }
                            ?></small></section>
                </section>
                <section class="form-group">
                    <label for="last_name">نام خانوادگی</label>
                    <input type="text" class="text-center form-control" name="last_name" id="last_name" placeholder="نام خانوادگی">
                    <section class="bg-light my-0 px-2"><small class="text-danger"><?php
                            if ($errr->has("last_name")) {
                                echo $errr->get("last_name");
                            }
                            ?></small></section>
                </section>
                <section class="form-group">
                    <label for="password">رمز عبور</label>
                    <input type="password" class="text-center form-control" name="password" id="password" placeholder="رمز عبور">
                    <section class="bg-light my-0 px-2"><small class="text-danger"><?php
                            if ($errr->has("password")) {
                                echo $errr->get("password");
                            }
                            ?></small></section>
                </section>
                <section class="form-group">
                    <label for="confirm">تکرار رمز عبور</label>
                    <input type="password" class="text-center form-control" name="confirm" id="confirm" placeholder="تکرار رمز عبور">
                    <section class="bg-light my-0 px-2"><small class="text-danger"><?php
                            if ($errr->has("confirm_password")) {
                                echo $errr->get("confirm_password");
                            }
                            ?></small></section>
                </section>
                <section class="mt-4 mb-2 d-flex justify-content-between">
                    <input type="submit" class="p-2 btn btn-success btn-sm" value="ثبت نام">
                    <a class="" href="<?=url('auth/login.php')?>">ورود</a>
                </section>
            </form>
        </section>
    </section>

</section>
<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>