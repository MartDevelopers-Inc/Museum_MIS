<?php
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