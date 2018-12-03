<?php session_start(); ob_start();  ?>
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
                    <input name="email" type="text" class="form-control" placeholder="..." >
   		 	</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 col-md-offset-4">

			<div class="form-group">
                     <label>name   :</label>
                     <input name="ten"  type="name" class="form-control" placeholder="..." >
   			 </div>
		</div>
	</div>

		<div class="row">

			<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
                    <label>pass :</label>
                    <input type="password" name="pass"class="form-control" placeholder="..." >
    			</div>
    		</div>
		</div>

	</div>
	
	<div class="row">

			<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
                   	<input type="submit"  value="Đăng Kí" name="submit">

					<input type="reset" value="Hủy">
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
        $c=$_POST['pass'];
        $type_inferior = ((int)$_SESSION['type'] - 1);

// B2 : Tìm cách insert 2 bảng. CHú ý 
        include ('../connect.php');
        try {
        $db->beginTransaction();
        $sth = $db->prepare('INSERT INTO users(name, email,password,type) VALUES (:name,:email,:password,:type)');
        $sth->bindParam(':name', $b, PDO::PARAM_STR);
        $sth->bindParam(':email', $a, PDO::PARAM_STR);
        $sth->bindParam(':password', $c, PDO::PARAM_STR);
        $sth->bindParam(':type', $type_inferior, PDO::PARAM_STR);
        $sth->execute();
        $db->commit(); 

        $sth2 = $db->prepare('SELECT max(id_user) as ahihi from users');
        $sth2->execute();
        $sss  = $sth2->fetch(); 


        $db->beginTransaction();
        $sth2 = $db->prepare('INSERT INTO room_default(id_inferior,id_superior) VALUES (:id_inferior,:id_superior)');
        $sth2->bindParam(':id_inferior', $sss['ahihi'], PDO::PARAM_STR);
        $sth2->bindParam(':id_superior', $_SESSION['id_user'], PDO::PARAM_STR);
       
        $sth2->execute();
        $db->commit(); 
        header('Location: ../quanlyuser.php');
        exit();
    
        }catch (Exception $e){
            $db->rollback();
            throw $e;
        }

    }
// ?>