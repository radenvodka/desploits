<?php
/**
 * @Author: Desploits Developers
 * @Date:   2016-11-10 21:47:21
 * @Last Modified by:   Eka Syahwan
 * @Last Modified time: 2016-11-24 23:31:28
 */
require_once("tools/class.adminfinder.php");
require_once("tools/class.portscanner.php");
require_once("tools/class.md5cracker.php");
require_once("tools/class.shellfinder.php");
require_once("tools/class.dorking.php");
require_once("tools/class.bunglonshell.php");

$AdminFinder 	= new AdminFinder;
$Portscanner 	= new Portscanner;
$Md5Cracker 	= new Md5Cracker;
$Shellfinder 	= new Shellfinder;
$Dorking 		= new Dorking;
$Bunglonshell = new Bunglonshell;
