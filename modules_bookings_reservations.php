<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Add Room Reservation */
if (isset($_POST['Add_Reservation'])) {
    $reservation_id = $sys_gen_id;
    $reservation_user_id = $_POST['reservation_user_id'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_details = $_POST['reservation_details'];
    $reservation_payment_status = 'Pending';

    $query = "INSERT INTO reservations (reservation_id, reservation_user_id, reservation_date, reservation_details, reservation_payment_status) VALUES(?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssss', $reservation_id, $reservation_user_id, $reservation_date, $reservation_details, $reservation_payment_status);
    $stmt->execute();
    if ($stmt) {
        $success = "Museum Reservation Added";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}


/* Delete Reservations */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM reservations WHERE reservation_id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=modules_bookings_reservations");
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
                        <h2>Museum Visit Reservations</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Bookings</a></li>
                            <li class="breadcrumb-item active">Reservations</li>
                        </ul>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add Museum Visit Reservation</button>
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
                                    <th>Member Details</th>
                                    <th>Dates</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM reservations r INNER JOIN 
                                users u ON u.user_id = r.reservation_user_id ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($reservations = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="modules_bookings_reservation?view=<?php echo $reservations->reservation_id; ?>">
                                                Name: <?php echo $reservations->user_name; ?><br>
                                                Email: <?php echo $reservations->user_email; ?><br>
                                                Contact: <?php echo $reservations->user_phone; ?>
                                            </a>
                                        </td>
                                        <td>
                                            Visit Date : <?php echo date('d, M Y', strtotime($reservations->reservation_date)); ?><br>
                                            Created At : <?php echo date('d, M Y g:ia', strtotime($reservations->reservation_created_at)); ?>
                                        </td>
                                        <td><?php echo $reservations->reservation_payment_status; ?></td>
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
                    <h4 class="modal-title" id="largeModalLabel">Add Member Museum Visit Reservation</h4>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Member Name</label>
                                    <div class="form-line">
                                        <select type="text" name="reservation_user_id" required class="form-control show-tick">
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
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Reservation Visit Date</label>
                                    <div class="form-line">
                                        <input type="date" name="reservation_date" required class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Reservation Visit Details (Indicate Places You Want To Visit)</label>
                                    <div class="form-line">
                                        <textarea type="text" rows="5" name="reservation_details" class="form-control no-resize auto-growth" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="Add_Reservation" class="btn btn-link waves-effect">SAVE </button>
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