<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-14 00:17:17
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-11-14 00:46:08
 */
class Md5Cracker extends DesploitsModules
{
	public function check($hash){
		$md5online = array(
			'https://hashdecryption.com/h/md5/' 		=> '/<\/b>is<b>(.*?)<\/b>/',
			'https://www.md5lab.com/md5/' 				=> '/<\/h3>ResolveToWord<textareaonfocus="this\.select\(\);">(.*?)<\/textarea>/',
			'http://hashtoolkit.com/decrypt-md5-hash/' 	=> '/<spantitle="decryptedmd5hash">(.*?)<\/span>/',
			'http://md5.gromweb.com/?md5=' 				=> '/<emclass="long-contentstring">(.*?)<\/em>/',
			'http://hashdatabase.info/crack?hash=' 		=> '/<td>plaintext<\/td><td><strong>(.*?)<\/strong>/',
			'http://md5.apps-code.org/decrypt/' 		=> '/<\/th><td>(.*?)<\/td>/',
			'http://md5decoder.org/' 					=> '/<p>Phrase:"(.*?)"hashedwithMD5is:<em>/',
			'https://md5db.net/view/' 					=> '/<th>Word<\/th><td><b>(.*?)<\/b>/'
		);
		foreach ($md5online as $url => $regex) {
			$check = preg_replace('/\s+/', '', $this->sdata($url.$hash , null , true)[data] );
			preg_match_all($regex, $check, $matches);
			if($matches[1][0]){
				echo "[MD5 Cracker] ".parse_url($url, PHP_URL_HOST)." | String : ".$matches[1][0]."\r\n";
				$report[] = $hash."|".$matches[1][0]."\r\n";
			}
		}
		if($report){
			$report = array_unique($report);
			$name   = $this->stuck("[MD5 Cracker] Scan done! save filename : ");
			foreach ($report as $key => $revalue) {
				$this->savehypertext($revalue,"report/".$name);
			}
			echo "[MD5 Cracker] fetched data logged to files under 'report/".$name."'\r\n";
		}
	}
	public function run(){
		$hash = $this->stuck("[MD5 Cracker] MD5 Hash: ");
		$this->check($hash);
	}
}