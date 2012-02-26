<?php
	function Run($cmd){
		$cmdparts = explode(" ",$cmd);
		switch($cmdparts[0]){
			case "echo":
				$cmdpartsnew = $cmdparts;
				if(!isset($cmdpartsnew[1])){
					$ret = "Missing parameter: ARGS";
				}else{
					unset($cmdpartsnew[0]);
					$ret = implode(" ",$cmdpartsnew);
				}
				break;
			case "help":
				$cmdpartsnew = $cmdparts;
				if(!isset($cmdpartsnew[1])){
					$ret = "echo <ARGS> - Returns ARGS\r\nhelp [COMMAND] - Returns this message or, with COMMAND, help for that command.";
				}else{
					switch($cmdpartsnew[1]){
						case "echo":
							$ret = "echo <ARGS>\r\nReturns whatever is passed via ARGS back to the user.";
							break;
						default:
							$ret = "{$cmdpartsnew[1]} is an invalid command.";
							break;
					}
				}
				break;
			default:
				$ret = "Invalid Command";
				break;
		}
		return $ret;
	}
	if(isset($_POST['cmd'])){
		$run = Run($_POST['cmd']);
		echo("<div id='return'>".nl2br(htmlspecialchars($run))."</div>");
	}
?>
<form action="./" method="POST">
	<input type='text' placeholder="Command" name="cmd" /><br />
	<input type='submit' value='Run' name='submit' />
</form>