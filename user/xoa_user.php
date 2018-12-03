<?php
		session_start(); ob_start();  
		include ('../connect.php');
        $db->beginTransaction();
        $sth = $db->prepare('DELETE  FROM room_default WHERE id_superior = :id_superior AND id_inferior = :id_inferior');
        $sth->bindParam(':id_superior', $_SESSION['id_user'], PDO::PARAM_STR);
        $sth->bindParam(':id_inferior', $_POST['id_inferior'], PDO::PARAM_STR);
        $sth->execute();
        $db->commit(); 
        header('Location: ../quanlyuser.php');
        exit();
?>