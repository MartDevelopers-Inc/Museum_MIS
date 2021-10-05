<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
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
                        <a href="modules_event_manage?delete=<?php echo $event->event_id; ?>" class="text-center btn btn-danger"> Delete </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>