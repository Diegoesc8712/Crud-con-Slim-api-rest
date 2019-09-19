<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

//Get todos los clientes
$app->get('/api/clientes', function(Request $request, Response $response){
    $consulta = "SELECT * FROM clientes;";

    try{
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $clientes = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($clientes);

    } catch (PDOException $e) {
      
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

//Get cliente por id
$app->get('/api/cliente/{id}', function(Request $request, Response $response){
    $idCliente = $request->getAttribute('id');
    echo $idCliente;
    $consulta = "SELECT * FROM clientes WHERE id = $idCliente;";

    try{
        $db = new db();
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $clientes = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($clientes);

    } catch (PDOException $e) {
      
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

//crear nuevo cliente
$app->post('/api/clientes/nuevo', function(Request $request, Response $response){
    $nombre = $request->getParam('nombre');
    $apellido = $request->getParam('apellido');
    $telefono = $request->getParam('telefono');
    $email = $request->getParam('email');
    $direccion = $request->getParam('direccion');
    $ciudad = $request->getParam('ciudad');

    
    $consulta = "INSERT INTO clientes (nombre, apellido, telefono, email, direccion, ciudad) VALUES 
    (:nombre, :apellido, :telefono, :email, :direccion, :ciudad)";

    try{
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($consulta);

        $resultado->bindParam(':nombre', $nombre ); 
        $resultado->bindParam(':apellido', $apellido ); 
        $resultado->bindParam(':telefono', $telefono ); 
        $resultado->bindParam(':email', $email ); 
        $resultado->bindParam(':direccion', $direccion ); 
        $resultado->bindParam(':ciudad', $ciudad ); 
        
        $resultado->execute();
        echo json_encode("Nuevo cliente guardado");
        $resultado = null;
        $db = null;

    } catch (PDOException $e) {
      
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});



//modificar cliente cliente
$app->put('/api/clientes/modificar/{id}', function(Request $request, Response $response){
    $idcliente = $request->getAttribute('id');
    $nombre = $request->getParam('nombre');
    $apellido = $request->getParam('apellido');
    $telefono = $request->getParam('telefono');
    $email = $request->getParam('email');
    $direccion = $request->getParam('direccion');
    $ciudad = $request->getParam('ciudad');

    
    $consulta = "UPDATE clientes SET
       nombre = :nombre,
       apellido = :apellido,
       telefono = :telefono, 
       email = :email, 
       direccion = :direccion, 
       ciudad = :ciudad
       WHERE id = $idcliente";

    try{
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($consulta);

        $resultado->bindParam(':nombre', $nombre ); 
        $resultado->bindParam(':apellido', $apellido ); 
        $resultado->bindParam(':telefono', $telefono ); 
        $resultado->bindParam(':email', $email ); 
        $resultado->bindParam(':direccion', $direccion ); 
        $resultado->bindParam(':ciudad', $ciudad ); 
        
        $resultado->execute();
        echo json_encode("cliente modificado");
        $resultado = null;
        $db = null;

    } catch (PDOException $e) {
      
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

//eliminar cliente cliente
$app->delete('/api/clientes/eliminar/{id}', function(Request $request, Response $response){
    $idcliente = $request->getAttribute('id');

       $consulta = "DELETE FROM clientes
       WHERE id = $idcliente";

    try{
        $db = new db();
        $db = $db->conectar();
        $resultado = $db->prepare($consulta);
        $resultado->execute();

        if($resultado->rowCount() > 0){
            echo json_encode("cliente eliminado");
        }else{
            echo json_encode("no existe cliente con este ID");
        }

        $resultado = null;
        $db = null;

    } catch (PDOException $e) {
      
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

?>