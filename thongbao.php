<?php 
    session_start(); ob_start(); echo $_SESSION["type"];
    error_reporting(0); 
    function day ($var) {
        $a = date_parse_from_format('Y:m:d',$var);
        return $a['day'];
    }
    include ('connect.php');
    $stmt = $db->prepare('SELECT  start_time, end_time, ( SELECT name FROM users WHERE id_user = rooms.id_boss) as name_boss,  ( SELECT name FROM users WHERE  id_user =  users) as name_user, content  FROM custom_schedule 
    LEFT JOIN rooms ON custom_schedule.id = rooms.id_schedule
    LEFT JOIN users ON rooms.users = users.id_user
    WHERE  DATE_ADD(DATE(start_time),INTERVAL 1 DAY) >=  NOW() AND DATE(start_time)  <= DATE_ADD(NOW(), INTERVAL 1 WEEK) AND rooms.users = :id_user
    
    
    ');
    $stmt->bindParam(':id_user', $_SESSION["id_user"]);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $resultSet = $stmt->fetchAll();
    $row = 
    [
        [], [], [], [], [], [], []
    ];

    // for ($j = 0; $j <= 7; $j++) {
    //     for ($i = 0; $i < count($resultSet); $i++) {
    //         $date=date_create();
    //         print_r($date);
    //         if ( day(date_format(date_add($date, date_interval_create_from_date_string('0 days')), "Y-m-d")) === day($resultSet[$i]['start_time'])) {
    //             array_push($row[$j], day($resultSet[$i]['start_time']));
    //         }
            
    //     }
        
       // date_add($today, date_interval_create_from_date_string('0'+ $i +' days'));
        //print_r($today);
    
        $begin = date('Y-m-d');
        $end = date ( 'Y-m-j', strtotime('6 day', strtotime($begin)) );
        $datediff1 = strtotime($end) - strtotime($begin);
        $datediff = floor($datediff1/(60*60*24));
        $dem = -1;
        for($i = 0; $i < $datediff + 1; $i++ ){
            $dem++;
            for ($j = 0; $j <= count($resultSet); $j++) {
                
                if (day(date("Y-m-d", strtotime($start . ' + ' . $i . 'day')))  === day($resultSet[$j]['start_time'])) {
                        array_push($row[$dem], $resultSet[$j]);         
                }
            }

        }

        function setAllDay($dateArg) {
            $seconds_in_a_day = 86400;
            list($day, $month, $year) = explode("-", $dateArg);
            $monday = mktime('0','0','0', $month, $day, $year);
            for($i=0; $i<7; $i++)
            {
                $dates[$i] = date('Y-m-d',$monday+($seconds_in_a_day*$i));
            }
            return $dates;
        }
        $allDayList = setAllDay(date('d-m-Y'));

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



    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />


    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>



    <link href="assets/css/demo.css" rel="stylesheet" />

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
</head>
<style type="text/css">
    .btn-group{
        display: flex;
        justify-content: flex-end;
    }
</style>
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
                    <a class="navbar-brand" href="#">Lịch Làm Việc</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                       
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-globe"></i>
                                    <b class="caret hidden-sm hidden-xs"></b>
                                    <span class="notification hidden-sm hidden-xs"><?php 
                                            $count = 0;
                                            for($i = 0; $i < 7; $i++) {
                                                $count += count($row[$i]);
                                            }
                                            echo $count;
                                        ?></span>
                                    <p class="hidden-lg hidden-md">
                                        

                                         Notifications
                                        <b class="caret"></b>
                                    </p>
                              </a>
                              
                              <ul class="dropdown-menu">
                                <?php foreach ($row as $keyDays => $valueDays): ?>  
                                    <?php foreach ($valueDays as $keyInfoOfDay => $valueInfoOfDay): ?>
                                        <li><a href="#"><?php echo ($datediff1/60/60). "" .$valueInfoOfDay['content']; ?> </a></li>
                                    <?php endforeach ?>
                                <?php endforeach ?>
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
                                <h4 class="title">Lịch Làm Việc Trong Tuần</h4>
                                
                            </div>
                            
                            <div class="btn-group" >
                            <button type="button" class="btn btn-primary">Thêm</button>
                            <button type="button" class="btn btn-primary">Sửa</button>
                            <button type="button" class="btn btn-primary">Xóa</button>
                            </div>
                            
                            <div class="content table-responsive table-full-width">
                                <table class="table table-bordered">
                                    <thead>
                                        <?php foreach ($allDayList as $key => $day) { ?>
                                            <th><?php echo $day ?></th>
                                        <?php } ?>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                           <?php foreach ($row as $keyDays => $valueDays): ?>
                                                <td>
                                                    <?php 
                                                    foreach ($valueDays as $keyInfoOfDay => $valueInfoOfDay):
                                                    ?>
                                                        Người gửi : <?php echo $valueInfoOfDay['name_boss']; ?>
                                                        </br>
                                                        Nội dung  : <?php echo $valueInfoOfDay['content']; ?>
                                                        </br>
                                                        Thời gian : <?php echo date("H:i", strtotime($valueInfoOfDay['start_time'])); ?>
                                                        
                                                    <hr>
                                                    <?php 

                                                    endforeach 
                                                    ?>
                                                </td>

                                           <?php endforeach ?>
                                        </tr>
                                    
                                     
                                        
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
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative By : Nhóm 4</a>,
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
