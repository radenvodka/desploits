<?php
error_reporting(0);
$version = array(
	'version'  	=> '1.0.3',
	'codename' 	=> 'sym',
	'date' 		=> date("d M Y")
);
$repo = array(
	'github' 	=> 'https://github.com/ekasyahwan/desploits/releases',
	'zip'  		=> 'https://github.com/ekasyahwan/desploits/archive/v1.0.2.zip',
	'tar'  		=> 'https://github.com/ekasyahwan/desploits/archive/v1.0.2.tar.gz',
);
echo json_encode(array(
	'repository'=> $repo,
	'release' 	=> $version ,
	'notice' 	=> 'lore insume'
));