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
    <?php
    require_once('partials/sidebar.php');
    $view = $_GET['view'];
    $payment_service_id = $_GET['service'];
    $ret = "SELECT * FROM payments p
    INNER JOIN reservations r ON p.payment_service_paid_id = r.reservation_id
    INNER JOIN users u ON u.user_id = p.payment_user_id
    WHERE p.payment_id = '$view' AND p.payment_service_paid_id = '$payment_service_id' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($payment = $res->fetch_object()) {
        if ($payment->user_profile_pic == '') {
            $url = "assets/images/no-profile.png";
        } else {
            $url = "assets/images/$payment->user_profile_pic";
        }
    ?>
        <section class="content profile-page">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-7">
                            <h2>Museum Visit Reservation Payment Record</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="">Payments</a></li>
                                <li class="breadcrumb-item"><a href="">Resevation Payments</a></li>
                                <li class="breadcrumb-item active">Details</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="boxs-simple">
                            <div class="profile-header">
                                <div class="profile_info">
                                    <div class="profile-image"> <img src="<?php echo $url; ?>" alt=""> </div>
                                    <h4 class="mb-0"><strong><?php echo $payment->user_name; ?></strong></h4>
                                    <span class="">Email: <?php echo $payment->user_email;  ?></span><br>
                                    <span class="">Contacts: <?php echo $payment->user_phone;  ?></span><br>
                                    <span class="">ID No: <?php echo $payment->user_idno;  ?></span><br>
                                    <hr>
                                    <span class="">Visit Date: <?php echo date('d, M Y', strtotime($payment->reservation_date)); ?></span><br>
                                    <span class="">Payment Status: <?php echo $payment->reservation_payment_status; ?></span><br>
                                    <span class="">Approval Status: <?php echo $payment->reservation_status; ?></span><br>
                                    <span class="">
                                        Reservation Details:
                                        <br>
                                        <?php echo $payment->reservation_details; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-lg-12 col-md-1">
                        <div class="card">
                            <div class="body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#get_receipt">Payment Receipt</a></li>
                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                    ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_payment">Delete Payment Record</a></li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="get_receipt">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div id="print">
                                                    <div class="header text-center">
                                                        <h2>Museum Visit Reservation Payment Receipt</h2>
                                                        <h4>Receipt # <strong><?php echo $b; ?></strong>
                                                        </h4>
                                                    </div>
                                                    <div class="body">
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6">
                                                                <address>
                                                                    <strong><?php echo $payment->user_name; ?></strong><br>
                                                                    Email: <?php echo $payment->user_email; ?><br>
                                                                    <abbr title="Phone">P:</abbr> <?php echo $payment->user_phone; ?>
                                                                </address>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 text-right">
                                                                <p><strong>Reservation Visit Date: </strong> <?php echo date('M, d Y', strtotime($payment->reservation_date)); ?></p>
                                                                <p class="m-t-10"><strong>Approval Status: </strong>
                                                                    <?php if ($payment->reservation_status == 'Pending') { ?>
                                                                        <span class="badge bg-orange">Pending</span>
                                                                    <?php } else {
                                                                    ?>
                                                                        <span class="badge bg-success">Approved</span>
                                                                    <?php  } ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-40"></div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table id="mainTable" class="table table-striped" style="cursor: pointer;">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Payment Amount</th>
                                                                                <th>Confirmation Code</th>
                                                                                <th>Date Paid</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                            <tr>
                                                                                <td>Ksh <?php echo $payment->payment_amount; ?></td>
                                                                                <td><?php echo $payment->payment_confirmation_code; ?></td>
                                                                                <td><?php echo date('M, d Y', strtotime($payment->payment_created_at)); ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row" style="border-radius: 0px;">
                                                            <div class="col-md-12 text-right">
                                                                <p class="text-right"><b>Sub-total:</b> Ksh: <?php echo $payment->payment_amount; ?></p>
                                                                <hr>
                                                                <h3 class="text-right">Ksh: <?php echo $payment->payment_amount; ?></h3>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    </div>

                                                </div>
                                                <div class="hidden-print col-md-12 text-right">
                                                    <button id="print" onclick="printContent('print');" class="btn btn-raised btn-success"><i class="zmdi zmdi-print"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="delete_payment">
                                        <div class="row clearfix">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <h2 class="card-inside-title  text-danger text-center">
                                                Heads Up!, you are about to museum visit resevation payment record <br>
                                            </h2>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete_modal">Delete Payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Delete Account Modal -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CONFIRM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center text-danger">
                        <h4>Delete Record ?</h4>
                        <br>
                        <p>Heads Up, You are about to delete museum visit resevation payment record. This action is irrevisble.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_payments_resevations?delete=<?php echo $payment->payment_id; ?>" class="text-center btn btn-danger"> Delete </a>
                    </div>
                </div>
            </div>
        </div>
    <?php }
    require_once('partials/scripts.php');
    ?>
</body>

</html>