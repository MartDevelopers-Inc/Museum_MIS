<?php

require_once('../config/config.php');
/* Mailer Configurations */
require_once('../vendor/phpmailer/phpmailer/src/SMTP.php');
require_once('../vendor/phpmailer/phpmailer/src/PHPMailer.php');
require_once('../vendor/phpmailer/phpmailer/src/Exception.php');

/* Fetch System Setting From DB */
$ret = "SELECT * FROM `settings`";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->setFrom($sys->mailer_mail_from_email);
    $mail->addAddress($user_email);
    $mail->FromName = $sys->name;
    $mail->isHTML(true);
    $mail->IsSMTP();
    $mail->SMTPSecure = 'ssl';
    $mail->Host = $sys->mailer_host;
    $mail->SMTPAuth = true;
    $mail->Port = '465';
    $mail->Username = $sys->mailer_username;
    $mail->Password = $sys->mailer_password;
    $mail->Subject = 'Welcome To ' . $sys->name;
    /* Custom Mail Body */
    $mail->Body = '
    <!doctype html>
    <html lang="en-US">
    
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <title>Marketing Mail</title>
        <meta name="description" content="">
        <style type="text/css">
            a:hover {text-decoration: underline !important;}
        </style>
    </head>
    
    <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
        <!--100% body table-->
        <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
            style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
            <tr>
                <td>
                    <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                        align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                    style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:0 35px;">
                                            <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:"Rubik",sans-serif;">
                                                Welcome To ' . $sys->name . '
                                            </h1>
                                            <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;">
                                            </span>
                                            <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                Hey there, <br>
                                                We are so happy you have become a member of our museum.<br>
                                                By joining us, you are helping to preserve and promote Kenyan history, culture and artifacts. 
                                                At the same time you’ll have fun at activities and events in the company of people who enjoy the same interests as you.                                                
                                            </p>
                                            <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                               <b>What you get as a new member</b>
                                               <br>
                                                Did you know as a  member you are entitled to free entry to all national and regional Museums, prehistoric sites and monuments around Kenya?
                                                The ' . $sys->name . '. is the custodian of Kenya’s natural and cultural heritage that manages Kenyan Heritage Artefacts.
                                               <br>
                                                 Kind Regards
                                               <br>
                                               <b>' . $sys->name . ' </b> <br>
                                               <i>Preserving Kenyan`s natural and cultural heritage</i>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; ' . date('Y') . ' <strong> ' . $sys->name . '. A <a href="https://martdev.info/"> MartDevelopers Inc </a> Production</strong></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    ';
}
