<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
checklogin();
require_once('partials/analytics.php');
require_once('partials/head.php');
?>

<body class="theme-red">
    <div class="page-loader-wrapper">
        <?php require_once('partials/loader.php'); ?>
    </div>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #Float icon -->
    <!-- Search  -->
    <!-- <div class="search-bar">
        <div class="search-icon"> <i class="zmdi zmdi-search"></i> </div>
        <input type="text" placeholder="Search...">
        <div class="close-search"> <i class="zmdi zmdi-close"></i> </div>
    </div> -->
    <!-- Top Bar -->
    <?php require_once('partials/navigation.php'); ?>
    <!-- Left Sidebar -->
    <?php require_once('partials/sidebar.php'); ?>

    <!-- Main Content -->
    <section class="content home">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-7">
                        <h2>Dashboard</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="card widget-stat">
                        <div class="body">
                            <div class="media">
                                <div class="media-icon bg-cyan">
                                    <i class="zmdi zmdi-accounts-outline zmdi-hc-2x"></i>
                                </div>
                                <div class="media-text">
                                    <span class="title">Members</span>
                                    <span class="value"><?php echo $members; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="card widget-stat">
                        <div class="body">
                            <div class="media">
                                <div class="media-icon bg-amber">
                                    <i class="zmdi zmdi-account-o zmdi-hc-2x"></i>
                                </div>
                                <div class="media-text">
                                    <span class="title">Staffs</span>
                                    <span class="value"><?php echo $staffs; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="card widget-stat">
                        <div class="body">
                            <div class="media">
                                <div class="media-icon bg-blue">
                                    <i class="zmdi zmdi-label zmdi-hc-2x"></i>
                                </div>
                                <div class="media-text">
                                    <span class="title">Bookings</span>
                                    <span class="value"><?php echo $bookings; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="card widget-stat">
                        <div class="body">
                            <div class="media">
                                <div class="media-icon bg-green">
                                    <i class="zmdi zmdi-money zmdi-hc-2x"></i>
                                </div>
                                <div class="media-text">
                                    <span class="title">Total Revenue</span>
                                    <span class="value">Ksh <?php echo $revenue; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-sm-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Latest Bookings - Museum Reservations</h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-striped table-borderless m-b-5">
                                <thead>
                                    <tr>
                                        <th style="width:40%;">Member Details</th>
                                        <th class="number">Booking Date</th>
                                        <th style="width:20%;">Booking Payment</th>
                                        <th style="width:5%;" class="actions"></th>
                                    </tr>
                                </thead>
                                <tbody class="no-border-x">
                                    <?php
                                    $ret = "SELECT * FROM  reservations r
                                    INNER JOIN users u ON r.reservation_user_id  = u.user_id";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($reservations = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td>
                                                Name : <?php echo $reservations->user_name; ?><br>
                                                Phone : <?php echo $reservations->user_phone; ?><br>
                                                Email : <?php echo $reservations->user_email; ?>
                                            </td>
                                            <td class="number"><?php echo $reservations->reservation_date; ?></td>
                                            <td><?php echo $reservations->reservation_payment_status; ?></td>
                                            <td class="actions"><a href="modules_bookings_reservation?view=<?php echo $reservations->reservation_id; ?>" class="icon"><i class="zmdi zmdi-eye"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-sm-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Latest Bookings - Rooms & Accomodations</h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-striped table-borderless m-b-5">
                                <thead>
                                    <tr>
                                        <th style="width:40%;">Member Details</th>
                                        <th class="number">Accomodations Dates</th>
                                        <th style="width:20%;">Room Details</th>
                                        <th style="width:20%;">Payment Status</th>
                                        <th style="width:5%;" class="actions"></th>
                                    </tr>
                                </thead>
                                <tbody class="no-border-x">
                                    <?php
                                    $ret = "SELECT * FROM accomodations a INNER JOIN 
                                    users u ON u.user_id = a.accomodation_user_id 
                                    INNER JOIN rooms r ON r.room_id = a.accomodation_room_id";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($reservations = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <td>
                                                Name : <?php echo $reservations->user_name; ?><br>
                                                Phone : <?php echo $reservations->user_phone; ?><br>
                                                Email : <?php echo $reservations->user_email; ?>
                                            </td>
                                            <td>
                                                Check In:<?php echo $reservations->accomodation_check_indate; ?><br>
                                                Check Out: <?php echo $reservations->accomodation_check_out_date; ?>
                                            </td>
                                            <td>
                                                No: <?php echo $reservations->room_number; ?><br>
                                                Type: <?php echo $reservations->room_type; ?>
                                            </td>
                                            <?php
                                            if ($reservations->accomodation_payment_status == 'Paid') {
                                            ?>
                                                <td class="text-success">Paid</td>
                                            <?php } else {
                                            ?>
                                                <td class="text-primary">Pending</td>
                                            <?php } ?>
                                            <td class="actions"><a href="modules_bookings_accomodation?view=<?php echo $reservations->accomodation_id; ?>" class="icon"><i class="zmdi zmdi-eye"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Jquery Core Js -->
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>