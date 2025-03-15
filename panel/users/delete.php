<?php
require_once '../../functions/check_login.php';
require "../../functions/helpers.php";
require "../../functions/pdo_connection.php";

if(isset($_GET['id']) && is_numeric($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $query="DELETE FROM users WHERE id= ?";
    $stmt=$pdo->prepare($query);
    $stmt->execute([$id]);
}

redirect('panel/users/');