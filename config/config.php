<?php

/* Initiate A Procedural Database Connection */

/* Host  */
$host = "localhost";

/*Username */
$dbuser = "root";

/* Password */
$dbpass = "";

/* Database Name */

$db = "Museum_MIS";

/* Pass Connection Variables To Mysqli Function */
$mysqli = new mysqli($host, $dbuser, $dbpass, $db);
