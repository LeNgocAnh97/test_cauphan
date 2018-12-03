<?php 
    session_start(); ob_start();
    error_reporting(0); 
    function day ($var) {
        $a = date_parse_from_format('Y:m:d',$var);
        return $a['day'];
    }
    include ('connect.php');
    $stmt = $db->prepare('
        SELECT  start_time, content  FROM default_schedule 
        INNER JOIN users ON default_schedule.id_user = users.id_user
        WHERE  DATE_ADD(DATE(start_time),INTERVAL 1 DAY) >=  NOW() AND DATE(start_time)  <= DATE_ADD(NOW(), INTERVAL 1 WEEK) AND default_schedule.id_user = :id_user
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
      function setAllDay($dateArg) {
            $seconds_in_a_day = 86400;
            list($day, $month, $year) = explode("-", $dateArg);
            $firstDay = mktime('0','0','0', $month, $day, $year);
            for($i=0; $i<7; $i++)
            {

                $dates[$i] = date('Y-m-d',($firstDay + ($seconds_in_a_day * $i)));

            }
            return $dates;
        }
        $allDayList = setAllDay(date('d-m-Y'));

        
        $begin = date('Y-m-d');
        $end = date ('Y-m-j', strtotime('6 day', strtotime($begin)));
        $datediff = strtotime($end) - strtotime($begin);
        $datediff = floor($datediff/(60*60*24));
        $dem = -1;
        for($i = 0; $i < $datediff + 1; $i++ ){
            $dem++;
            for ($j = 0; $j < count($resultSet); $j++) {
                
                if (day(date("Y-m-d", strtotime($begin . ' + ' . $i . 'day')))  === day($resultSet[$j]['start_time'])) {
                        array_push($row[$dem], $resultSet[$j]);  
                            
                }

            }
            array_push($row[$dem], $allDayList[$i]);  
        }


        // $hourRange = implode("",range(8,12)); // Lấy ra giờ
        // $minutesRange = ['15', '30', '45', '60'];
        // Mai : viết 1 array 15,30,45,60 là xong 
        // THiết kế chọn ngày giờ tương đương với năm tháng nhứ U00004

      

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
    table tr  {
        border: 1px solid black;
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
                                        <th>Thoi gian</th>
                                        <?php foreach ($allDayList as $key => $day) { ?>
                                            <th><?php echo $day ?></th>
                                        <?php } ?>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Sang</td>
                                             <?php foreach ($row as $keyDays => $valueDays): ?>
                                                <td  id="0">
                                                    
                                                    <?php 

                                                    foreach ($valueDays as $keyInfoOfDay => $valueInfoOfDay):
                                                    $time = (int)date("H", strtotime($valueInfoOfDay['start_time']));
                                                    if ( $time <= 12 && isset($valueInfoOfDay['start_time']) && date("Y-m-d", strtotime($valueDays[count($valueDays) - 1])) == $allDayList[$keyDays]) {
                                                     
                                                    ?>

                                                        </br>
                                                        Nội dung  : <?php echo $valueInfoOfDay['content']; ?>
                                                        </br>
                                                        Thời gian : <?php echo date("H:i", strtotime($valueInfoOfDay['start_time'])); ?>
                                                        <hr>
                                                    <?php }  ?>   
                                                  
                                                    <?php 
                                                    
                                                    endforeach;
                                                    

                                                    ?>
                                                    <form id="0-<?php echo $keyDays ?>">
                                                        
                                                        <button 
                                                        onclick="addTime('0', '<?php echo $keyDays ?>' , '<?php echo $valueDays[count($valueDays) - 1]; ?>')" 
                                                        id="0"  type="button" class="btn btn-primary">Thêm</button>
                        
                                                    </form>

                                                </td>

                                           <?php endforeach ?>
                                        </tr>
                                        <tr>
                                            <td>Chieu</td>
                                            <?php foreach ($row as $keyDays => $valueDays): ?>
                                                <td  id="1">
                
                                                    <?php 
                                                    foreach ($valueDays as $keyInfoOfDay => $valueInfoOfDay) :
                                                    $time = (int)date("H", strtotime($valueInfoOfDay['start_time']));
                                                    if ( $time > 12 && isset($valueInfoOfDay['start_time']) && date("Y-m-d", strtotime($valueInfoOfDay['start_time'])) == $allDayList[$keyDays] ) {
                                                    ?>
                                                        </br>
                                                        Nội dung  : <?php echo $valueInfoOfDay['content']; ?>
                                                        </br>
                                                        Thời gian : <?php echo date("H:i", strtotime($valueInfoOfDay['start_time'])); ?>
                                                        
                                                    <hr>
                                                    <?php 
                                                    }
                                                    endforeach 
                                                    ?>
                                                    
                                                    <form id="1-<?php echo $keyDays ?>">
                                                            
                                                        <button 
                                                        onclick="addTime('1', '<?php echo $keyDays ?>' , '<?php echo $valueDays[count($valueDays) - 1]; ?>')" 
                                                        id="0"  type="button" class="btn btn-primary">Thêm</button>
                            
                                                     </form>
                                                    <!--  Cần gửi đi id_user, ngày tháng năm, khung giờ -->
                                                    <!-- id_user có rồi, $valueDays lúc này giữ ngày tháng năm, khung giờ get 2 cái id của td để biết được đang là khung giờ sáng hay chiều -->
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
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Trang Chủ
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Gửi Thông Báo
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
    <!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
    <script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

    <!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
    <script src="assets/js/demo.js"></script>


</html>

<script> 
function numberRange (start, end) {
  return new Array(end - start).fill().map((d, i) => i + start);
} 
var hourRange = numberRange(8, 13);
var hourRange2 = numberRange(13, 19);
var minutesRange = new Array('00', '15','30', '45');

function arrMinutes(value) {
    var optionMinutes = '<select class="form-control" width="30%" id="m_'+value+'">';
    for (var i = 0; i < minutesRange.length; i += 1) {
        optionMinutes += "<option > " + minutesRange[i] + "</option>";
    }
    optionMinutes += "</select>";
    return optionMinutes;
}

function arrHour(time, value) {
    var optionHours = '<select class="form-control" width="30%"  id="h_'+value+'">';
    if (time == '0') {
        for (var i = 0; i < hourRange.length; i += 1) {
            optionHours += "<option> " + hourRange[i] + "</option>";
        }
    } else {
        for (var i = 0; i < hourRange.length; i += 1) {
            optionHours += "<option> " + hourRange2[i] + "</option>";
        }
    }
    
    optionHours += "</select>";
    return optionHours;
}
function addTime(time, valuetime, date) {

    var form = "<form id='"+time+"-"+valuetime+"'><textarea class='form-control' value='Noi Dung' id='content"+time+"-"+valuetime+"'></textarea>"+
    "<input type='hidden' id='date_"+time+"-"+valuetime+"' value='"+date+"'/><br>"+
    " " + arrHour(time, time+"-"+valuetime) + " </br> "+ arrMinutes(time+"-"+valuetime) + " " +
        "<p class='post' style='color : blue; cursor : pointer; font-weight:bold' onclick=postForm('"+time+"-"+valuetime+"') id='"+time+"-"
        +valuetime+"'> Thêm  </p></form>";
    

    $("#"+time+"-"+valuetime+"").html(form);
    
}

function postForm (value) {
    $.ajax({
        url: 'ajax/them_lich.php',
        type: 'POST',
        dataType: "text",
        data: {
            content : $('#content'+value).val(),
            hour :    $('#h_'+value).val(),
            minutes : $('#m_'+value).val(),
            date    : $('#date_'+value).val(),
        }
        }).done(function(ketqua) {
            alert('OK');
            location.reload();
        });
    event.preventDefault();
}


</script>