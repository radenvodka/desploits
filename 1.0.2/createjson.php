<?php
error_reporting(0);
$folder = array(
	'*',
	'*/*',
	'*/*/*',
	'*/*/*/*',
	'*/*/*/*'
);
foreach ($folder as $key => $value) {
	$asu[] = glob($value);
}
foreach ($asu as $key => $values) {
	foreach ($values as $key => $value) {
		if($value != "createjson.php" && $value != "ignore.php" && $value != "test.txt" ){
			if(is_dir($value)){
				$dir[]  =  $value;
			}else{
				$value  = array(
					'name' 		=> $value,
				);
				$file[] = $value; 
			}
		}
	}
}
$remove = array('');
$required = array(
	'dir' 		=> $dir,
	'file' 		=> $file,
	'remove' 	=> $remove,
);
$repo = array(
	'version'	=> 'http://ekasyahwan.github.io/version/desploits.json', 
	'files'		=> 'https://github.com/ekasyahwan/desploits',
);
$release = array(
	'version' => '1.0.0',
	'date' => date("d M Y")
);
echo json_encode(array(
	'repository'=> $repo, 
	'required' 	=> $required,
	'release'	=> $release,
	)
);