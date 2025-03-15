<?php
require "../../functions/helpers.php";
require "../../functions/pdo_connection.php";
require_once '../../functions/check_login.php';
if(isset($_GET['id']) && is_numeric($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    $query="DELETE FROM categories WHERE id= ?";
    $stmt=$pdo->prepare($query);
    $stmt->execute([$id]);
}

redirect('panel/category');