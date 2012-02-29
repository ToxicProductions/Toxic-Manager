<?php
	require('functions.php');
	checkSession();
	includeHeader();
	
	function array_clean($arr,$use_keys=false){
		if(!is_array($arr)){
			return false;
		}else{
			$newarr = array();
			foreach($arr as $k => $v){
				if($use_keys){
					if($v != ""){
						$newarr[$k] = $v;
					}
				}else{
					if($v != ""){
						$newarr[] = $v;
					}
				}
			}
		}
		return $newarr;
	}
	exec("free -m",$out);
	$mem = $out[1];
	$swap = $out[3];
	$mem = explode(" ",$mem);
	$swap = explode(" ",$swap);
	$mem = array_clean($mem);
	$swap = array_clean($swap);
	$totalmem = $mem[1];
	$usedmem = $mem[2];
	$freemem = $mem[3];
	$percentmem = ceil(($totalmem-$freemem) * 100 / $freemem);
	if($percentmem == 0){
		$percentmem = "0";
	}
	$graphicalmem = "<table width='300' style='border-spacing: 0;'><td style='width: $percentmem%; border-top-left-radius: 10px; border-bottom-left-radius: 10px;' bgcolor='red'>&nbsp;</td><td style='width:".(100-$percentmem)."%; border-top-right-radius: 10px; border-bottom-right-radius: 10px;' bgcolor='green'>&nbsp;</td></table>";
	$totalswap = $swap[1];
	$usedswap = $swap[2];
	$freeswap = $swap[3];
	$percentswap = ceil(($freeswap - $totalswap) * 100 / $totalswap);
	if($percentswap == 0){
		$percentswap = "0";
	}
	$graphicalswap = "<table width='300' style='border-spacing: 0;'><td style='width: $percentswap%; border-top-left-radius: 10px; border-bottom-left-radius: 10px;' bgcolor='red'>&nbsp;</td><td style='width:".(100-$percentswap)."%; border-top-right-radius: 10px; border-bottom-right-radius: 10px;' bgcolor='green'>&nbsp;</td></table>";
	$load = sys_getloadavg();
	exec("uptime",$uptime);
	$uptime = explode(" ",$uptime[0]);
	$uptime = array_clean($uptime);
	$uptimeh = explode(":",$uptime[4]);
	$uptimed = $uptime[2];
	$uptimem = substr($uptimeh[1],0,strlen($uptimeh[1])-1);
	$uptimeh = $uptimeh[0];
	$uptime = "$uptimed Days, $uptimeh Hours, $uptimem Minutes";
	//echo($_SERVER['SERVER_SIGNATURE']);
	//phpinfo();
	echo("Memory: <ul><li>Total - {$totalmem}MB</li><li>Used - {$usedmem}MB</li><li>Free - {$freemem}MB</li><li>Percent used - $graphicalmem ($percentmem%)</li></ul>Swap: <ul><li>Total - {$totalswap}MB</li><li>Used - {$usedswap}MB</li><li>Free - {$freeswap}MB</li><li>Percent used - $graphicalswap ($percentswap%)</li></ul>Information: <ul><li>Server Load - {$load[0]} {$load[1]} {$load[2]}</li><li>Uptime - $uptime</li></ul>");

	includeFooter();
?>