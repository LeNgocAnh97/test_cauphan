
    	<div class="sidebar-wrapper">
            <div class="logo">
                
                    Company Notification
                
            </div>

            <ul class="nav">
                <li class="">
                    <a href="index.php">
                        <i class="pe-7s-graph"></i>
                        <p>Trang Chủ</p>
                    </a>
                </li>
                <li>
                    <?php if($_SESSION["type"] != '1') { ?>
                    <a href="guithongbao.php">
                        <i class="pe-7s-user"></i>
                        <p>Gửi Thông Báo</p>
                    </a>

                    <?php  } ?>
                </li>
                <li>
                    <a href="lichlamviec.php">
                        <i class="pe-7s-note2"></i>
                        <p>Lịch Làm Việc</p>
                    </a>
                </li>
               
                <li>
                    <a href="thongbao.php">
                        <i class="pe-7s-bell"></i>
                        <p>Thông Báo</p>
                    </a>
                </li>
                    <li>
                    <?php if($_SESSION["type"] != '1') { ?>
                    <a href="quanlyuser.php">
                        <i class="pe-7s-user"></i>
                        <p>Quản Lý User</p>
                    </a>
                    <?php } ?>
                </li>
				
            </ul>
    	</div>
    </div>