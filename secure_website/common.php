<?php

function randString($length = 24) {
	$str = "";
	$characters = array_merge(range('a','z'), range('A','Z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
$random = randString();

function hashSRI() {
    //sri start
    $input = file_get_contents($ext_resource);
    $hash = hash('sha384', $input, true);
    $hash_base64 = base64_encode($hash);
    //sri end
    return $hsri;
}
