<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap.php');
?>
<?php
Helper::Inc(CORE.'router');
Helper::Inc(CORE.'render');
Config::Init();

Config::$data['default']['database']['type'] = 'sqlite';
Config::$data['default']['cpu_limit'] = 15;
//$model = new stdClass;
//$views = new CoreRender;
$loader = new Loader;

//echo htmlspecialchars_decode( Router::sys_routed($array,$disabled)->asXml());
echo $loader->showsys('layout','layout');

//$model = new stdClass;
//$views = new Core();
//$next = $views->Controller(SYS.C.'view');
//$start = $loader->Controller(SYS.C.'index');

//$next->show();
//$start->show();
//var_dump($next);
//var_dump($start);
?>
<?php
//Encryption:
$textToEncrypt = "My Text to Encrypt";
$encryptionMethod = "AES-256-CBC";
$secretHash = "encryptionhash";
$iv = mcrypt_create_iv(16, MCRYPT_RAND);
$encryptedText = openssl_encrypt($textToEncrypt,$encryptionMethod,$secretHash, 0, $iv);

//Decryption:
$decryptedText = openssl_decrypt($encryptedText, $encryptionMethod, $secretHash, 0, $iv);
//print "My Decrypted Text: ". $decryptedText;
?>