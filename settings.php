<?php
require('functions.php');
checkSession();
includeHeader();
?>

<h1>Account Settings</h1>
<p><table><form method="POST">
<tr><td>Password:</td><td><input type='password' name='pass1' /></td></tr>
<tr><td>Re-enter Password:</td><td><input type='password' name='pass2' /></td></tr>
</form></table></p>

<?php
includeFooter();
?>