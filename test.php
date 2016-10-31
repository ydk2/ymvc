<!DOCTYPE html>
<html lang="pl">
  <head>
    <title>Intl Sample</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
 <?php
if(!defined('DS')) {
define('DS',DIRECTORY_SEPARATOR);

require_once dirname(__FILE__).DS.'system'.DS.'core'.DS.'Intl.php';
}

        echo "<h3>Simple</h3>\n"; 

$strings = array(
    'text' => 'tekst',
    'write' => 'zapisz',
    'read' => 'czytaj',
    'forget it' => 'zapomnij',
    'put' => 'włóż',
    'up' => 'góra',
    'down' => 'dół',
    'true' => 'prawda',
    'text to you'=>'tekst dla ciebie',
 );

        Intl::set_strings($strings); // can use with Intl::set_strings($strings,'string'); 

        echo '<p>'.Intl::_('text to you')."</p>\n"; // will return 'text dla ciebie'

        echo '<p>'.Intl::_('you')."</p>\n"; // will return 'you' because not exist or not translated
        
        Intl::set_strings($strings,'string'); // read up

        echo '<p>'.Intl::_('text to you','string')."</p>\n"; // will return 'text dla ciebie'

        echo '<p>'.Intl::_('you','string')."</p>\n"; // will return 'you' because not exist or not translated

        echo '<p>'.Intl::get_browser_lang()."</p>\n"; // without arguments return first supported browser language

        $array = array('en','ru','ar','en-us');

        echo '<p>'.Intl::get_browser_lang($array)."</p>\n"; // with arguments return first supported browser language existing in array

        Intl::$strings = NULL; // for next examples

        // Simple translate

        echo "<h3>Simple with loaders</h3>\n"; 

        Intl::set_path(dirname(__FILE__).DS.'system'.DS.'languages'.DS.'old'); // set search path with files
        $langs = Intl::available_locales(Intl::PHP); // return available files from dir, Intl::PHP[JSON,PO] const mode set
        Intl::set_default_lang('pl'); // set default lang
        var_dump(Intl::get_browser_lang($langs)); // return available lang default(if set else en if exists), first code found in $langs if exists (en > en-US/GB... > en_GB...)
        
       echo "<pre>\n";
        Intl::load_locale_simple(Intl::get_browser_lang($langs)); // Load simple translate file can be full path, set domain for store strings optional
        echo "</pre>\n";
        echo "<p>".Intl::_('text to you')."</p>\n"; // return translated string not work with plurals here
       echo "<p>".Intl::_('up')."</p>\n";
       echo "<p>".Intl::_('read')."</p>\n";
       // var_dump(Intl::$strings);
       // Plurals PO

        echo "<h3>Multiple auto PO</h3>\n"; 

        $langs = Intl::available_locales(Intl::PO);
        $lang = Intl::get_browser_lang($langs);
        //Intl::po_locale_plural(fullpath,'plurals');
        Intl::po_locale_plural($lang,'plurals'); // Load translate file can be full path this function have a plural support, set domain for store strings optional

        $searchone = "choice: "; // one
        $searchplural = "choices: "; // many

        $a = 0;
        while ($a <= 40) {
          echo "<p>".$a." ".Intl::_n($searchone,$searchplural,$a,'plurals')."</p>\n"; // return transladed string with given number of choises
          $a += 3;
        }

        $n = 30030; // number of choises

        echo "<p>".$n." ".Intl::_n($searchone,$searchplural,$n,'plurals')."</p>\n"; // return transladed string with given number of choises

        echo "<h3>Multiple custom PO</h3>\n"; 
       
        $plural = 1; // for manual logic , many langs is added like cz,sk,pl,csb,ar,en,gb,fr... but not all
        $nplurals = 3; // like up
        echo "<p> _n ".$n." ".Intl::_n($searchone,$searchplural,$n,'plurals',array($nplurals,$plural))."</p>\n"; // in this way you can use you own logic
        echo "<p>".$n." ".Intl::_p($searchplural,'plurals',$plural)."</p>\n"; // return transladed string with manually given plural number
        echo "<p>".$n." ".Intl::_p($searchplural,'plurals')."</p>\n"; // return transladed string but always from 0 plural entry
        
       echo "<p> 1. ".Intl::_p($searchone,'plurals')."</p>\n"; // // return transladed string, 1 is optional [Intl::_p($searchplural,'plurals',2) return [2] choises ]
        
        echo "<p>".Intl::_('text to you','plurals')."</p>\n"; // yeap now work 
        echo "<p>".$n." ".Intl::_($searchplural,'plurals',2)."</p>\n"; // yeap now work with plurals too but strings with them must be loaded
        // Plural with not po file? yes look in dump, you need that scheme in php or json file
        //Intl::tojson(dirname(__FILE__).DS.'system'.DS.'languages'.DS.'old'.DS.'pl.json',Intl::$strings['plurals']);
        //var_dump(Intl::$strings['plurals']);

        echo "<h3>Multiple auto JSON</h3>\n"; 

        $langs = Intl::available_locales(Intl::JSON);
        $lang = Intl::get_browser_lang($langs);
        //Intl::po_locale_plural(fullpath,'plurals');
        Intl::json_locale($lang,'json'); // Load translate file can be full path this function have a plural support, set domain for store strings optional

        $searchone = "choice: "; // one
        $searchplural = "choices: "; // many

        $a = 1;
        while ($a <= 40) {
          echo "<p>".$a." ".Intl::_n($searchone,$searchplural,$a,'json')."</p>\n"; // return transladed string with given number of choises
          $a += 3;
        }

        $n = 30030; // number of choises

        echo "<p>".$n." ".Intl::_n($searchone,$searchplural,$n,'json')."</p>\n"; // return transladed string with given number of choises

?> 
  </body>
</html>