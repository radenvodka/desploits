<?php
class Fadmin extends Modules
{
	public function fcheck($url){
		$httpcode = $this->mod_httpcode($url);
		$this->msg("[Admin Check][".$httpcode."] ".$url);
		$okecode = array('302' , '200');
		foreach ($okecode as $key => $value) {
			if($httpcode == $value){
				$this->ngesave("result/fadmin",$url."\r\n");
				return $url;
			}
		}
	}
	public function single($url,$mode){
		$url 	= $this->ngeChuk($url);
		foreach ($this->loadDB($mode) as $key => $list) {
			$check = $this->fcheck($url.$list);
			if($check){
				$count[] = $check;
			}
		}
		$this->msg("[Admin Check][Total Detected] ".count($count));
		foreach ($count as $value) {
			$this->msg("[+] ".$value);
		}
	}
	public function mass($url,$mode){
		$file = $this->loadFile($url);
		foreach ($file as $key => $value) {
			$this->removefromlist($url,$key);
			$url 	= $this->ngeChuk($value);
			foreach ($this->loadDB($mode) as $key => $list) {
				$check = $this->fcheck($url.$list);
				if($check){
					$count[] = $check;
				}
			}
			$this->msg("[Admin Check][Total Detected] ".count($count));
			foreach ($count as $value) {
				$this->msg("[+] ".$value);
			}

		}
	}
}