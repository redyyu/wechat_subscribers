<?php
/**
 * WeChat Interface Crack
 *
 * This file is not part of the plugin
 * This file is for crack the "token not bind correct / system time out while bind token"
 * Most Problem is happening while get valid the token and url, this crack is for skip the progress.
 *
 * Please back up wordpress's index.php, rename __wechatsucks__.php to index.php and replace to wordpress's root folder.
 * Go valid form wechat official platform. After valid success, remove the fake index.php, and restore to the real one.
 * 
 * I can not guarantee this thing certain works, we can not guarantee that your data is not compromised. 
 * In short, there is no way to approach, so GOOD LUCK!
 */

if(isset($_GET["echostr"])){
	echo $_GET["echostr"];
}

exit;
?>