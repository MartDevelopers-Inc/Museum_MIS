<?php
require_once('config/config.php');
require_once('config/codeGen.php');

/* Sign Up */
if (isset($_POST['Sign_Up'])) {

    /* Prevent Double Entry */
    $user_email = $_POST['user_email'];
    $sql = "SELECT * FROM  users  WHERE  user_email = '$user_email' ";
    $res = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if ($user_email == $row['user_email']) {
            $err = 'Account With This Email  Already Exists';
        }
    } else {
        $user_id = $sys_gen_id;
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = sha1(md5($_POST['user_password']));
        $user_created_on = date('d M Y');
        $user_access_level = 'Member';

        $query = 'INSERT INTO users(user_id, user_name, user_email, user_password, user_created_on, user_access_level) VALUES (?,?,?,?,?,?)';
        $stmt = $mysqli->prepare($query);
        $rc = $stmt->bind_param(
            'ssssss',
            $user_id,
            $user_name,
            $user_email,
            $user_password,
            $user_created_on,
            $user_access_level

        );
        $stmt->execute();
        /* Mail User */
        require_once('mailers/new_user.php');
        if ($stmt && $mail->send()) {
            $success = "Account Created, Kindly Proceed To Sign In";
        } else {
            $err = 'Please Try Again Or Try Later';
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
                        <h1>Sign Up</h1>
                        <h3>Create an account</h3>
                        <p>
                            Did you know as a member you are entitled to free entry to all national and regional Museums,
                            prehistoric sites and monuments around Kenya? Sign up right now and enjoy this chance.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="card">
                        <h4 class="l-login">Register
                            <div class="msg">Register a new membership</div>
                        </h4>
                        <form class="" id="sign_in" method="POST">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="user_name" required class="form-control">
                                    <label class="form-label">Full Name</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="email" name="user_email" required class="form-control">
                                    <label class="form-label">Email Address</label>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="password" name="user_password" required class="form-control">
                                    <label class="form-label">Password</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" required name="terms" id="terms" class="filled-in chk-col-pink">
                                <label for="terms">I read and agree to the terms of usage</label>
                            </div>
                            <div class="text-left">
                                <button type="submit" name="Sign_Up" class="btn btn-raised waves-effect bg-red">SIGN UP</button>
                            </div>
                            <div class="m-t-10 m-b--5"> <a href="login">I already have a membership?</a> </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('partials/scripts.php'); ?>
</body>

</html>