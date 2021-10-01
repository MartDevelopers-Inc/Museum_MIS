<?php
session_start();
require_once('config/config.php');
/* Initiate Login */
if (isset($_POST['Sign_In'])) {
    $user_email = $_POST['user_email'];
    $trimmed_password = trim($_POST['user_password']);
    $password = (sha1(md5($trimmed_password)));

    $stmt = $mysqli->prepare("SELECT user_email, user_password, user_access_level, user_id  FROM users  WHERE  (user_email =? AND user_password =?) ");
    $stmt->bind_param('ss', $user_email, $password);
    $stmt->execute();
    $stmt->bind_result($suer_email, $password, $user_access_level,  $id);
    $rs = $stmt->fetch();
    $_SESSION['user_id'] = $id;
    $_SESSION['user_email'] = $user_email;
    $_SESSION['user_access_level'] = $user_access_level;

    /* Manage Access Levels */
    if ($rs && $user_access_level == 'Member') {
        header("location:home");
    } else if (($rs && $user_access_level == 'Staff') || ($rs && $user_access_level == 'Administrator')) {
        header("location:dashboard");
    } else {
        $err = "Incorrrect Email Or Password";
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
                        <h1>Sign In </h1>
                        <h3>Sign in to your portal</h3>
                        <p>
                            By joining us, you are helping to preserve and promote Kenyan history,
                            culture and artifacts. At the same time you’ll have fun at activities
                            and events in the company of people who enjoy the same interests as you.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <h4 class="l-login">Login</h4>
                        <form class="" id="sign_in" method="POST">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input name="user_email" type="email" required class="form-control">
                                    <label class="form-label">Email Address</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="user_password" required class="form-control">
                                    <label class="form-label">Password</label>
                                </div>
                            </div>
                            <button type="submit" name="Sign_In" class="btn btn-raised waves-effect bg-red">SIGN IN</button>
                            <a href="sign_up" class="btn btn-raised waves-effect">SIGN UP</a>
                            <div class="text-left">
                                <a href="forgot_password">Forgot Password?</a>
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