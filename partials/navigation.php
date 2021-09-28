<?php
$user_rank = $_SESSION['user_access_level'];
$ret = "SELECT * FROM settings";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
    if ($user_rank == 'Member') {
?>
        <nav class="navbar">
            <div class="col-12">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="home"><?php echo $sys->name; ?> MIS</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-notifications"></i>
                            <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">MY NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu list-unstyled">
                                    <?php
                                    /* Load Logged In User Notificationsi */
                                    $user_id = $_SESSION['user_id'];
                                    $ret = "SELECT * FROM notifications WHERE notification_user_id = '$user_id'";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($notif = $res->fetch_object()) {
                                    ?>
                                        <li>
                                            <div class="icon-circle bg-orange"> <i class="material-icons">person_add</i> </div>
                                            <div class="menu-info">
                                                <h4><?php echo $notif->notification_title; ?></h4>
                                                <p> <i class="material-icons">access_time</i> <?php echo date('d M Y g:ia', strtotime($notif->notification_created_at)); ?>i </p>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="footer"> <a href="notifications">View All Notifications</a> </li>
                        </ul>
                    </li>
                    <li><a href="logout" class="mega-menu" data-close="true"><i class="zmdi zmdi-power"></i></a></li>
                </ul>
            </div>
        </nav>
    <?php
    } else {
    ?>
        <nav class="navbar">
            <div class="col-12">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="dashboard"><?php echo $sys->name; ?> MIS</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout" class="mega-menu" data-close="true"><i class="zmdi zmdi-power"></i></a></li>
                </ul>
            </div>
        </nav>
<?php
    }
}
?>