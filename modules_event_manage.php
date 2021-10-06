<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Update Event Details */
if (isset($_POST['Update_Event'])) {
    $event_id = $_POST['event_id'];
    $event_details = $_POST['event_details'];
    $event_date  = $_POST['event_date'];
    $event_cost  = $_POST['event_cost'];
    $event_tickets  = $_POST['event_tickets'];

    $query = "UPDATE  events SET event_details =?, event_date =?, event_cost =?, event_tickets =? WHERE event_id= ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssss', $event_details, $event_date, $event_cost, $event_tickets, $event_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Event Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

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
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="dashboard">Events</a></li>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#event_settings">Update Event</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ticket_purchases">Tickets Purchases</a></li>
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
                                    <div role="tabpanel" class="tab-pane active" id="event_settings">
                                        <div class="wrap-reset">
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <div class="row clearfix">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Event Date</label>
                                                                <div class="form-line">
                                                                    <input value="<?php echo $event->event_date; ?>" type="date" name="event_date" required class="form-control" />
                                                                    <!-- Event Date -->
                                                                    <input value="<?php echo $event->event_id; ?>" type="hidden" name="event_id" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Event Entry Fee (Ksh)</label>
                                                                <div class="form-line">
                                                                    <input type="text" value="<?php echo $event->event_cost; ?>" name="event_cost" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label>Event Tickets</label>
                                                                <div class="form-line">
                                                                    <input type="text" name="event_tickets" value="<?php echo $event->event_tickets; ?>" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Event Details (What Is This Event About)</label>
                                                                <div class="form-line">
                                                                    <textarea type="text" rows="5" name="event_details" class="form-control no-resize auto-growth" required /><?php echo $event->event_details; ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="Update_Event" class="btn btn-link waves-effect">SAVE </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="ticket_purchases">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Member Details</th>
                                                    <th>Ticket Payment </th>
                                                    <th>Date Purchased</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM tickets t
                                                INNER JOIN events e ON t.ticket_event_id = e.event_id
                                                INNER JOIN users s ON s.user_id = t.ticket_user_id
                                                WHERE e.event_id = '$view'
                                                  ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($tickets = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            Name : <?php echo $tickets->user_name; ?><br>
                                                            Phone : <?php echo $tickets->user_phone; ?><br>
                                                            Email : <?php echo $tickets->user_email; ?>
                                                        </td>
                                                        </td>
                                                        <td><?php echo $tickets->ticket_payment_status; ?></td>
                                                        <td><?php echo $tickets->ticket_purchased_on; ?></td>
                                                    </tr>
                                                <?php
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>


                                    <div role="tabpanel" class="tab-pane" id="delete_event">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="card-inside-title  text-danger text-center">
                                                        Heads Up!, you are about to delete This event.
                                                        This action is non reversible, the system will permanently delete this event
                                                        records and any other Tickets related records too.
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete_modal">Delete Event</button>
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
                        <h4>Delete Event</h4>
                        <br>
                        <p>Heads Up, You are about to delete this event.This action is irrevisble.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_events_manage?delete=<?php echo $event->event_id; ?>" class="text-center btn btn-danger"> Delete </a>
                    </div>
                </div>
            </div>
        </div>
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
                                                $ret = "SELECT * FROM users WHERE user_access_level = 'Member'  ";
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