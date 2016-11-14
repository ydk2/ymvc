<?php
/**
* klasa pobierania pliku :)
*/
class download {
function __construct($plik=NULL)
{
	//$plik = ($plik==NULL)?$_GET['pobierz']:$plik;
	if (file_exists($plik)) {
	header('Pragma: public');
	header('Content-Description: File Transfer');
	header('Content-Type:'.mime_content_type($plik));
	header('Content-Disposition: attachment; filename='.basename($plik));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Content-Length: ' . filesize($plik));
	ob_clean();
	flush();
	readfile($plik);
	exit();
	}
}	
}

?>