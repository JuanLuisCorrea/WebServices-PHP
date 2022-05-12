<?php

//Crear tabla dinámica
echo "<html>\n";
echo "\t<head>\n";
echo "\t\t<title>Listar Datos</title>\n";
echo "\t\t<meta http-equiv= \"refresh\" content=\"5\" />\n";
echo "\t\t<meta charset=\"UTF-8\"/>\n";
echo "\t</head>\n";
echo "\t<body>\n";

include('../../lib/nusoap.php');//incluir la libreria
$client = new nusoap_client('http://localhost/webservices/db/serverAgo28.php?wsdl','wsdl');//se crea el objeto cliente y le paso como parametros la 'url?wsdl','wsdl'
$err = $client->getError();//me permite determinar los errores que se generan.

$client->soap_defencoding = 'utf-8'; 
$client->encode_utf8 = false;
$client->decode_utf8 = false;

if ($err) {	echo 'Error en Constructor' . $err ; }

/*********************
 * INVOCACIÓN WS READ
 *********************/
$param = array('cadena' => 'FTW');//parametros de lo que defino en la funcion del metodo de generic_server.php
$result = $client->call('Read', $param);//me permite mostrar el resultado del metodo y sus parametros
$datos = explode("\n", $result);//Array con los registros
if ($client->fault) {
	echo 'fault';
	print_r($result);
} else {	// Chequea errores
	$err = $client->getError();
	if ($err) {		// Muestra el error
		echo 'Error' . $err ;
	} else {		// Muestra el resultado
		echo "<div align=\"center\">\n";
		echo "<table border=2>\n";
		echo "<tr>\n";
		echo "<td>ID</td>\n";
  	echo "<td>Registro</td>\n";
		echo "<td colspan=\"2\">Acción</td>\n";
		echo "</tr>\n";
		foreach($datos as $row) {
			$col = explode(" ", $row);
			echo "<tr>\n";
			echo "<td>".$col[0]."</td>\n";
			echo "<td>".$col[1]."</td>\n";
			echo "<td> <a href=\"update.php?id=".$col[0]."\">Update</td>\n";
			echo "<td> <a href=\"delete.php?id=".$col[0]."\">Delete</td>\n";
			echo "</tr>\n";
			error_reporting(0);
		}
		
		echo "</table>\n";
  	echo "</div>\n";
	}
}
/**************************
 * FIN INVOCACIÓN WS UPDATE
 **************************/
echo "<center><a href=\"../index.html\">Menú</a></center>\n";
echo "</body>\n";
echo "</html>\n";
?>