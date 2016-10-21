<?php
class Engine extends Modules
{
	function softdelete($urlS,$opt){
		if($urlS != ""){
			if(is_array($urlS)){
				$urlS = array_unique($urlS);
				foreach ($urlS as $key => $url) {
					if( !$opt ){
						$url = parse_url($url);
						$url = (!isset($url["scheme"]) ? "http://".$urlS : $url["scheme"]."://".$url["host"]);
						$urlarray[] = $url;
					}else{
						$urlarray[] = $url;
					}				
				}
				foreach (array_unique($urlarray) as $key => $url) {
					$this->ngesave("result/scraper",$url."\r\n");
				}
			}else{
				$url = parse_url($urlS); $url = (!isset($url["scheme"]) ? "http://".$urlS : $url["scheme"]."://".$url["host"]);
				if( !$opt ){
					$url =  parse_url($url, PHP_URL_HOST);
					$this->ngesave("temp/scraper-",$url."\r\n");
				}else{
					$this->ngesave("temp/scraper-",$url."\r\n");
				}
			}
		}
	}
	function search($dork , $opt=null){
		$dork = urlencode($dork);
		# ixquick search engine
		$header_ixquick = array(
	    "content-type: application/x-www-form-urlencoded",
	    "origin: https://s6-us4.ixquick.com",
	    "referer: https://s6-us4.ixquick.com/do/search"
  		);
		for ($i=0; $i < 1000 ; $i+=10) { 
			$data = $this->ngecurl("https://s6-us4.ixquick.com/do/search","abp=1&cat=web&cmd=process_search&cpg=0&engine0=v1all&hmb=1&language=english&nj=0&qid=LELORQRMQSLQ735JTXHSU&query=".$dork."&rcount=1&rl=NONE&startat=".$i."&t=air",$header_ixquick);
			$re = '/<spanclass=\'url\'>(.*?)<\/span>/';
			preg_match_all($re, $this->removespace($data) , $matches);
			foreach ($matches[1] as $key => $url) {
				$link[] 	= $url;
				$insave[] 	= $url;
				$this->softdelete($url,$opt);
			}
			$this->msg("[Scraper] Scraper ixquick (Page: ".$i." | woot: ".count($matches[1])." | Total: ".count($link).")");
		}
		$this->msg("[Scraper] Scraper ixquick Total (remove duplicate) : ".count(array_unique($link)) );
		$this->softdelete($link,$opt);unset($link);
		# exactseek search engine
		for ($i=0; $i <1010; $i+=10) { 
			$data = $this->ngecurl("http://web1.exactseek.com/webclient/?query=".urlencode($dork)."&start=".$i);
			$re = '/<p><a class="title" href="(.*?)" rel="nofollow">/';
			preg_match_all($re, $data , $matches);
			foreach ($matches[1] as $key => $url) {
				$link[] 	= $url;
				$insave[] 	= $url;
				$this->softdelete($url,$opt);
			}
			$this->msg("[Scraper] Scraper exactseek (Page: ".$i." | woot: ".count($matches[1])." | Total: ".count($link).")");
		}
		$this->msg("[Scraper] Scraper exactseek Total (remove duplicate) : ".count(array_unique($link)) );
		$this->softdelete($link,$opt);unset($link);
		# dogpile search engine
		for ($i=0; $i <1010; $i+=10) { 
			$data = $this->ngecurl("http://www.dogpile.com/info.dogpl/search/web?qsi=".$i."&q=".$dork);
			$re = '/data-icl-cop="results-main" href="(.*?)" >/';
			preg_match_all($re, $data , $matches);
			foreach ($matches[1] as $key => $url) {
				$re = '/&du=(.*)&/';
				$url = urldecode(urldecode($url));
				preg_match_all($re, $url, $matches);
				$link[] 	= explode("&", $matches[1][0])[0];
				$insave[] 	= explode("&", $matches[1][0])[0];
				$this->softdelete(explode("&", $matches[1][0])[0],$opt);
			}
			$this->msg("[Scraper] Scraper dogpile (Page: ".$i." | woot: ".count($matches[1])." | Total: ".count($link).")");
		}
		$this->msg("[Scraper] Scraper dogpile Total (remove duplicate) : ".count(array_unique($link)) );
		$this->softdelete($link,$opt);unset($link);
		# bing search engine
		for ($i=0; $i <1010; $i+=10) { 
			$data = $this->ngecurl("http://www.bing.com/search?q=".$dork."&go=Submit&qs=n&sc=8-6&sp=-1&sk=&cvid=5FBDA739A23C42ADAA081DC9606BF316&first=".$i."&FORM=PERE2");
			$re = '/<li class="b_algo"><h2><a _ctf="rdr_T" href="(.*?)"/';
			preg_match_all($re, $data , $matches);
			foreach ($matches[1] as $key => $url) {
				$link[] 	= $url;
				$insave[] 	= $url;
				$this->softdelete($url,$opt);
			}
			$this->msg("[Scraper] Scraper bing (Page: ".$i." | woot: ".count($matches[1])." | Total: ".count($link).")");
		}
		$this->msg("[Scraper] Scraper bing Total (remove duplicate) : ".count(array_unique($link)) );
		$this->softdelete($link,$opt);unset($link);
		# yahoo search engine
		for ($i=0; $i <1010; $i+=10) { 
			$data = $this->ngecurl("https://id.search.yahoo.com/search?p=".$dork."&pz=10&b=".$i."&pz=10");
			$re = '/RU=(.*?)"/i';
			preg_match_all($re, $data , $matches);
			foreach ($matches[1] as $key => $value) {
				$re = '/(.*?)RK=0/i';
				preg_match_all($re, urldecode($value) , $matchesurl);
				if($matchesurl[1][0] != null){
					$link[] 	= $matchesurl[1][0];
					$insave[] 	= $matchesurl[1][0];
					$this->softdelete($url,$opt);
				}
			}
			$this->msg("[Scraper] Scraper yahoo (Page: ".$i." | woot: ".count($matches[1])." | Total: ".count($link).")");
		}
		$this->msg("[Scraper] Scraper yahoo Total (remove duplicate) : ".count(array_unique($link)) );
		$this->softdelete($link,$opt);unset($link);
		# ask search engine
		for ($i=0; $i <100; $i++) { 
				$data = $this->ngecurl("http://www.ask.com/web?q=".$dork."page=".$i."&qid=6D4D4A966F6C13292449DEE0BEF745E5&o=0&qo=pagination");
				$re = '/<a class="web-result-title-link" href="(.*?)"/i';
				preg_match_all($re, $data , $matches);
				foreach ($matches[1] as $key => $url) {
					$link[] 	= $url;
					$insave[] 	= $url;
					$this->softdelete($url,$opt);
				}
				$this->msg("[Scraper] Scraper ask (Page: ".$i." | woot: ".count($matches[1])." | Total: ".count($link).")");
		}
		$this->msg("[Scraper] Scraper ask Total (remove duplicate) : ".count(array_unique($link)) );
		$this->softdelete($link,$opt);unset($link);
		# aol search engine
		for ($i=0; $i <100; $i++) { 
				$header_aol = array(
					'Host:search.aol.com',
					'User-Agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 Safari/537.36'
					);
				$data =  $this->ngecurl("http://search.aol.com/aol/search?page=".$i."&v_t=sb-nrf&q=".$dork."&s_it=sb-nrf", null , $header_aol);
				$re = '/href="(.*?)" property="f:title"/i';
				preg_match_all($re, $data , $matches);
				print_r($matches);
				foreach ($matches[1] as $key => $url) {
					$link[] 	= $url;
					$insave[] 	= $url;
					$this->softdelete($url,$opt);
				}
				$this->msg("[Scraper] Scraper aol (Page: ".$i." | woot: ".count($matches[1])." | Total: ".count($link).")");
		}
		$this->msg("[Scraper] Scraper aol Total (remove duplicate) : ".count(array_unique($link)) );
		$this->softdelete($link,$opt);unset($link);
		# googleapis search engine
		for ($i=0; $i <1000; $i+=10) { 
				$data =  json_decode($this->ngecurl("https://www.googleapis.com/customsearch/v1element?key=AIzaSyCVAXiUzRYsML1Pv6RwSG1gunmMikTzQqY&rsz=large&num=8&hl=en&start=".$i."&cx=005531940451544459472:_wxzudlmale&q=".$dork),true);
				foreach ($data[results] as $key => $value) {
					$link[] 	= $value[unescapedUrl]."\r\n";
					$insave[] 	= $value[unescapedUrl]."\r\n";
				}
				$this->msg("[Scraper] Scraper googleapis (Page: ".$i." | woot: ".count($data[results])." | Total: ".count($link).")");
		}
		$this->msg("[Scraper] Scraper googleapis Total (remove duplicate) : ".count(array_unique($link)) );
		$this->softdelete($link,$opt);unset($link);
		#final save
		foreach ($insave as $key => $url) {
			if( !$opt ){
				$url = parse_url($url);
				$url = (!isset($url["scheme"]) ? "http://".$urlS : $url["scheme"]."://".$url["host"]);
				$urlarray[] = $url;
			}else{
				$urlarray[] = $url;
			}				
		}
		unlink("result/scraper-".date('dFY').".txt");
		$input = $this->readline("Name file final result : ");
		foreach (array_unique($urlarray) as $key => $url) {
			$this->save("result/".$input,$url."\r\n");
		}
	}
	function scraper($dork , $opt=null){
		if( file_exists($dork) ){
			$file = $this->loadFile($dork);
			$this->msg("[Scraper] Dork : ".$dork." (Total Dork : ".count($file).")");
			foreach ($file as $key => $dork) {
				$this->search($dork , $opt);
			}
		}else{
				$this->msg("[Scraper] Dork : ".$dork." (Single Dork)");
				$this->search($dork , $opt);
		}
	}
}



