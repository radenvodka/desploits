<?php
/**
 * @Author: Eka Syahwan
 * @Date:   2016-12-11 08:03:42
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-12-11 08:24:34
 */
class Exif extends DesploitsModules
{
	public function getData($file){
		$exif = exif_read_data($file, 0, true);
		foreach ($exif as $key => $section) {
			//print_r($section);
		    foreach ($section as $name => $val) {
		    	if($name != "UndefinedTag:0xEA1C" && $name != "UndefinedTag:0xEA1C"){
		        	echo "[Exif] $name: $val\r\n";
		    	}
		    }
		}
	}
	public function run(){
		$option = $this->stuck("[Exif Data] Location (jpg/png/*) : ");
		if(file_exists($option)){
			$this->getData($option);
		}else{
			echo "[Exif] File not found!\r\n";
			$this->run();
		}
	}
}