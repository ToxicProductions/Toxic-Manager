<?php
require('functions.php');
checkSession();
includeHeader();
?>

<h1>File Manager - <?php echo((isset($_GET['path'])) ? $_GET['path'] : "/"); ?></h1><br />
<?php
getFiles((isset($_GET['path'])) ? $_GET['path'] : "/");
includeFooter();
?>