<?php
global $pdo;
require_once '../../functions/helpers.php';
require_once '../../functions/pdo_connection.php';
require_once '../../functions/check_login.php';
if(isset($_GET['id']) && !empty($_GET['id'])) {

    $query = "select * from posts where id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);
    $post = $stmt->fetch();


    $base = dirname(dirname(__DIR__));
    if(file_exists($base . $post->image)) {
        unlink($base . $post->image);
    }

    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    redirect('panel/post');
}
?>