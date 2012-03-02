<?php

ini_set("display_errors","off");
//error_reporting(E_ALL);

if ($_GET['pass'] == '1139414663') {

	//echo exec('cd /home/manager/public_html/; git reset --hard');
	echo exec('cd /home/manager/public_html/; git pull');
	echo exec('chmod -R 0755 /home/manager/public_html');

/*
if (!function_exists("ssh2_connect")) die("function ssh2_connect doesn't exist");
// log in at server1.example.com on port 22
if(!($con = ssh2_connect("localhost", 22))){
    echo "fail: unable to establish connection\n";
} else {
    // try to authenticate with username root, password secretpassword
    if(!ssh2_auth_password($con, "manager", "flakebar1")) {
        echo "fail: unable to authenticate\n";
    } else {
        // allright, we're in!
        echo "okay: logged in...\n";
        // execute a command
        if (!($stream = ssh2_exec($con, "cd /home/manager/public_html/; /usr/bin/git pull" ))) {
            echo "fail: unable to execute command\n";
        } else {
	    echo "Output:";
	    sleep(1);
            // collect returning data from command
            stream_set_blocking($stream, true);
            var_dump(fread($stream, 4096));
	    fclose($stream);
        }
    }
}
*/

}else{
	header("Status: 403 Forbidden");
}
