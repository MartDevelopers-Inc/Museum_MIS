<?php
$ret = "SELECT * FROM settings";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title><?php echo $sys->name; ?> | Information Management System</title>
        <!-- Favicon-->
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
        <!-- Custom Css -->
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/authentication.css">
        <link rel="stylesheet" href="assets/css/all-themes.css" />
        <!-- Load Alerts -->
        <link rel="stylesheet" href="assets/plugins/iziToast/iziToast.min.css">
        <!-- JQuery DataTable Css -->
        <link rel="stylesheet" href="assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css">
        <!-- Bootstrap Select Css -->
        <link rel="stylesheet" href="assets/plugins/bootstrap-select/css/bootstrap-select.css">
        <!-- Bootstrap Select Css -->
        <link href="assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
        <!-- Wait Me Css -->
        <link rel="stylesheet" href="assets/plugins/waitme/waitMe.css" />
    </head>
<?php } ?>