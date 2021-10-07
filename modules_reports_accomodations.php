<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();
require_once('partials/head.php');
?>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <?php require_once('partials/loader.php'); ?>
    </div>

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>

    <!-- Top Bar -->
    <?php require_once('partials/navigation.php'); ?>

    <!-- Left Sidebar -->
    <?php require_once('partials/sidebar.php'); ?>

    <!-- Add Staff Modal -->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-7">
                        <h2>Reports - Museum Guest Rooms Accomodation Reservations</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Reports</a></li>
                            <li class="breadcrumb-item active">Accomodations</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Member Details</th>
                                    <th>Room Details</th>
                                    <th>Dates</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                            <a href="modules_bookings_accomodation?view=<?php echo $reservations->accomodation_id; ?>">
                                                Name: <?php echo $reservations->user_name; ?><br>
                                                Email: <?php echo $reservations->user_email; ?><br>
                                                Contact: <?php echo $reservations->user_phone; ?>
                                            </a>
                                        </td>
                                        <td>
                                            No : <?php echo $reservations->room_number; ?><br>
                                            Type : <?php echo $reservations->room_type; ?>
                                        </td>
                                        <td>
                                            Check In : <?php echo date('d, M Y', strtotime($reservations->accomodation_check_indate)); ?><br>
                                            Check Out : <?php echo date('d, M Y', strtotime($reservations->accomodation_check_out_date)); ?>
                                        </td>
                                        <td><?php echo $reservations->accomodation_payment_status; ?></td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Scripts -->
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>