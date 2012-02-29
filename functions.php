<?php

#############################
## Toxic-Manager Functions ##
### Core Global Functions ###
####### See README.md #######
#############################

// Start the session
session_start();

// Include the configuration file
(!file_exists("config.php")) ? die("config.php doesn't exist. Please refer to config.example.php") : require('config.php');

// Connect to the database
$db = new PDO("mysql:host={$config['dbhost']};dbname={$config['dbname']};port={$config['dbport']}", $config['dbuser'], $config['dbpass']);

// Function to check the user's session exists
function checkSession($requiredlevel=null) {
    if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
        $session = $db->prepare("SELECT * FROM `sessions` WHERE id=? AND username=?;");
        $session->execute(array($_SESSION['id'], $_SESSION['username']));
        if ($session->fetchColumn() != 0) {
            header("location:login.php?e=session");
            die();
        }else{
            global $user;
            $user = $db->prepare("SELECT * FROM `clients` WHERE username=?");
            $user->execute(array($_SESSION['username']));
            $user = $user->fetch();
            if ($requiredlevel != null) {
                if (strtolower($user['type']) != strtolower($requiredlevel)) {
                    header("location:403.php");
                    die();
                }
            }
        }
    }else{
        header("location:login.php");
        die();
    }
}
    

// Function to get the style header
function includeHeader($loggedin=true) {
    
    // Get the configuration
    global $config;
    
    // Detect the requested style
    if (isset($_GET['style'])) {
        $style = $_GET['style'];
    }elseif (isset($_SESSION['style'])) {
        $style = $_SESSION['style'];
    }else{
        $style = $config['style'];
    }
    
    // Ensure that the header file exists
    if (!file_exists("styles/{$style}/header.php") || !file_exists("styles/{$style}/headerdata.php")) die("Error: The requested style is missing. Please inform your system administrator.");
    
    // Include the header file/s
    require("styles/{$style}/headerdata.php");
    if ($loggedin == true) require("styles/{$style}/header.php");
    
}

// Function to get the style footer
function includeFooter($loggedin=true) {
    
    // Get the configuration
    global $config;
    
    // Detect the requested style
    if (isset($_GET['style'])) {
        $style = $_GET['style'];
    }elseif (isset($_SESSION['style'])) {
        $style = $_SESSION['style'];
    }else{
        $style = $config['style'];
    }
    
    // Ensure that the header file exists
    if (!file_exists("styles/{$style}/footer.php")) die("Error: The requested style is missing. Please inform your system administrator.");
    
    // Include the header file/s
    if ($loggedin == true) require("styles/{$style}/footer.php");
    
}

// Function to generate password hash
function createHash($pass) {
    return md5(sha1(sha1(md5(sha1(md5(md5(md5(sha1(sha1(md5(sha1(md5(md5(sha1(md5(sha1(md5(sha1(sha1(sha1(md5(md5(sha1(md5(sha1($pass))))))))))))))))))))))))));
}

?>