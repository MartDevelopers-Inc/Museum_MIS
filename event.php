<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Get User Ticket */
if (isset($_POST['Add_Ticket'])) {
    $ticket_id = $sys_gen_id;
    $ticket_user_id = $_POST['ticket_user_id'];
    $ticket_event_id  = $_POST['ticket_event_id'];
    $ticket_payment_status  = 'Paid';
    $ticket_purchased_on  = date('M,d Y');

    /* Payment Details */
    $payment_id = $sys_gen_id_alt_1;
    $payment_user_id = $_POST['ticket_user_id'];
    $payment_amount = $_POST['payment_amount'];
    $payment_confirmation_code = $_POST['payment_confirmation_code'];
    $payment_service_paid_id = $ticket_id;

    $query = "INSERT INTO  tickets(ticket_id, ticket_user_id, ticket_event_id, ticket_payment_status, ticket_purchased_on) VALUES(?,?,?,?,?)";
    $payment = "INSERT INTO payments(payment_id, payment_user_id, payment_amount, payment_confirmation_code, payment_service_paid_id) VALUES(?,?,?,?,?)";

    $stmt = $mysqli->prepare($query);
    $stmt_payment = $mysqli->prepare($payment);

    $rc = $stmt->bind_param('sssss', $ticket_id, $ticket_user_id, $ticket_event_id, $ticket_payment_status, $ticket_purchased_on);
    $rc = $stmt_payment->bind_param('sssss', $payment_id, $payment_user_id, $payment_amount, $payment_confirmation_code, $payment_service_paid_id);
    $stmt->execute();
    $stmt_payment->execute();

    if ($stmt && $stmt_payment) {
        $success = "Ticket Purchased";
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
    $ret = "SELECT * FROM events WHERE event_id = '$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($event = $res->fetch_object()) {
    ?>
        <section class="content profile-page">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-7">
                            <h2>Event Details</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="">Events</a></li>
                                <li class="breadcrumb-item active">Manage</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="boxs-simple">
                            <div class="profile-header">
                                <div class="profile_info">
                                    <div class="profile-image"> <img src="assets/images/event.png" alt=""> </div>
                                    <span class="">Event Date: <?php echo  date('M d Y', strtotime($event->event_date));  ?></span><br>
                                    <span class="">Entry Fee: Ksh <?php echo $event->event_cost;  ?></span><br>
                                    <span class="">Tickets Number: <?php echo $event->event_tickets;  ?></span><br>
                                    <hr>
                                    <span class="">Event Details: <br>
                                        <?php echo $event->event_details;  ?></span>
                                    <br>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#purchase_ticket">Purchase Ticket</button>
                                    </div>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#ticket_purchases">Ticket</a></li>
                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                    ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_event">Delete Event</a></li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div role="tabpanel" class="tab-pane active" id="ticket_purchases">
                                        <?php
                                        $ret = "SELECT * FROM tickets t
                                        INNER JOIN events e ON t.ticket_event_id = e.event_id
                                        INNER JOIN users s ON s.user_id = t.ticket_user_id
                                        WHERE e.event_id = '$view'";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute(); //ok
                                        $res = $stmt->get_result();
                                        while ($ticket = $res->fetch_object()) { 
                                             $paid_ticket = $ticket->ticket_id;

                                            ?>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="card">
                                                    <div id="print">
                                                        <div class="header text-center">
                                                            <h2>Museum Event Ticket</h2>
                                                            <h4>Ticket # <strong><?php echo $b; ?></strong>
                                                            </h4>
                                                        </div>
                                                        <div class="body">
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <address>
                                                                        <strong><?php echo $ticket->user_name; ?></strong><br>
                                                                        Email: <?php echo $ticket->user_email; ?><br>
                                                                        <abbr title="Phone">P:</abbr> <?php echo $ticket->user_phone; ?>
                                                                    </address>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6 text-right">
                                                                    <p><strong>Event Date : </strong><?php echo date('d, M Y', strtotime($ticket->event_date)); ?></p>
                                                                    <p><strong>Date Purchased : </strong><?php echo $ticket->ticket_purchased_on; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-40"></div>
                                                            <?php
                                                            /* Load Payment Record Related To This Reservation */
                                                            $ret = "SELECT * FROM payments  WHERE payment_service_paid_id = '$paid_ticket'";
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
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Purchase Ticket -->
        <div class="modal fade" id="purchase_ticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Purchase Ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Member Name</label>
                                        <div class="form-line">
                                            <select type="text" name="ticket_user_id" required class="form-control show-tick">
                                                <?php
                                                $user_id = $_SESSION['user_id'];
                                                $ret = "SELECT * FROM users WHERE user_access_level = 'Member' AND user_id = '$user_id'  ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($users = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $users->user_id; ?>"><?php echo $users->user_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <input value="<?php echo $event->event_id; ?>" type="hidden" name="ticket_event_id" required class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Ticket Cost(Ksh)</label>
                                        <div class="form-line">
                                            <input type="text" readonly name="payment_amount" value="<?php echo $event->event_cost; ?>" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Payment Conformation Code</label>
                                        <div class="form-line">
                                            <input type="text" name="payment_confirmation_code" value="<?php echo $sys_gen_paycode; ?>" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" name="Add_Ticket" class="btn btn-link waves-effect">SAVE </button>
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