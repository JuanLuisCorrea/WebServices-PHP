<?php 

include('../../lib/nusoap.php');//incluir la libreria
$client = new nusoap_client('http://localhost/webservices/db/serverAgo28.php?wsdl','wsdl');//se crea el objeto cliente y le paso como parametros la 'url?wsdl','wsdl'
$err = $client->getError();//me permite determinar los errores que se generan.

$client->soap_defencoding = 'utf-8'; 
$client->encode_utf8 = false;
$client->decode_utf8 = false;

if ($err) {	echo 'Error en Constructor' . $err ; }

?>

<html>
    <head>
        <title>Actualizar registro</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
      <?php
        $id = $_GET["id"];
      ?>
      <form name="actualizar" method="POST">
        <label for="nuevaCad">
          Nueva cadena
          <input type="text" name="nuevaCad">
        </label>
        <input type="submit" name="actualizar">
      </form>

        <?php 
          if(isset($_POST["actualizar"])){
            $nuevaCad = $_POST["nuevaCad"];
  
            $param = array('cadena1' => $nuevaCad,'cadena2' => $id);//parametros de lo que defino en la funcion del metodo de generic_server.php
            $result = $client->call('Update', $param);//me permite mostrar el resultado del metodo y sus parametros
            if ($client->fault) {
              echo 'fault';
              print_r($result);
            } else {	// Chequea errores
              $err = $client->getError();
              if ($err) {		// Muestra el error
                echo 'Error' . $err ;
              } else {		// Muestra el resultado
                echo 'Actualización del registro';
                print_r ($result);
              }
            }
          }
        ?>

        <center>
          <a href="../index.html">Menú</a>
          <br>
          <a href="listar.php">Listar</a>
        </center>    
    </body>
</html>