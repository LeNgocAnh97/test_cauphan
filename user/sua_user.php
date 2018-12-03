<?php 
    session_start(); ob_start();  
    include ('../connect.php');
    if(isset($_POST['id_inferior'])) {
        $id = $_POST['id_inferior'];
    }
    $stmt = $db->prepare('
        SELECT * FROM users 
        WHERE id_user = :id_user
    ');

    $stmt->bindParam(':id_user', $_POST['id_inferior']); 
    $stmt->execute();
    $resultSet = $stmt->fetch();
?>
<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Light Bootstrap Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="../assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="../assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="../assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>
	<h1 align="center">Thêm Mới </h1>
	<form action="" method="post">
	   
    <div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="form-group">
                    <label>Tên đăng nhập :</label>
                    <input name="email" type="text" value="<?php echo $resultSet['email'] ?>" class="form-control" placeholder="..." >
   		 	</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 col-md-offset-4">

			<div class="form-group">
                     <label>Tên   :</label>
                     <input name="ten"  type="text" value="<?php echo $resultSet['name'] ?>" class="form-control" placeholder="..." >
   			 </div>
		</div>
	</div>
	
	<div class="row">

			<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
                   	<input type="submit"  value="Sửa" name="submit">
    			</div>
    		</div>
		</div>

	</div>

	


	
	

	</form>
</body>

</html>

<?php
// B1 : Lấy dữ liệu từ form
    if(isset($_POST['submit'])){
        $a=$_POST['email'];
        $b=$_POST['ten'];
        try{
        $db->beginTransaction();
        $sth = $db->prepare('UPDATE users SET name = :name, email = :email WHERE id_user = :id_user');
        echo $a; echo $b; echo $_POST['id_inferior'];
        $sth->bindParam(':name', $b, PDO::PARAM_STR);
        $sth->bindParam(':email', $a, PDO::PARAM_STR);
        $sth->bindParam(':id_user', $id); 
        $sth->execute();
        $db->commit(); 
        header('Location: ../quanlyuser.php');
        exit();
    
        }catch (Exception $e){
            $db->rollback();
            throw $e;
        }
    }
// ?>