<?php 
	session_start(); ob_start();
	if (isset($_POST['content'] ) && isset($_POST['hour']) && isset($_POST['minutes']) && isset($_POST['date'])) 
	{
		include ('../connect.php');
	    $a = $_SESSION["id_user"];
	    $start_time =  $_POST['date'] . "T" . $_POST['hour'] . ":" . $_POST['minutes']; 
	    echo $start_time;
	    $conn = new PDO($dsn, 'root', '', $options);
	    $conn->beginTransaction();
        $sth = $conn->prepare('INSERT INTO default_schedule(id_user, content, start_time) VALUES (:id_user, :content, :start_time)');
        $sth->bindParam(':id_user', $a, PDO::PARAM_STR);
        $sth->bindParam(':content', $_POST['content'] , PDO::PARAM_STR);
        $sth->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $sth->execute();
        $conn->commit(); 
        echo $_SESSION["id_user"];
	    
	}
?>