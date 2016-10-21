<?php
$base = base64_decode("ZGVzcGxvaXRzLnBocA==");
if($command[input][0] === $base && $command[input][1] === "--help"){
	$desploit->help();
}
if($command[input][0] === $base && $command[input][1] === "--update"){
	$desploit->update();
}
if($command[input][0] === $base && $command[url] && $command[fadmin]){
	$fadmin->single($command[url],$command[fadmin]);
}
if($command[input][0] === $base && $command["url-list"] && $command[fadmin]){
	$fadmin->mass($command["url-list"],$command[fadmin]);
}
if($command[input][0] === $base && $command[input][1] === "--wpbrute" && $command[url] && $command[setuser] && $command[passlist]){
	$wordpress->single($command[url],$command[setuser],$command[passlist]);
}
if($command[input][0] === $base && $command[input][1] === "--wpbrute" && $command["url-list"] && $command[setuser] && $command[passlist]){
	$wordpress->mass($command["url-list"],$command[setuser],$command[passlist]);
}
