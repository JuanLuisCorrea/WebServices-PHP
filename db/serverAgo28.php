<?php
/*
 * generic_server.php
 */
include('../lib/nusoap.php');//se incluye la libreria nusoap
$server = new soap_server();// se crea el objeto servidor
$server->configureWSDL('Servidor', 'urn:Servidor');//se configura el nombre con el que voy a interactuar en el wsdl.
$server->register('Create',//1 Nombre del metodo que ofrece el servidor
    array('cadena' => 'xsd:String'),//2 Parametros necesarios para ejeutar el metodo en forma de array
    array('resultado' => 'xsd:int'),//3 Retorno del metodo
    'urn:Createwsdl',//4 descripcion formal metodo wsdl
    'urn:Createwsdl#Create',//5 como se llama el metodo al anterior servidor
    'rpc',//tipo de invocacion, la interaccion del cliente y el servidor
    'encoded',//como viaja la informacion
    'Retorna 1 si la creación en la base de datos es satisfactoria; 0 en caso contrario'//descripcion textual del servicio web que ofrece el servidor.
);

$server->register('Read',//1 Nombre del metodo que ofrece el servidor
    array('cadena' => 'xsd:String'),//2 Parametros necesarios para ejeutar el metodo en forma de array
    array('resultado' => 'xsd:String'),//3 Retorno del metodo
    'urn:Readwsdl',//4 descripcion formal metodo wsdl
    'urn:Readwsdl#Read',//5 como se llama el metodo al anterior servidor
    'rpc',//tipo de invocacion, la interaccion del cliente y el servidor
    'encoded',//como viaja la informacion
    'Retorna un conjunto de resultados si se cumple la condicón de la consulta'//descripcion textual del servicio web que ofrece el servidor.
);

$server->register('Update',//1 Nombre del metodo que ofrece el servidor
    array('cadena1' => 'xsd:String','cadena2' => 'xsd:String'),//2 Parametros necesarios para ejeutar el metodo en forma de array
    array('resultado' => 'xsd:int'),//3 Retorno del metodo
    'urn:Updatewsdl',//4 descripcion formal metodo wsdl
    'urn:Updatewsdl#Delete',//5 como se llama el metodo al anterior servidor
    'rpc',//tipo de invocacion, la interaccion del cliente y el servidor
    'encoded',//como viaja la informacion
    'Retorna 1 si se actualizó el registro de la base de datos; 0 en caso contrario'//descripcion textual del servicio web que ofrece el servidor.
);

$server->register('Delete',//1 Nombre del metodo que ofrece el servidor
    array('cadena' => 'xsd:String'),//2 Parametros necesarios para ejeutar el metodo en forma de array
    array('resultado' => 'xsd:int'),//3 Retorno del metodo
    'urn:Deletewsdl',//4 descripcion formal metodo wsdl
    'urn:Deletewsdl#Delete',//5 como se llama el metodo al anterior servidor
    'rpc',//tipo de invocacion, la interaccion del cliente y el servidor
    'encoded',//como viaja la informacion
    'Retorna 1 si se borró el registro de la base de datos; 0 en caso contrario'//descripcion textual del servicio web que ofrece el servidor.
);

//xsd definicion de esquema xml pero se utiliza dentro de wsdl para especificar los datos de los mensajes
function Create($cadena) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "data";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql="INSERT INTO data(datum) values('".$cadena."')";
    if($conn->query($sql)===TRUE){
        $conn->close();
        return 1;
	}
	else{
        $conn->close();
        return 0;
	}
}

function Read($cadena) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "data";
    $retorno ="";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql="SELECT * FROM data";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $retorno = $retorno.$row["id"]." ".$row["datum"]."\n";
        }
    }
    else{
       return "0 resultados";
    }
   $conn->close();
   return $retorno;   
}


function Update($cadena1,$cadena2) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "data";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql="UPDATE data SET datum = '".$cadena1."' WHERE id=".$cadena2;
       
    if($conn->query($sql)===TRUE){
        $conn->close();
        return 1;
	}
	else{
        $conn->close();
        return 0;
	}
}

function Delete($cadena) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "data";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql="DELETE FROM data WHERE ID ='$cadena'"; 
    if($conn->query($sql)===TRUE){
        $conn->close();
        return 1;
	}
	else{
        $conn->close();
        return 0;
	}
}

$rawPortData= file_get_contents("php://input");
$server->service($rawPortData);
?>