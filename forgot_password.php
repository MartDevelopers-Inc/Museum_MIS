<?php
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

                            <button type="submit" name="Sign_In" class="btn btn-raised waves-effect bg-red">SIGN IN</button>
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