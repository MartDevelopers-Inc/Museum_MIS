<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('partials/analytics.php');
checklogin();
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
                            <li class="breadcrumb-item"><a href="home">Home</a></li>
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
                                    <span class="title">Reservations</span>
                                    <span class="value">1,305</span>
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
                                    <span class="title">Events</span>
                                    <span class="value">2,105</span>
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
                                    <span class="title">Tickets</span>
                                    <span class="value">4,054</span>
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
                                    <span class="title">Expenditure</span>
                                    <span class="value">$63.23M</span>
                                </div>
                            </div>
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