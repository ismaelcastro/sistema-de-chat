<?php
define("DIR",'../uploads/');
$arquivo=($_GET['arquivo']);
if(file_exists(DIR.$arquivo)){

	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename="'.basename(DIR.$arquivo).'";');
	header('Content-Type: application/octet-stream');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize(DIR.$arquivo));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Expires: 0');
	readfile(DIR.$arquivo);


}
exit;


?>