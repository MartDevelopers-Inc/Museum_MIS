<?php

function checklogin()
{
	if (
		strlen($_SESSION['user_id']) == 0
		&& strlen($_SESSION['user_email']) == 0
		&& strlen($_SESSION['user_access_level']) == 0
	) {
		$host = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = "";
		$_SESSION["user_id"] = "";
		$_SESSION["user_email"] = "";
		$_SESSION["user_access_level"] = "";
		header("Location: http://$host$uri/$extra");
	}
}
