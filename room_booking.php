<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Update Reservation Details */
if (isset($_POST['Update_Reservation'])) {
    $accomodation_id = $_POST['accomodation_id'];
    $accomodation_check_indate = $_POST['accomodation_check_indate'];
    $accomodation_room_id = $_POST['accomodation_room_id'];
    $accomodation_check_out_date = $_POST['accomodation_check_out_date'];

    $query = "UPDATE accomodations  SET accomodation_check_indate =?, accomodation_room_id =?,accomodation_check_out_date =? WHERE accomodation_room_id =?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssss',  $accomodation_check_indate, $accomodation_room_id, $accomodation_check_out_date, $accomodation_room_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Accomodation Updated";
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
    $ret = "SELECT * FROM accomodations a INNER JOIN 
    users u ON u.user_id = a.accomodation_user_id 
    INNER JOIN rooms r ON r.room_id = a.accomodation_room_id
    WHERE a.accomodation_id = '$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($reservation = $res->fetch_object()) {
        $checkin = strtotime($reservation->accomodation_check_indate);
        $checkout = strtotime($reservation->accomodation_check_out_date);
        $days_reserved = $checkout - $checkin;
        round($days_reserved / (60 * 60 * 24));
        $daysreserved = abs(round($days_reserved / (60 * 60 * 24)));
    ?>
        <section class="content profile-page">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-7">
                            <h2><?php echo $reservation->user_name; ?> Museum Room Reservation Details</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="room_bookings">Reservations</a></li>
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
                                    <h4 class="mb-0"><strong><?php echo $reservation->user_name; ?> Room Reservation</strong></h4>
                                    <span class="">Check In : <?php echo date('d, M Y', strtotime($reservation->accomodation_check_indate)); ?></span><br>
                                    <span class="">Check Out : <?php echo date('d, M Y', strtotime($reservation->accomodation_check_out_date)); ?></span><br>
                                    <span class="">Payment Status: <?php echo $reservation->accomodation_payment_status; ?></span><br>
                                    <span class="">Booked Room Number: <?php echo $reservation->room_number; ?></span><br>
                                    <span class="">Booked Room Type: <?php echo $reservation->room_type; ?></span><br>
                                    <span class="">Booked Room Rate: Ksh <?php echo $reservation->room_rate; ?></span><br>
                                    <span class="">Days Booked: <?php echo $daysreserved; ?> Day(s)</span><br>
                                    <span class="">Reservation Amount: Ksh <?php echo ($daysreserved) * ($reservation->room_rate); ?> </span><br>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#reservation_update">Update Booking</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reservation_payment">Booking Payment Record</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_reservation">Cancel Reservation</a></li>

                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                        if ($reservation->room_status == 'Occupied') {


                                    ?>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#vacate_room">Vacate Room</a></li>
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
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Room Number</label>
                                                                <div class="form-line">
                                                                    <select readonly type="text" name="accomodation_room_id" required class="form-control show-tick">
                                                                        <option value="<?php echo $reservation->room_id; ?>"><?php echo $reservation->room_number; ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Check In Date</label>
                                                                <div class="form-line">
                                                                    <input type="date" value="<?php echo $reservation->accomodation_check_indate; ?>" name="accomodation_check_indate" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Check In Out</label>
                                                                <div class="form-line">
                                                                    <input type="date" value="<?php echo $reservation->accomodation_check_out_date; ?>" name="accomodation_check_out_date" required class="form-control" />
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" value="<?php echo $reservation->accomodation_id; ?>" name="accomodation_id" required class="form-control" />
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
                                                        <h2>Museum Guest Room Reservation Payment Receipt</h2>
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
                                                                <p><strong>Check In Date: </strong><?php echo date('d, M Y', strtotime($reservation->accomodation_check_indate)); ?></p>
                                                                <p><strong>Check Out Date: </strong><?php echo date('d, M Y', strtotime($reservation->accomodation_check_out_date)); ?></p>
                                                                <p><strong>Room Number: </strong><?php echo $reservation->room_number; ?></p>
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
                                                                    <p class="text-right">Room Rate : <?php echo $reservation->room_rate; ?></p>
                                                                    <p class="text-right">Days Booked: <?php echo $daysreserved; ?>

                                                                    </p>
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

                                    <div role="tabpanel" class="tab-pane" id="delete_reservation">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="text-danger text-center">
                                                        Heads Up!, you are about to cancel this reservation record.
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete_modal">Cancel Reservation</button>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="vacate_room">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="text-danger text-center">
                                                        Heads Up!, you are about to vacate a guest in room number : <?php echo $reservation->room_number; ?>.
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vacate_modal">Vacate Guest</button>
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
                        <h4>Cancel Reservation</h4>
                        <br>
                        <p>Heads Up, You are about to cancel this reservation record, This action is irrevisble.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="room_booking?delete=<?php echo $reservation->accomodation_id; ?>&room=<?php echo $reservation->room_id; ?>" class="text-center btn btn-danger"> Cancel Reservation </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vacate Room Modal -->
        <div class="modal fade" id="vacate_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CONFIRM</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center text-danger">
                        <h4>Vacate Guest In Room Number : <?php echo $reservation->room_number; ?></h4>
                        <br>
                        <p>Heads Up, You are about to vacate <?php echo $reservation->user_name; ?>.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_bookings_accomodation?view=<?php echo $reservation->accomodation_id; ?>&vacate=<?php echo $reservation->room_id; ?>" class="text-center btn btn-danger"> Vacate </a>
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
                                        <label>Accomodation Amount (Ksh)</label>
                                        <div class="form-line">
                                            <input type="text" name="payment_amount" value="<?php echo ($daysreserved) * ($reservation->room_rate); ?>" required class="form-control" />
                                            <!-- Hide This -->
                                            <input type="hidden" name="payment_user_id" value="<?php echo $reservation->accomodation_user_id; ?>" required class="form-control" />
                                            <input type="hidden" name="payment_service_paid_id" value="<?php echo $view; ?>" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Payment Confirmation Codes</label>
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