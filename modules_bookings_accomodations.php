<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Add Room Reservation */
if (isset($_POST['Add_Reservation'])) {
    $accomodation_id = $sys_gen_id;
    $accomodation_user_id = $_POST['accomodation_user_id'];
    $accomodation_check_indate = $_POST['accomodation_check_indate'];
    $accomodation_room_id = $_POST['accomodation_room_id'];
    $accomodation_payment_status = 'Pending';
    $accomodation_check_out_date = $_POST['accomodation_check_out_date'];

    $query = "INSERT INTO accomodations (accomodation_id, accomodation_user_id, accomodation_check_indate, accomodation_room_id, accomodation_payment_status, accomodation_check_out_date) VALUES(?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssssss', $accomodation_id, $accomodation_user_id, $accomodation_check_indate, $accomodation_room_id, $accomodation_payment_status, $accomodation_check_out_date);
    $stmt->execute();
    if ($stmt) {
        $success = "Reservation Posted";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}


/* Delete Reservations */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM accomodations WHERE accomodation_id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=modules_bookings_accomodations");
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
                        <h2>Museum Guest Rooms Accomodation Reservations</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="">Bookings</a></li>
                            <li class="breadcrumb-item active">Accomodations</li>
                        </ul>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add Guest Room Reservation</button>
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
                                    <th>Room Details</th>
                                    <th>Dates</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM accomodations a INNER JOIN 
                                users u ON u.user_id = a.accomodation_user_id 
                                INNER JOIN rooms r ON r.room_id = a.accomodation_room_id";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($reservations = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="modules_bookings_accomodation?view=<?php echo $reservations->accomodation_id; ?>">
                                                Name: <?php echo $reservations->user_name; ?><br>
                                                Email: <?php echo $reservations->user_email; ?><br>
                                                Contact: <?php echo $reservations->user_phone; ?>
                                            </a>
                                        </td>
                                        <td>
                                            No : <?php echo $reservations->room_number; ?><br>
                                            Type :<?php echo $reservations->room_type; ?>
                                        </td>
                                        <td>
                                            Check In : <?php echo date('d, M Y', strtotime($reservations->accomodation_check_indate)); ?><br>
                                            Check Out : <?php echo date('d, M Y g:ia', strtotime($reservations->accomodation_check_out_date)); ?>
                                        </td>
                                        <td><?php echo $reservations->accomodation_payment_status; ?></td>
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
                    <h4 class="modal-title" id="largeModalLabel">Add Guest Room Reservation</h4>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Member Name</label>
                                    <div class="form-line">
                                        <select type="text" name="accomodation_user_id" required class="form-control show-tick">
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
                                    <label>Room Number</label>
                                    <div class="form-line">
                                        <select type="text" name="accomodation_user_id" required class="form-control show-tick">
                                            <?php
                                            $ret = "SELECT * FROM rooms WHERE room_status != 'Vacant '  ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            while ($rooms = $res->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $rooms->room_id; ?>"><?php echo $rooms->room_number; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Check In Date</label>
                                    <div class="form-line">
                                        <input type="date" name="accomodation_check_indate" required class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Check In Out</label>
                                    <div class="form-line">
                                        <input type="date" name="accomodation_check_out_date" required class="form-control" />
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