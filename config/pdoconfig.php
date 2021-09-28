<?php

/* PDO Database Connection File - Mainly Used When Loading Ajaxes   */

/* Database Host */
$DB_host = "localhost";

/* Database User */
$DB_user = "root";

/* Database Password */
$DB_pass = "";

/* Database Name */
$DB_name = "Museum_MIS";

/* Init Connection */
try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $e->getMessage();
}
