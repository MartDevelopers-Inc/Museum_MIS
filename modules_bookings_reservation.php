<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
checklogin();

/* Update Reservation Details */
if (isset($_POST['Update_Reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_details = $_POST['reservation_details'];


    $query = "UPDATE  reservations SET reservation_date =?, reservation_details =? WHERE reservation_id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('sssss',  $reservation_date, $reservation_details, $reservation_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Reservation Updated";
    } else {
        $info = "Please Try Again Or Try Later";
    }
}

/* Pay Reservation */


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
    $ret = "SELECT * FROM rooms WHERE room_id = '$view'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($room = $res->fetch_object()) {
    ?>
        <section class="content profile-page">
            <div class="container-fluid">
                <div class="block-header">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-7">
                            <h2><?php echo $room->room_number; ?> Details</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="">Reservations</a></li>
                                <li class="breadcrumb-item"><a href="modules_bookings_rooms">Guest Rooms</a></li>
                                <li class="breadcrumb-item active"><?php echo $room->room_number; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="boxs-simple">
                            <div class="profile-header">
                                <div class="profile_info">
                                    <div class="profile-image"> <img src="assets/images/room.png" alt=""> </div>
                                    <h4 class="mb-0"><strong><?php echo $room->room_number; ?></strong></h4>
                                    <span class="">Category: <?php echo $room->room_type;  ?></span><br>
                                    <span class="">Status: <?php echo $room->room_status;  ?></span><br>
                                    <span class="">Reservation Rate: Ksh <?php echo $room->room_rate;  ?></span><br>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#room_settings">Room Settings</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#room_reservations_history">Room Reservation History</a></li>
                                    <?php
                                    $user_access_level = $_SESSION['user_access_level'];
                                    /* Only Show This If Access Level Is Admin */
                                    if ($user_access_level == 'Administrator') {
                                        if ($room->room_status == 'Occupied') {
                                    ?>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#vacate_room">Vacate Room</a></li>
                                        <?php } ?>
                                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delete_room">Delete Room</a></li>
                                    <?php } ?>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="room_settings">
                                        <div class="wrap-reset">
                                            <form method="POST">
                                                <div class="modal-body">
                                                    <div class="row clearfix">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Room Number</label>
                                                                <div class="form-line">
                                                                    <input type="text" name="room_number" value="<?php echo  $room->room_number; ?>" required class="form-control" />
                                                                    <!-- Hide This -->
                                                                    <input type="hidden" name="room_id" value="<?php echo  $room->room_id; ?>" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Room Rate Fee (Ksh)</label>
                                                                <div class="form-line">
                                                                    <input type="text" name="room_rate" value="<?php echo $room->room_rate; ?>" required class="form-control" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Room Category (type)</label>
                                                                <div class="form-line">
                                                                    <select type="text" name="room_type" required class="form-control show-tick">
                                                                        <option><?php echo $room->room_type; ?></option>
                                                                        <option>Single</option>
                                                                        <option>Double</option>
                                                                        <option>Deluxe</option>
                                                                        <option>Presidential Suite</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="Update_Room" class="btn btn-link waves-effect">SAVE </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="room_reservations_history">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th style="width:40%;">Member Details</th>
                                                    <th class="number">Accomodations Dates</th>
                                                </tr>
                                            </thead>
                                            <tbody class="no-border-x">
                                                <?php
                                                $ret = "SELECT * FROM  accomodations a
                                                INNER JOIN users u ON a.accomodation_id  = u.user_id 
                                                INNER JOIN rooms r ON r.room_id = a.accomodation_room_id
                                                WHERE r.room_id = '$view'";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($reservations = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>
                                                            Name : <?php echo $reservations->user_name; ?><br>
                                                            Phone : <?php echo $reservations->user_phone; ?><br>
                                                            Email : <?php echo $reservations->user_email; ?>
                                                        </td>
                                                        <td>
                                                            Check In:<?php echo $reservations->accomodation_check_indate; ?><br>
                                                            Check Out: <?php echo $reservations->accomodation_check_out_date; ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="vacate_room">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="card-inside-title  text-danger text-center">
                                                        Heads Up!, you are about to vacate guest in room number : <?php echo $room->room_number; ?>.
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#vacate_modal">Vacate Room</button>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="delete_room">
                                        <div class="row clearfix">
                                            <div class="modal-body">
                                                <div class="row clearfix">
                                                    <br>
                                                    <h2 class="card-inside-title  text-danger text-center">
                                                        Heads Up!, you are about to delete room number : <?php echo $room->room_number; ?>.
                                                        This action is reversible, the system will permanently delete this room
                                                        records and any other related records too.
                                                    </h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete_modal">Delete Room</button>
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
                        <h4>Delete <?php echo $room->room_number; ?> ?</h4>
                        <br>
                        <p>Heads Up, You are about to delete room number: <?php echo $room->room_number; ?>. This action is irrevisble.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_bookings_rooms?delete=<?php echo $room->room_id; ?>" class="text-center btn btn-danger"> Delete </a>
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
                        <h4>Vacate Room Number : <?php echo $room->room_number; ?> ?</h4>
                        <br>
                        <p>Heads Up, You are about to vacate a guest in room number: <?php echo $room->room_number; ?>.</p>
                        <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                        <a href="modules_bookings_room?view=<?php echo $room->room_id; ?>&vacate=<?php echo $room->room_id; ?>" class="text-center btn btn-danger"> Vacate </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>