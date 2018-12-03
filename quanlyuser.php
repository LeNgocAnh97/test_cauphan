<?php 
    include ('connect.php');
    $stmt = $db->prepare('SELECT id_inferior,(select name from users where id_user = id_inferior) as ten_con,(select email from users where id_user = id_inferior) as email_con,type
     FROM users,room_default 
     WHERE users.id_user=room_default.id_superior 
            AND id_superior=1

    ');
    $stmt->bindParam(':id_user', $_SESSION["type"]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $resultSet = $stmt->fetchAll();
    // echo "<pre>";
    // print_r($resultSet);
    // echo "</pre>";
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
                    <a class="navbar-brand" href="#">Notifications</a>
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
                            <div class="header">
                                <h4 class="title">Quản Lý User </h4>
                               
                            </div>
                             <div class="btn-group" >
                            <button  class="btn btn-info"><a href="user/them_user.php">Thêm</a></button>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th>Account</th>
                                        <th>Tên</th>
                                        <th>Chức vụ</th>
                                        <th> Edit </th>
                                        <th> Delete </th>
                                        
                                    </thead>

                                    <tbody>
                                  
                                         <?php foreach ($resultSet as $key => $value) { ?>
                                                 

                                              
                                                <tr>
                                                     <td><?php echo $value['id_inferior']; ?></td>
                                                    <td><?php echo $value['ten_con'];?></td>
                                                    <td><?php echo $value['email_con'];?></td>
                                                   
                                                    <td>
                                                        <?php
                                                            if($value['id_inferior']==1) {
                                                                echo "trưởng phòng";
                                                            }
                                                            elseif ($value['id_inferior']==2)  {
                                                                echo "nhân viên";
                                                            }
              
                                                        ?>
                                                    </td>
                                                    <td>
                                                     <form action="user/sua_user.php" method="post"> 
                                                        
                                                        <input type="hidden" value="<?php echo $value['id_inferior']; ?>" name="id_inferior">
                                                        
                                                        <input type='submit' class="btn btn-info"   value="Edit" name="sua">
                                                        
                                                     </form>  
                                                    </td>

                                                     <td>
                                                     <form action="user/xoa_user.php" method="post"> 
                                                        
                                                        <input type="hidden" value="<?php echo $value['id_inferior']; ?>" name="id_inferior">
                                                        
                                                        <input type='submit' class="btn btn-info"  value="Delete" name="xoa">
                                                     </form>   
                                                     </td>
                                                 </tr>
                                           
                                         <?php } ?>
                                           
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Trang Chủ
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Gửi THông Báo
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Lịch Làm Việc
                            </a>
                        </li>
                        <li>
                            <a href="#">
                               Thông Báo
                            </a>
                        </li>
                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer>

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
