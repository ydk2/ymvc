<?php
/**
 * kodowanie piliku ini konfig users.
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
	//$convert = base64_encode(self::strToHex(str_replace(array("\n","="), array("@%".$key."%@","*&".$key."^%"), $string)));
	$convert = self::strToHex(self::strToHex($string));
	$convert = str_replace(array(0), array(self::strToHex($key)), $convert);
	return $convert;
}
public static function decode($coded,$key)
{
	$convert=self::hexToStr(self::hexToStr($coded));
	$convert = str_replace(array(self::strToHex($key)), array(0), $convert);
	//$convert=str_replace(array("@%".$key."%@","*&".$key."^%"), array("\n","="), self::hexToStr(base64_decode($coded)));
	return $convert;
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
<?php
$string = "test string 0";
$hex  = Encoding::encode($string,"hq68");
$bin = Encoding::decode($hex,"hq68");


echo htmlentities($hex)."\n";
echo "\n";
echo $bin."\n";
echo "\n";
//echo htmlentities(Encoding::decode(file_get_contents("./testcode")))."\n";

echo "\n";

?>