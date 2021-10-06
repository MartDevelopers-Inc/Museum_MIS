<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Delete Ticket */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM tickets WHERE ticket_id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=modules_events_tickets");
    } else {
        $err = "Please Try Again Later";
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
    <?php require_once('partials/sidebar.php'); ?>

    <!-- Add Staff Modal -->
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-12 col-md-6 col-sm-7">
                        <h2>Museum Events Tickets</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="dashboard">Events</a></li>
                            <li class="breadcrumb-item active">Tickets</li>
                        </ul>
                        <!-- <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add Event</button>
                        </div> -->
                    </div>
                </div>
            </div>
            <hr>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th>Event Date</th>
                                    <th>Entry Fee</th>
                                    <th>Member Details</th>
                                    <th>Date Purchased</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM tickets t
                                INNER JOIN events e ON t.ticket_event_id = e.event_id
                                INNER JOIN users s ON s.user_id = t.ticket_user_id";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($tickets = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="modules_events_ticket?view=<?php echo $tickets->ticket_id; ?>">
                                                <?php echo  date('M d Y', strtotime($tickets->event_date));  ?>
                                            </a>
                                        </td>
                                        <td>
                                            Name : <?php echo $tickets->user_name; ?><br>
                                            Phone : <?php echo $tickets->user_phone; ?><br>
                                            Email : <?php echo $tickets->user_email; ?>
                                        </td>
                                        <td>Ksh <?php echo $tickets->event_cost; ?></td>
                                        <td><?php echo $tickets->ticket_purchased_on; ?></td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Add Modal -->
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="largeModalLabel">Register New Event</h4>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Event Date</label>
                                    <div class="form-line">
                                        <input type="date" name="event_date" required class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Event Entry Fee (Ksh)</label>
                                    <div class="form-line">
                                        <input type="text" name="event_cost" required class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Event Tickets</label>
                                    <div class="form-line">
                                        <input type="text" name="event_tickets" required class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Event Details (What Is This Event About)</label>
                                    <div class="form-line">
                                        <textarea type="text" rows="5" name="event_details" class="form-control no-resize auto-growth" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="Add_Event" class="btn btn-link waves-effect">SAVE </button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>