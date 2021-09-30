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
                                    <i class="zmdi zmdi-shopping-basket zmdi-hc-2x"></i>
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
                                        <th style="width:40%;">Product</th>
                                        <th class="number">Price</th>
                                        <th style="width:20%;">Date</th>
                                        <th style="width:20%;">State</th>
                                        <th style="width:5%;" class="actions"></th>
                                    </tr>
                                </thead>
                                <tbody class="no-border-x">
                                    <tr>
                                        <td>Sony Xperia M4</td>
                                        <td class="number">$149</td>
                                        <td>Aug 23, 2016</td>
                                        <td class="text-success">Completed</td>
                                        <td class="actions"><a href="#" class="icon"><i class="zmdi zmdi-plus-circle-o"></i></a></td>
                                    </tr>
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
                                        <th style="width:40%;">Product</th>
                                        <th class="number">Price</th>
                                        <th style="width:20%;">Date</th>
                                        <th style="width:20%;">State</th>
                                        <th style="width:5%;" class="actions"></th>
                                    </tr>
                                </thead>
                                <tbody class="no-border-x">
                                    <tr>
                                        <td>Sony Xperia M4</td>
                                        <td class="number">$149</td>
                                        <td>Aug 23, 2016</td>
                                        <td class="text-success">Completed</td>
                                        <td class="actions"><a href="#" class="icon"><i class="zmdi zmdi-plus-circle-o"></i></a></td>
                                    </tr>
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