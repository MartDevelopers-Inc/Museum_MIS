<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Add Room */
if (isset($_POST['Add_Room'])) {
    $room_id = $sys_gen_id;
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $room_rate = $_POST['room_rate'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM  rooms WHERE room_number = '$room_number'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($room_number == $row['room_number']) {
            $err =  "Room Number Already Exists";
        }
    } else {
        $query = "INSERT INTO rooms (room_id, room_number, room_type, room_rate) VALUES(?,?,?,?)";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ssss', $room_id, $room_number, $room_type, $room_rate);
        $stmt->execute();
        if ($stmt) {
            $success = "$room_number - $room_type Added";
        } else {
            $info = "Please Try Again Or Try Later";
        }
    }
}

/* Delete Room */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM rooms WHERE room_id =?";
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
                        <h2>Museum Membership Packages</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Memberships</li>
                        </ul>
                        <div class="text-right">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add Membership Package</button>
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
                                    <th>Name</th>
                                    <th>Fee</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM membership_packages  ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($packages = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="modules_memberships_package?view=<?php echo $packages->package_id; ?>">
                                                <?php echo $packages->package_name; ?>
                                            </a>
                                        </td>
                                        <td>Ksh <?php echo $packages->package_pricing; ?></td>
                                        <td><?php echo $packages->package_details; ?></td>
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
                    <h4 class="modal-title" id="largeModalLabel">Register New Memberships Package</h4>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Package Name</label>
                                    <div class="form-line">
                                        <input type="text" name="package_name" required class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Package Subscription Fee (Ksh)</label>
                                    <div class="form-line">
                                        <input type="text" name="package_pricing" required class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Package Details</label>
                                    <div class="form-line">
                                        <textarea type="text" rows="5" name="package_details" class="form-control no-resize auto-growth" required /></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="Add_Package" class="btn btn-link waves-effect">SAVE </button>
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