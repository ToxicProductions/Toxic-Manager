<?php
require('functions.php');
checkSession();
includeHeader();
$tickets = getTickets($_SESSION['username']);
?>

<h1>Welcome to the Toxic Manager Ticket Desk!!</h1>
<p>You are logged in as <?=avowel($user['type'])?>.</p>

<?php
includeFooter();
?>