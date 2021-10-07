<?php
$user_rank = $_SESSION['user_access_level'];
$ret = "SELECT * FROM settings";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
    if ($user_rank == 'Member') {
?>
        <nav class="navbar">
            <div class="col-12">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="home"><?php echo $sys->name; ?> MIS</a>
                </div>
                <ul class="nav navbar-nav navbar-right">

                    <li><a href="logout" class="mega-menu" data-close="true"><i class="zmdi zmdi-power"></i></a></li>
                </ul>
            </div>
        </nav>
    <?php
    } else {
    ?>
        <nav class="navbar">
            <div class="col-12">
                <div class="navbar-header">
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="dashboard"><?php echo $sys->name; ?> MIS</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout" class="mega-menu" data-close="true"><i class="zmdi zmdi-power"></i></a></li>
                </ul>
            </div>
        </nav>
<?php
    }
}
?>