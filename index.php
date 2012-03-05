<?php
require('functions.php');
checkSession();
includeHeader();
?>

<h1>Welcome to Toxic Manager!</h1>
<p>You are now logged in as <?=avowel($user['type'])?>.</p>

<?php
includeFooter();
?>