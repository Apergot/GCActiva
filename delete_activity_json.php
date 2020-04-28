<?php
$res = new stdClass();
$res->deleted=false; //Formato objeto con propiedad deleted (por defecto a false)
$res->message=''; //Mensaje en caso de error
try{
    $datoscrudos = file_get_contents("php://input"); //Leemos los datos
    $datos = json_decode($datoscrudos);
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;'); //Activa la integridad referencial para esta conexión
    $sql=$db->prepare('delete FROM actividades WHERE id=?;'); 
    if($sql){
        $sql->execute(array($datos->id));
        if($sql->rowCount()>0){ //Numero de filas/registros afectadas
           $res->deleted=true; //Devolvemos que ha sido borrado
        }
    }
}catch(Exception $e){
   $res->message=$e->getMessage(); //En caso de error se envia la información de error al navegador
}
header('Content-type: application/json');
echo json_encode($res);
