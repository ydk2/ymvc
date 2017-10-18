<?php
/**
 * kodowanie pliku ini konfig users.
 */
class Encoding {
public static function str_split($str, $l = 0) {
    if ($l > 0) {
        $ret = array();
        $len = mb_strlen($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}
public static function encode($string,$key)
{
	$convert = self::strToHex($string);
    $encoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $convert, MCRYPT_MODE_CBC, md5(md5($key))));
	$converted = self::strToHex($encoded);
	return $converted;
}
public static function decode($coded,$key)
{
	$convert=self::hexToStr($coded);
    $decoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($convert), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	$converted = self::strToHex($decoded);
	return $converted;
}
public static function hexToStr($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
 
public static function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}
    public static function hexTobin($str) {
        $sbin = "";
        $len = strlen( $str );
        for ( $i = 0; $i < $len; $i += 2 ) {
            $sbin .= pack( "H*", substr( $str, $i, 2 ) );
        }

        return $sbin;
    }
} // koniec Kodowanie

?>