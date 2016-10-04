<?php
class Modules
{
	public function msg($msg){
		echo "[desploits] ".$msg."\r\n";
	}
	public function ngesave($name,$data){
		$name = $name."-".date('dFY').".txt";
		$myfile = fopen($name, "a+") or die("Tidak bisa membuka file!");
        fwrite($myfile, $data);
        fclose($myfile);
        return $name;
	}
	public function ngeChuk($url){
		$this->msg("[check] uRL : ".$url);
		$ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_USERAGENT, "msnbot/1.0 (+http://search.msn.com/msnbot.htm)");
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                curl_setopt($ch, CURLOPT_COOKIEJAR,  getcwd().'temp/'."cookies.txt");
                curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'temp/'."cookies.txt");
                curl_setopt($ch, CURLOPT_COOKIESESSION, true);
                curl_setopt($ch, CURLOPT_VERBOSE, false);
                $data           = curl_exec($ch);    
                $header_size    = curl_getinfo($ch      , CURLINFO_HEADER_SIZE);
                $header         = substr($data          , 0, $header_size);
                $body           = substr($data          , $header_size);
                $ex             = explode("\r\n"        , $header); 
                $xx             = curl_getinfo($ch      , CURLINFO_EFFECTIVE_URL);
        if( $url != $xx){
        	$this->msg("[check] uRL : ".$xx." (new url)");
        }else{
			$this->msg("[check] uRL : ".$xx." (last url)");
        }
        return $xx;
	}
    public function ngecurl($url , $post=null , $header=null){
        $ch = curl_init($url);
        if($post != null) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; U; CPU iPhone OS 8_3_3 like Mac OS X; en-SG) AppleWebKit/537.25 (KHTML, like Gecko) Version/7.0 Mobile/8C3 Safari/6533.18.1");
        curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'temp/'."cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'temp/'."cookies.txt");
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        if($header != null) {
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        }
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        return curl_exec($ch);
        curl_close($ch);
    }
	public function mod_httpcode($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
		curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_TIMEOUT,10);
		$output = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
    	return $httpcode;
	}
	public function loadDB($package){
        switch ($package) {
            case 'asp':
                $db = "db/fadmin/fadmin-asp.txt";
            break;
            case 'brf':
                $db = "db/fadmin/fadmin-brf.txt";
            break;
            case 'cfm':
                $db = "db/fadmin/fadmin-cfm.txt";
            break;
            case 'cgi':
                $db = "db/fadmin/fadmin-cgi.txt";
            break;
            case 'js':
                $db = "db/fadmin/fadmin-js.txt";
            break;
            case 'php':
                $db = "db/fadmin/fadmin-php.txt";
            break;
            default:
                $this->msg("[WARNING] fadmin ".$package." wrong package, can not be loaded");
                exit();
            break;
        }
        if(!file_exists($db)){
            $this->msg("[WARNING] no files ".$db);
            exit();
        }
        $file = file_get_contents($db);
        $file = explode(",",$file);
        $file = array_unique($file);
        return $file;
    }
    public function loadFile($files){
        if(!file_exists($files)){
            $this->msg("[WARNING] no files ".$files);
            exit();
        }
        $file = file_get_contents($files);
        $file = explode("\r\n",$file);
        $file = array_unique($file);
        return $file;
    }
    public function removefromlist($files,$remove){ 
        // usage : list,key
        $this->msg("[Remove] key ".$remove." remove from ".$files);
        $file = file_get_contents($files);
        $file = explode("\r\n", $file);
        unset($file[$remove]);
        $imp=implode("\r\n",$file);
        $fp=fopen($files,'w');
        fwrite($fp,$imp);
        fclose($fp);
    }
    function Debug( $data ){
        $myfile = fopen("debug.html", "w+") or die("Unable to open file!");
        fwrite($myfile, $data);
        fclose($myfile);
    }
}