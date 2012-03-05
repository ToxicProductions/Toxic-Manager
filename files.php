<?php
require('functions.php');
checkSession();
includeHeader();

if (isset($_GET['path'])) {
    $path = $_GET['path'];
}elseif (file_exists("/home/{$_SESSION['username']}")) {
    $path = "/home/{$_SESSION['username']}";
}else{
    $path = "/";
}
?>

<h1>File Manager - <?=$path?></h1><br />
<?php
getFiles($path);
includeFooter();
?>