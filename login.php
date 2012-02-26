<?php
ini_set("display_errors","on");
error_reporting(E_ALL);
// Include the core functions
require('functions.php');

// If a login request has been submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    
    // Search the database for the user
    $count = $db->prepare("SELECT COUNT(*) FROM clients WHERE username=? AND password=?");
    $count->execute(array($_POST['username'], createHash($_POST['password'])));
    
    // If a match was found
    if ($count->fetchColumn() != 0) {
        
        // Retrieve more information about the client
        $row = $db->prepare("SELECT * FROM clients WHERE username=? AND password=?");
        $row->execute(array($_POST['username'], createHash($_POST['password'])));
        
        // Check if the user is suspended
        if ($row['status'] == 'suspended') {
            header("location:login.php?e=suspended");
            die;
        }
        
        // Set the information as session variables
        $_SESSION['username'] = $row['username'];
        $_SESSION['maindomain'] = $row['maindomain'];
        
        // Detect the user's default style and set it
        if (file_exists("styles/{$row['style']}/style.css")) {
            $_SESSION['style'] = $row['style'];
        }else{
            $_SESSION['style'] = $config['style'];
        }
        
        // Generate and register the session
        $sessionid = rand("111111111111111111111111111111", "999999999999999999999999999999");
        $session = $db->prepare("INSERT INTO sessions (id, username) VALUES(?, ?)");
        $session->execute(array($sessionid, $row['username']));
        $_SESSION['id'] = $sessionid;
        
        // Redirect to the homepage
        header("location:./");
        
    }else{
        
        // Redirect to the failure page
        header("location:login.php?e=incorrect");
        
    }
    
    
}else{
    
    // Include the page stylesheet and headers
    includeHeader(false);
    
    ?>
    
    <table class="login" align="center"><tr><td>
        
        <h2>Toxic Manager Login</h2>
        
        <?php
        if ($_GET['e'] == 'suspended') {
            echo '<div class="error">Your account is currently suspended. Please contact your administrator for more information.</div>';
        }elseif ($_GET['e'] == 'incorrect') {
            echo '<div class="error">The username and password combination you entered is incorrect.</div>';
        }elseif ($_GET['e'] == 'session') {
            echo '<div class="error">An incorrect session ID was received. To protect from hacking, you have been automatically logged out.</div>';
        }elseif (isset($_GET['logout'])) {
            session_destroy();
            echo '<div class="success">You have been successfully logged out. Thank you for using Toxic Manager!</div>';
        }
        ?>
        
        <form method="post" action="login.php">
            <table class="fields" align="center">
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password"></td>
                </tr>
            </table>
            <input type="submit" value="Login">
        </form>
        
    </td></tr></table>
    
    <?php

    // Include the page footer
    includeFooter(false);
    
}