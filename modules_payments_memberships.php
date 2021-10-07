<?php
session_start();
require_once('config/config.php');
require_once('config/checklogin.php');
require_once('config/codeGen.php');
checklogin();

/* Delete Payment */
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    $adn = "DELETE FROM payments WHERE payment_id =?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $delete);
    $stmt->execute();
    $stmt->close();
    if ($stmt) {
        $success = "Deleted" && header("refresh:1; url=modules_payments_memberships");
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
                        <h2>Payments - Membership Fee Payments</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="dashboard">Payments</a></li>
                            <li class="breadcrumb-item active">Membership</li>
                        </ul>

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
                                    <th>Membership Package</th>
                                    <th>Payment Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM payments p
                                INNER JOIN user_membership_package ump ON p.payment_service_paid_id = ump.user_membership_package_id
                                INNER JOIN users u ON u.user_id = ump.user_membership_package_user_id
                                INNER JOIN membership_packages mp ON mp.package_id = ump.user_membership_package_package_id
                                ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($payments = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <a href="modules_payments_membership?view=<?php echo $payments->payment_id; ?>&service=<?php echo $payments->payment_service_paid_id; ?>">
                                                Name : <?php echo $payments->user_name; ?> <br>
                                                Email : <?php echo $payments->user_email; ?> <br>
                                                Phone : <?php echo $payments->user_phone; ?> <br>
                                            </a>
                                        </td>
                                        <td>
                                            Name : <?php echo $payments->package_name; ?><br>
                                            Pricing : Ksh <?php echo $payments->package_pricing; ?><br>
                                        </td>
                                        <td>
                                            Confirmation ID : <?php echo $payments->payment_confirmation_code; ?><br>
                                            Amount Paid : Ksh <?php echo $payments->payment_amount; ?><br>
                                            Date Paid: <?php echo date('M, d y g:ia', strtotime($payments->payment_created_at)); ?>
                                        </td>
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
    <!-- Scripts -->
    <?php require_once('partials/scripts.php'); ?>
</body>

</html>