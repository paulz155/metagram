<?php

$fp = fopen('russian.txt', 'r');
$fps = [];

while (!feof($fp)) {
	$word = fgets($fp, 40);
	$word = iconv('windows-1251', 'utf-8', trim($word));
	$len = mb_strlen($word, 'UTF-8');
	if(!isset($fps[$len])) $fps[$len] = fopen('rus' . $len . '.txt', 'w');
	fputs($fps[$len], $word . "\n");
}

fclose($fp); 

