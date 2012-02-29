<table class="header" align="center"><tr>
    <td class="title"><a href="./"><img src="styles/default/images/logo.png"></td>
    <td class="options">Welcome back, <?=$_SESSION['username']?>! <a href=\"login.php?logout=1\">Logout</a></td>
</tr></table>

<table class="main" align="center"><tr>
    <td class="navbar">
        <table class="navbuttons">
        <?php
        foreach($config['pages'] as $page) {
            if ((isset($page[2]) && $user['type'] == 'admin') || (!isset($page[2]))) {
                echo "<tr><td onclick=\"window.location='{$page[1]}'\">";
                echo "<a href=\"{$page[1]}\">{$page[0]}</a>";
                echo "</td></tr>";
            }
        }
        ?>
        </table>
    </td>

    <td class="content">