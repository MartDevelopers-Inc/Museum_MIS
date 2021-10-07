<?php
session_start();
require_once('../config/config.php');
require_once('../config/codeGen.php');

/* Reset Password */
if (isset($_POST['Confirm_Password'])) {

    $user_email  = $_SESSION['user_email'];
    $new_password = sha1(md5($_POST['new_password']));
    $confirm_password = sha1(md5($_POST['confirm_password']));
    /* Check If Passwords Match */
    if ($new_password != $confirm_password) {
        /* Die */
        $err = "Passwords Does Not Match";
    } else {
        /* Update Password */
        $query = "UPDATE users  SET  user_password =? WHERE  user_email = ? ";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc = $stmt->bind_param('ss',  $confirm_password, $user_email);
        $stmt->execute();
        if ($stmt) {
            $success = "Password Reset" && header("refresh:1; url=index");
        } else {
            $err = "Password Reset Failed";
        }
    }
}
require_once('partials/head.php');
?>

<body class="theme-red">
    <div class="authentication">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="l-detail">
                        <h1>Forgot Password</h1>
                        <p>
                            <br>
                            Can`t remember your password?, Worry no more,
                            just enter your <br>
                            e-mail address to reset your password.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <h4 class="l-login">COnfirm Password</h4>
                        <form class="" id="sign_in" method="POST">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="new_password" type="password" required class="form-control">
                                    <label class="form-label">New Password</label>
                                </div>
                                <div class="form-line">
                                    <input name="confirm_password" type="password" required class="form-control">
                                    <label class="form-label">Confirm Password</label>
                                </div>
                            </div>
                            <button type="submit" name="Confirm_Password" class="btn btn-raised waves-effect bg-red">Confirm Password</button>
                            <div class="text-left">
                                <a href="login">Remember password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('partials/scripts.php'); ?>
</body>

</html>