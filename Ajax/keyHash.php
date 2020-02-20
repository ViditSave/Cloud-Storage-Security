<?php 

if ($funType == "Signup") {
	$saltElements = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$salt = "";
	for ($i=0;$i<32;$i+=1) {
		$index = rand(0, strlen($saltElements) - 1); 
        $salt .= $saltElements[$index];
	}
}

$password = str_pad($password,32,"0",STR_PAD_RIGHT);
$tempPass = $password.$salt;
$tempPassArray = str_split($tempPass, 8);
$initRound = "ANewHashAlgorithmForOurRSIBEMajorProject";
$tempInitArray = str_split($initRound, 8);

$s = $tempPassArray; 
$t = $tempInitArray;

for ($i=0; $i<32; $i+=1) {
	$combFunc="";
	if ($i%4==0) {
		$combFunc = (($t[0] & $t[2]) | ($t[1] & $t[3]));
	}
	else if ($i%4==1) {
		$combFunc = ($t[1] ^ $t[2] ^ $t[3] ^ $t[4]);
	}
	else if ($i%4==2) {
		$combFunc = (($t[1] & $t[2]) | ($t[4] & $t[3]) | ($t[2] & $t[3]));
	}
	else {
		$combFunc = ($t[0] ^ $t[1] ^ $t[3]);
	}
	$t0New   = str_split($t[0], 4);
	$roundt0 = $t0New[1].$t0New[0];
	$t1New   = str_split($t[1], 5);
	$roundt1 = $t1New[1].$t1New[0];
	$t3New   = str_split($t[3], 6);
	$roundt3 = $t3New[1].$t3New[0];
	
	$A = ($roundt0 ^ ($combFunc & $s[$i%8]));
	$B = ($t[0] ^ $s[($i+1)%8]);
	$C = ($roundt1);
	$D = ($t[4] ^ $t[0]);
	$E = ($roundt3);
	$t = array ($A, $B, $C, $D, $E);
}
$tempFinalKey = join("",$t);
$allElements = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789[@_!#%^&*+-()>?/\|}{~]";
$finalKey = "";

for ($i=0;$i<strlen($tempFinalKey);$i+=1) {
	$finalKey.=$allElements[ord($tempFinalKey[$i])%84];
}

$finalKey = strval($finalKey);
$salt = strval($salt);
unset($funType);
?>