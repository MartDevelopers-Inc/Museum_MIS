<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Add */
if (isset($_POST['Add_Event'])) {
    $event_id = $sys_gen_id;
    $event_poster = $_POST['event_poster'];
    $event_details = $_POST['event_details'];
    $event_date  = $_POST['event_date'];
    $event_cost  = $_POST['event_cost'];
    $event_status  = $_POST['event_status'];
    $event_tickets  = $_POST['event_tickets'];

    $query = "INSERT INTO events (event_id, event_poster, event_details, event_date, event_cost, event_status, event_tickets) VALUES(?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssssss', $event_id, $event_poster, $event_details, $event_date, $event_cost, $event_status, $event_tickets);
    $stmt->execute();
    if ($stmt) {
        $success = "Event Added";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}


/* Delete Room */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM events WHERE event_id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=modules_events_manage");
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
                        <h2>Museum Events</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="dashboard">Events</a></li>
                            <li class="breadcrumb-item active">Manage</li>
                        </ul>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add Event</button>
                        </div>
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
                                    <th>Date</th>
                                    <th>Entry Fee</th>
                                    <th>Available Tickets</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM events  ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($events = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="modules_events_manage?view=<?php echo $events->event_id; ?>">
                                                <?php echo $events->event_date; ?>
                                            </a>
                                        </td>
                                        <td>Ksh <?php echo $events->event_cost; ?></td>
                                        <td><?php echo $events->event_status; ?></td>u
                                        <td><?php echo $events->event_tickets; ?></td>
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