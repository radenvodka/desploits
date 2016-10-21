<?php
class Md5 extends Modules
{
	function checkMD5($key,$i){
		switch ($i) {
			case '1':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("https://hashdecryption.com/h/md5/".$key));
				$re = '/<\/b>is<b>(.*?)<\/b>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			case '2':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("https://www.md5lab.com/md5/".$key));
				$re = '/<\/h3>ResolveToWord<textareaonfocus="this\.select\(\);">(.*?)<\/textarea>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			case '3':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("http://hashtoolkit.com/decrypt-md5-hash/".$key));
				$re = '/<spantitle="decryptedmd5hash">(.*?)<\/span>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			case '4':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("http://md5.gromweb.com/?md5=".$key));
				$re = '/<emclass="long-contentstring">(.*?)<\/em>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			case '5':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("http://hashdatabase.info/crack?hash=".$key));
				$re = '/<td>plaintext<\/td><td><strong>(.*?)<\/strong>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			case '6':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("http://md5.apps-code.org/decrypt/".$key));
				$re = '/<\/th><td>(.*?)<\/td>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][1];
				}
			break;
			case '7':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("http://md5decoder.org/".$key));
				$re = '/<p>Phrase:"(.*?)"hashedwithMD5is:<em>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			case '8':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("https://md5db.net/view/".$key));
				$re = '/<th>Word<\/th><td><b>(.*?)<\/b>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			case '9':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("http://md5.my-addr.com/md5_decrypt-md5_cracker_online/md5_decoder_tool.php","md5=".$key."&x=29&y=8"));
				$re = '/Hashedstring<\/span>:(.*?)<\/div>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			case '10':
				$str =  preg_replace('/\s+/', '', $this->ngecurl("http://md5decryption.com/","hash=".$key."&submit=Decrypt+It%21"));
				$re = '/DecryptedText:<\/b>(.*?)<\/font>/';
				preg_match_all($re, $str, $matches);
				if($matches[1][0]){
					$md5key = $matches[1][0];
				}
			break;
			default:
				$this->msg("[MD5 Enc/Dec] no options switch");
				exit();
			break;
		}
		if($md5key != ""){
			return $md5key;
		}else{
			return false;
		}
	}
	function isValidMd5($md5=''){
    	return preg_match('/^[a-f0-9]{32}$/', $md5);
    }
	function md5dec($key){
		if($this->isValidMd5($key)){ // single
			$this->msg("[MD5 Enc/Dec] MD5 Hash : ".$key);
			$this->msg("[MD5 Enc/Dec] Pleas wait... ");
			for($i=1;$i<11;$i++){
				$result = $this->checkMD5($key,$i);
				if($result != ""){
					$this->msg("[MD5 Enc/Dec] MD5 Hash : ".$key." | MD5 Key : ".$result." (serv.".$i.")");
					$md5key[] = "[MD5 Enc/Dec] MD5 Hash : ".$key." | Key : ".$result;
				}
			}
		}else if(file_exists($key)){
			$file = $this->loadFile($key);
			$hit  = count($file); 
			$this->msg("[MD5 Enc/Dec] File Load : ".$key." | Total : ".count($file));
			foreach ($file as $value) {
				$this->msg("[MD5 Enc/Dec][".$hit."] MD5 Hash : ".trim($value)." | Checking ...");
				if( $this->isValidMd5(trim($value)) ){
					for($i=1;$i<11;$i++){
						$result = $this->checkMD5(trim($value),$i);
						if($result != ""){
							$this->msg("[MD5 Enc/Dec][".$hit."] MD5 Hash : ".trim($value)." | Key : ".$result);
							$md5key[] = "[MD5 Enc/Dec] MD5 Hash : ".trim($value)." | Key : ".$result;
						}else{
							$this->msg("[MD5 Enc/Dec][".$hit."] MD5 Hash : ".trim($value)." | Key : - Null -");
						}
					}
				}else{
					$this->msg("[MD5 Enc/Dec][".$hit."] MD5 Hash : ".trim($value)." is not md5");
				}
				$hit = ($hit-1);
			}
		}else{
				$this->msg("[MD5 Enc/Dec] MD5 Key : ".trim($key)." | MD5 Hash : ".md5($key));
		}
		if($md5key != null){
			foreach (array_unique($md5key) as $key => $DataMD5) {
			 	$this->ngesave("result/md5dec",$DataMD5."\r\n");
			}
			$this->msg("[MD5 Enc/Dec][!] check all result in directory 'result'");
		}
	}
}