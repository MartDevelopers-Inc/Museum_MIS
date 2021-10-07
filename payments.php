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
                        <h2>My Payments Records</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payments</li>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <div class="member-card-2 ">
                                        <div class=" member-thumb">
                                            <img src="assets/images/membership.png" class="img-thumbnail" alt="profile-image">
                                        </div>
                                        <div class="">
                                            <h4 class="m-b-5">Membership Package Payments</h4>
                                        </div>
                                        <a href="membership_packages_payments" class="btn btn-raised btn-primary waves-effect">View Payment Record</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <div class="member-card-2 ">
                                        <div class=" member-thumb">
                                            <img src="assets/images/reservation.png" class="img-thumbnail" alt="profile-image">
                                        </div>
                                        <div class="">
                                            <h4 class="m-b-5">Museum Visit Reservations</h4>
                                        </div>
                                        <a href="reservations_payments" class="btn btn-raised btn-primary waves-effect">View Payment Records</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="body">
                                    <div class="member-card-2 ">
                                        <div class=" member-thumb">
                                            <img src="assets/images/room.png" class="img-thumbnail" alt="profile-image">
                                        </div>
                                        <div class="">
                                            <h4 class="m-b-5">Guest Room Reservations</h4>
                                        </div>
                                        <a href="guest_room_reservations_payments" class="btn btn-raised btn-primary waves-effect">View Payment Records</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>