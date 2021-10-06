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
    $ret = "SELECT * FROM tickets t
    INNER JOIN events e ON t.ticket_event_id = e.event_id
    INNER JOIN users s ON s.user_id = t.ticket_user_id
    WHERE ticket_id = '$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($ticket = $res->fetch_object()) {
    ?>
        <section class="content profile-page">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-7">
                            <h2>Event Ticket Details</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="dashboard">Events</a></li>
                                <li class="breadcrumb-item active">Tickets</li>
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
                                    <span class="">Event Date: <?php echo  date('M d Y', strtotime($ticket->event_date));  ?></span><br>
                                    <span class="">Entry Fee: Ksh <?php echo $ticket->event_cost;  ?></span><br>
                                    <hr>
                                    <span class="">Event Details: <br>
                                        <?php echo $ticket->event_details;  ?></span>
                                    <br>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#print_ticket">Print Ticket</a></li>
                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                    ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_ticket">Delete Ticket</a></li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="print_ticket">
                                        <div class="wrap-reset">
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
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="delete_ticket">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="card-inside-title  text-danger text-center">
                                                        Heads Up!, you are about to delete this ticket.
                                                        This action is non reversible, the system will permanently delete this ticket
                                                        record.
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete_modal">Delete Ticket</button>
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
                        <h4>Delete Event Ticket</h4>
                        <br>
                        <p>Heads Up, You are about to delete this event ticket.This action is irrevisble.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_events_tickets?delete=<?php echo $ticket->ticket_id; ?>" class="text-center btn btn-danger"> Delete </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>