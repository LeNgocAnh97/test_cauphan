<?php session_start(); ob_start();
    include ('connect.php');
    $a = $_SESSION["id_user"];
    $stmt = $db->prepare('
        SELECT id_inferior, name, type  FROM room_default 
        RIGHT JOIN users ON users.id_user = room_default.id_inferior
        WHERE id_superior = :id_superior
    ');
    $stmt->bindParam(':id_superior', $a);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $resultSet = $stmt->fetchAll();

    $stmt4 = $db->prepare('
        SELECT content,users,start_time FROM rooms 
        Left join users ON users.id_user = rooms.id_boss
        left join custom_schedule ON custom_schedule.id=rooms.id_schedule
        WHERE id_user = :id_boss
        ORDER BY  start_time DESC
    ');
    $stmt4->bindParam(':id_boss', $_SESSION["id_user"]);
    $stmt4->setFetchMode(PDO::FETCH_ASSOC);
    $stmt4->execute();
    $resultSet4 = $stmt4->fetchAll();
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
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->

    <?php require_once('menu-left.php') ?>

    
    <div class="main-panel">
		<nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Gửi Thông Báo</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-sm hidden-xs"></b>
                                    <span class="notification hidden-sm hidden-xs">5</span>
									<p class="hidden-lg hidden-md">
										5 Notifications
										<b class="caret"></b>
									</p>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li>
                                <li><a href="#">Notification 2</a></li>
                                <li><a href="#">Notification 3</a></li>
                                <li><a href="#">Notification 4</a></li>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                        </li>
                        <li>
                           <a href="">
                                <i class="fa fa-search"></i>
								<p class="hidden-lg hidden-md">Search</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                           <a href="">
                               <p>Tài Khoản</p>
                            </a>
                        </li>
                       
                        <li>
                            <a href="logout.php">
                                <p>Đăng Xuất</p>
                            </a>
                        </li>
						<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                          
                            <div class="content">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get">
                                    <div class="row">
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ngày Gửi</label>
                                                <input type="datetime-local"  name="datetime" class="form-control" placeholder="YYYY-MM-DD" />
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Nội Dung</label>
                                                <textarea rows="5" name="content" class="form-control" placeholder="Here can be your description" value=""></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h5>Gửi Đến</h5>
                                        <button class="btn btn-info btn-fill" >Chọn Tất Cả</button>
                                        <br />
                                        <div class="row" style="width: 100%">
                                            <?php foreach ($resultSet as $key => $value) { ?>
                                                <div class="col-md-4">
                                                    <input type="checkbox"  name="checkbox[]" value="<?php echo $value['id_inferior'] ?>"><?php $chucdanh =  ($resultSet[0]['type'] == 2) ? 'Trưởng phòng' : 'Nhan vien'; echo $chucdanh  ?>    <?php echo $value['name'] ?>

                                                </div>
                                            <?php } ?>
                                            
                                        </div>

                                    </div>

                                    <button type="submit" name="submit" class="btn btn-info btn-fill pull-right">Gửi Đi</button>
                   <table class="table table-hover table-striped">
                                    <thead>
                                        <th>STT</th>
                                        <th>Content</th>
                                        <th>Người Nhận</th>
                                        <th>DateTime </th>
                                       
                                        
                                    </thead>
                                    <tbody>
                                    <?php foreach ($resultSet4 as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $key +1 ?></td>
                                            <td><?php echo $value['content'] ?></td>
                                            <td> ©</td>
                                            <td><?php echo $value['start_time']?></td>
                                            
                                        </tr>
                                        <?php } ?>
                                       
                                       
                                    </tbody>
                                </table>                 

<?php

    if(isset($_GET['content'])) {
        $a = $_GET['content'] ;
        $b =$_GET['datetime'];
        echo $b;
        $conn = new PDO($dsn, 'root', '',$options);
        $conn->beginTransaction();
        $sth = $conn->prepare('INSERT INTO custom_schedule(content, start_time) VALUES (:content, :start_time)');
        $sth->bindParam(':content', $a, PDO::PARAM_STR);
        $sth->bindParam(':start_time', $b, PDO::PARAM_STR);
        $sth->execute();
        $conn->commit(); 

        $sth2 = $conn->prepare('SELECT max(id) as ahihi from custom_schedule');
        $sth2->execute();
        $sss  = $sth2->fetch(); 
        $c=$_SESSION["id_user"];
        $d = '';
        for( $i = 0; $i < count($_GET['checkbox']); $i++) {
            $d = (string)$_GET['checkbox'][$i];
            $conn->beginTransaction();
            $sth3 = $conn->prepare('INSERT INTO rooms(id_schedule,id_boss,users) VALUES (:id_schedule,:id_boss,:users )');
            $sth3->bindParam(':id_schedule', $sss['ahihi'], PDO::PARAM_INT);
            $sth3->bindParam(':id_boss', $c, PDO::PARAM_INT);
            $sth3->bindParam(':users', $d, PDO::PARAM_INT);
            $sth3->execute();
            $conn->commit(); 
        }
        

    }
       

?>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                   
                            <hr>
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>


       

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

</html>
