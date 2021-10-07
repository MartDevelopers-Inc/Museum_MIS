<?php
session_start();
require_once('config/config.php');
require_once('config/codeGen.php');

/* Reset Password */
if (isset($_POST['Reset_Password'])) {

    $user_email = $_POST['user_email'];
    $query = mysqli_query($mysqli, "SELECT * FROM `users` WHERE user_email = '" . $user_email . "' ");
    $num_rows = mysqli_num_rows($query);

    if ($num_rows > 0) {
        $n = date('y'); //Load Mumble Jumble
        $new_password = bin2hex(random_bytes($n));
        $query = "UPDATE users SET  user_password=? WHERE  user_email =? ";
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param('ss', $new_password, $user_email);
        $stmt->execute();
        if ($stmt) {
            $_SESSION['user_email'] = $user_email;
            $success = "Password Reset" && header("refresh:1; url=confirm_password");
        } else {
            $err = "Password reset failed";
        }
    } else {
        $err = "User Account Does Not Exist";
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
                        <h4 class="l-login">Reset Password</h4>
                        <form class="" id="sign_in" method="POST">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="user_email" type="email" required class="form-control">
                                    <label class="form-label">Email Address</label>
                                </div>
                            </div>

                            <button type="submit" name="Reset_Password" class="btn btn-raised waves-effect bg-red">RESET PASSWORD</button>
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