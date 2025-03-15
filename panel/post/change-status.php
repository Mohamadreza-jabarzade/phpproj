<?php
global $pdo;
require_once '../../functions/helpers.php';
require_once '../../functions/pdo_connection.php';
require_once '../../functions/check_login.php';
if(isset($_GET['id']) && !empty($_GET['id'])){
    $query = 'select * from posts where id = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetch();
    if ($row->status == '10') {
        $query = 'update posts set status = ? WHERE id = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([11, $_GET['id']]);
        redirect('panel/post');
    }
    else{
        $query = 'update posts set status = ? WHERE id = ?';
        $stmt = $pdo->prepare($query);
        $stmt->execute([10, $_GET['id']]);
        redirect('panel/post');
    }
}
else{
    redirect('panel/post');
}
?>