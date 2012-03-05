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
    
    // Get the database connection
    global $db;
    
    // If a session already exists
    if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
        
        // Search the database for the session
        $session = $db->prepare("SELECT * FROM `sessions` WHERE id=? AND username=?;");
        $session->execute(array($_SESSION['id'], $_SESSION['username']));
        
        // If a session doesn't exist
        if ($session->fetchColumn() != 0) {
            
            // Redirect to invalid session and login page
            header("location:login.php?e=session");
            die();
            
        }else{
            
            // Or get the user information from the database
            global $user;
            $user = $db->prepare("SELECT * FROM `clients` WHERE username=?");
            $user->execute(array($_SESSION['username']));
            $user = $user->fetch();
            
            // If a specific user level was requested, verify it is matched
            if ($requiredlevel != null) {
                if (strtolower($user['type']) != strtolower($requiredlevel)) {
                    header("location:403.php");
                    die();
                }
            }
            
        }
        
    }else{
        
        // No session was found, so redirect to the login page
        header("location:login.php");
        die();
        
    }
}
    

// Function to get the style header
function getFiles($dir){
	echo '<table width="100%" border="0" cellspacing="0" class="selection">';
	if($dir == "/.."){
		$dir = "/";
	}
	$files = glob($dir."/.*");
	foreach($files as $file){
		$dir1 = $dir."/";
		$file = str_replace($dir1,"",$file);
		$file = str_replace(array("/..","/."),array("..",""),$file);
		if($file != "."){
			echo '<tr>';
			if(is_dir($dir."/".$file)){
				echo("<td width=\"25\" style=\"cursor:pointer;\" onclick=\"window.location='{$_SERVER['PHP_SELF']}?path={$dir}{$file}'\"><img src=\"styles/".style()."/images/directoryicon.png\"></td>");
				echo("<td style=\"cursor:pointer;\" onclick=\"window.location='{$_SERVER['PHP_SELF']}?path={$dir}/{$file}'\"><a href='{$_SERVER['PHP_SELF']}?path={$dir}/{$file}'>".$file."</a></td>");
			}else{
				echo("<td width=\"25\"><img src=\"styles/".style()."/images/fileicon.png\"></td>");
				echo("<td>$file</td>");
			}
			
			echo("<td style=\"width:65%; text-align:right;\">");
			if(!is_dir($dir.$file)) echo("<a href=\"fileaction.php?type=editcode&path={$dir}/{$file}\" class=\"button\">Edit Code</a>");
			if(!is_dir($dir.$file)) echo("<a href=\"fileaction.php?type=wysiwyg&path={$dir}/{$file}\" class=\"button\">HTML Editor</a>");
			echo("<a href=\"fileaction.php?type=rename&path={$dir}/{$file}\" class=\"button\">Rename</a>");
			echo("<a href=\"fileaction.php?type=move&path={$dir}/{$file}\" class=\"button\">Move</a>");
			echo("<a href=\"fileaction.php?type=copy&path={$dir}/{$file}\" class=\"button\">Copy</a>");
			echo("<a href=\"fileaction.php?type=delete&path={$dir}/{$file}\" class=\"button\">Delete</a>");
			echo("</td>");
			
			echo '</tr>';
		}
	}
	$files = glob($dir."/*");
	foreach($files as $file){
		$file = str_replace($dir,"",$file);
		$filestr = str_replace("/","",$file);
		if($file != "." && $file != "/."){
			echo '<tr>';
			if(is_dir($dir.$file)){
				echo("<td width=\"25\" style=\"cursor:pointer;\" onclick=\"window.location='{$_SERVER['PHP_SELF']}?path={$dir}{$file}'\"><img src=\"styles/".style()."/images/directoryicon.png\"></td>");
				echo("<td style=\"cursor:pointer;\" onclick=\"window.location='{$_SERVER['PHP_SELF']}?path={$dir}{$file}'\"><a href='{$_SERVER['PHP_SELF']}?path={$dir}{$file}'>".$filestr."</a></td>");
			}else{
				echo("<td width=\"25\"><img src=\"styles/".style()."/images/fileicon.png\"></td>");
				echo("<td>$filestr</td>");
			}
			
			echo("<td style=\"width:65%; text-align:right;\">");
			if(!is_dir($dir.$file)) echo("<a href=\"fileaction.php?type=editcode&path={$dir}{$file}\" class=\"button\">Edit Code</a>");
			if(!is_dir($dir.$file)) echo("<a href=\"fileaction.php?type=wysiwyg&path={$dir}{$file}\" class=\"button\">HTML Editor</a>");
			echo("<a href=\"fileaction.php?type=rename&path={$dir}{$file}\" class=\"button\">Rename</a>");
			echo("<a href=\"fileaction.php?type=move&path={$dir}{$file}\" class=\"button\">Move</a>");
			echo("<a href=\"fileaction.php?type=copy&path={$dir}{$file}\" class=\"button\">Copy</a>");
			echo("<a href=\"fileaction.php?type=delete&path={$dir}{$file}\" class=\"button\">Delete</a>");
			echo("</td>");
			
			echo '</tr>';
		}
	}
	echo '</table>';
}
function includeHeader($loggedin=true) {
    
    // Get the configuration
    global $config,$user;
    
    // Ensure that the header file exists
    if (!file_exists("styles/".style()."/header.php") || !file_exists("styles/".style()."/headerdata.php")) die("Error: The requested style is missing. Please inform your system administrator.");
    
    // Include the header file/s
    require("styles/".style()."/headerdata.php");
    if ($loggedin == true) require("styles/".style()."/header.php");
    
}

// Function to get the style footer
function includeFooter($loggedin=true) {
    
    // Get the configuration
    global $config;
    
    // Ensure that the header file exists
    if (!file_exists("styles/".style()."/footer.php")) die("Error: The requested style is missing. Please inform your system administrator.");
    
    // Include the header file/s
    if ($loggedin == true) require("styles/".style()."/footer.php");
    
}

// Function to get the style name
function style() {
    global $config;
    if (isset($_GET['style'])) {
        return $_GET['style'];
    }elseif (isset($_SESSION['style'])) {
        return $_SESSION['style'];
    }else{
        return $config['style'];
    }
}

// Function to generate password hash
function createHash($pass) {
    return md5(sha1(sha1(md5(sha1(md5(md5(md5(sha1(sha1(md5(sha1(md5(md5(sha1(md5(sha1(md5(sha1(sha1(sha1(md5(md5(sha1(md5(sha1($pass))))))))))))))))))))))))));
}

// Function to generate an 'a' based on the input - very simple function
function avowel($in) {
    $vowels = array('a', 'e', 'i', 'o', 'u');
    if (in_array(strtolower($in[0]), $vowels)) {
        return "an {$in}";
    }else{
        return "a {$in}";
    }
}

?>