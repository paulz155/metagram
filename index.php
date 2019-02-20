<?php

$w1 = $argv[1];

$w2 = $argv[2];

$len1 = mb_strlen($w1, "UTF-8");
$len2 = mb_strlen($w2, "UTF-8");

if(!$len1 || $len2 != $len1) die('Неподходящие слова'); 

$max = $argv[3] ?? 5;

$data = file_get_contents("rus$len1.txt");

function search($words) {
	global $data, $w2, $max, $len1;
	$count = count($words);
	if($count > $max) return ''; 
	$s = $words[$count -1];
	for($j=0; $j < $len1; $j++) {
		$pattern = '/' . replace($s, $j, '.'). '/u';

		preg_match_all($pattern, $data, $matches); 		
		if(empty($matches)) return '';

		foreach($matches[0] as $var) {
			if(in_array($var, $words)) continue;
			
			if($var == $w2) {
				return implode('-', $words) . '-' . $w2;
			}

			$search = search($words + [$count => $var]);
			if($search != '') return $search; 
		}
	}
	
	return '';
}

function replace($string, $pos, $char, $encoding = "UTF-8")
{
    return mb_substr($string, 0, $pos, $encoding) . $char . mb_substr($string, $pos+1, NULL, $encoding);
}

echo search([$w1]);