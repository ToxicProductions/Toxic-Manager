<?php
	$config = array(
		"dbhost" => "127.0.0.1",
		"dbname" => "database",
		"dbuser" => "username",
		"dbpass" => "password",
		"style" => "default",
		
		"pages" => array(
			array("Account Settings", "settings.php"),
			array("File Manager", "files.php"),
			array("File Transfer Protocol", "ftp.php"),
			array("Email Accounts", "email.php"),
			array("Server Status", "stats.php", 1),
			array("Account Functions", "accounts.php", 1)
		)
	);