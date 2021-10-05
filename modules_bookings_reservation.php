<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Update Reservation Details */
if (isset($_POST['Update_Reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_details = $_POST['reservation_details'];

    $query = "UPDATE  reservations SET reservation_date =?, reservation_details =? WHERE reservation_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sss',  $reservation_date, $reservation_details, $reservation_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Reservation Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Pay Reservation */
if (isset($_POST['Pay_Reservation'])) {
    $payment_id = $sys_gen_id;
    $payment_user_id = $_POST['payment_user_id'];
    $payment_amount = $_POST['payment_amount'];
    $payment_confirmation_code = $_POST['payment_confirmation_code'];
    $payment_service_paid_id = $_POST['payment_service_paid_id'];

    $query = "INSERT INTO payments(payment_id, payment_user_id, payment_amount, payment_confirmation_code, payment_service_paid_id) VALUES(?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssssss',  $payment_id, $payment_user_id, $payment_amount, $payment_confirmation_code, $payment_service_paid_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Reservation Payment Posted";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}


/* Approve Reservation */
if (isset($_GET['Approve_Reservation'])) {
    $reservation_id = $_GET['view'];
    $reservation_status = 'Approved';

    $query = "UPDATE  reservations SET reservation_status =? WHERE reservation_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ss',  $reservation_status, $reservation_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Reservation $reservation_status" && header("refresh:1; url=modules_bookings_reservation?view=$reservation_id");
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

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
    $ret = "SELECT * FROM reservations r INNER JOIN 
    users u ON u.user_id = r.reservation_user_id  WHERE reservation_id = '$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($reservation = $res->fetch_object()) {
    ?>
        <section class="content profile-page">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-7">
                            <h2><?php echo $reservation->user_name; ?> Museum Visit Reservation Details</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="modules_bookings_reservations">Bookings</a></li>
                                <li class="breadcrumb-item"><a href="modules_bookings_reservations">Reservations</a></li>
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
                                    <div class="profile-image"> <img src="assets/images/reservation.png" alt=""> </div>
                                    <h4 class="mb-0"><strong><?php echo $reservation->user_name; ?> Museum Visit Reservation</strong></h4>
                                    <span class="">Visit Date: <?php echo date('d, M Y', strtotime($reservation->reservation_date)); ?></span><br>
                                    <span class="">Payment Status: <?php echo $reservation->reservation_payment_status; ?></span><br>
                                    <span class="">Approval Status: <?php echo $reservation->reservation_status; ?></span><br>
                                    <hr>
                                    <span class="">
                                        Reservation Details:
                                        <br>
                                        <?php echo $reservation->reservation_details; ?>
                                    </span>
                                    <br>
                                    <?php
                                    if ($reservation->reservation_payment_status != 'Paid') {
                                    ?>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pay_reservation">Pay Reservation</button>
                                        </div>
                                    <?php } ?>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#reservation_update">Update Reservation</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reservation_payment">Reservation Payment Record</a></li>
                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                        if ($reservation->reservation_status != 'Approved') {
                                    ?>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#approve_reservation">Approve Reservation</a></li>
                                        <?php } ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_reservation">Delete Reservation</a></li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="reservation_update">
                                        <div class="wrap-reset">
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <div class="row clearfix">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Reservation Visit Date</label>
                                                                <div class="form-line">
                                                                    <input type="date" value="<?php echo $reservation->reservation_date; ?>" name="reservation_date" required class="form-control" />
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" value="<?php echo $reservation->reservation_id; ?>" name="reservation_id" required class="form-control" />

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Reservation Visit Details (Indicate Places You Want To Visit)</label>
                                                                <div class="form-line">
                                                                    <textarea type="text" rows="5" name="reservation_details" class="form-control no-resize auto-growth" required /><?php echo $reservation->reservation_details; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="Update_Reservation" class="btn btn-link waves-effect">SAVE </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="reservation_payment">
                                        <!-- Payment Record -->
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
                                                                    <strong><?php echo $reservation->user_name; ?></strong><br>
                                                                    Email: <?php echo $reservation->user_email; ?><br>
                                                                    <abbr title="Phone">P:</abbr> <?php echo $reservation->user_phone; ?>
                                                                </address>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 text-right">
                                                                <p><strong>Reservation Visit Date: </strong> <?php echo date('M, d Y', strtotime($reservation->reservation_date)); ?></p>
                                                                <p class="m-t-10"><strong>Approval Status: </strong>
                                                                    <?php if ($reservation->reservation_status == 'Pending') { ?>
                                                                        <span class="badge bg-orange">Pending</span>
                                                                    <?php } else {
                                                                    ?>
                                                                        <span class="badge bg-success">Approved</span>
                                                                    <?php  } ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="mt-40"></div>
                                                        <?php
                                                        /* Load Payment Record Related To This Reservation */
                                                        $ret = "SELECT * FROM payments  WHERE payment_service_paid_id = '$view'";
                                                        $stmt = $mysqli->prepare($ret);
                                                        $stmt->execute(); //ok
                                                        $res = $stmt->get_result();
                                                        while ($payment_details = $res->fetch_object()) {
                                                        ?>
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
                                                                                    <td>Ksh <?php echo $payment_details->payment_amount; ?></td>
                                                                                    <td><?php echo $payment_details->payment_confirmation_code; ?></td>
                                                                                    <td><?php echo date('M, d Y', strtotime($payment_details->payment_created_at)); ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row" style="border-radius: 0px;">
                                                                <div class="col-md-12 text-right">
                                                                    <p class="text-right"><b>Sub-total:</b> Ksh: <?php echo $payment_details->payment_amount; ?></p>
                                                                    <p class="text-right">Discout: 12.9%</p>
                                                                    <p class="text-right">VAT: 12.9%</p>
                                                                    <hr>
                                                                    <h3 class="text-right">Ksh: <?php echo $payment_details->payment_amount; ?></h3>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <hr>
                                                    </div>

                                                </div>
                                                <div class="hidden-print col-md-12 text-right">
                                                    <button id="print" onclick="printContent('print');" class="btn btn-raised btn-success"><i class="zmdi zmdi-print"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="approve_reservation">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="text-danger text-center">
                                                        Heads Up!, you are about to approve this reservation record.
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#approve">Approve Reservation</button>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="delete_reservation">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="text-danger text-center">
                                                        Heads Up!, you are about to delete this reservation record.
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete_modal">Delete Reservation</button>
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
                        <h4>Delete Reservation</h4>
                        <br>
                        <p>Heads Up, You are about to delete this reservation record, This action is irrevisble.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_bookings_reservations?delete=<?php echo $reservation->reservation_id; ?>" class="text-center btn btn-danger"> Delete </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Approve Reservation -->
        <div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CONFIRM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center text-danger">
                        <h4>Approve Reservation</h4>
                        <br>
                        <p>Heads Up, You are about to approve this reservation record</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_bookings_reservation?view=<?php echo $reservation->reservation_id; ?>&Approve_Reservation=<?php echo $reservation->reservation_id; ?>" class="text-center btn btn-danger"> Approve </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pay Reservation -->
        <div class="modal fade" id="pay_reservation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">RESERVATION PAYMENT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Reservation Amount (Ksh)</label>
                                        <div class="form-line">
                                            <input type="text" name="payment_amount" value="2000" required class="form-control" />
                                            <!-- Hide This -->
                                            <input type="hidden" name="payment_user_id" value="<?php echo $reservation->reservation_user_id; ?>" required class="form-control" />
                                            <input type="hidden" name="payment_service_paid_id" value="<?php echo $view; ?>" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Payment Confirmation</label>
                                        <div class="form-line">
                                            <input type="text" name="payment_confirmation_code" value="<?php echo $sys_gen_paycode; ?>" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="Pay_Reservation" class="btn btn-link waves-effect">SAVE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>