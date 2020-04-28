<?php
$res = new stdClass();
$res ->result=false;
$res->message='';
try{
    $datoscrudos = file_get_contents("php://input");
    $datos = json_decode($datoscrudos);
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    $sql=$db->prepare('SELECT * FROM actividades WHERE (nombre=? OR tipo=? OR inicio=?);'); 
    if($sql){
        $sql->execute(array($datos->currentSearch, $datos->currentSearch, $datos->currentSearch));
        $sql->setFetchMode(PDO::FETCH_NAMED);
        $result = $sql->fetchAll();
        #echo print_r($result);
        if (count($result) != 0) {
            for ($i = 0; $i <count($result); $i++) {
                $result[$i]['imagen'] = 0;
            }
            $res->result=$result;
            $res->length=count($result);
        } else {
            $res -> result = "No se han encontrado resultados"; 
        }
        
    }
}catch(Exception $e){
   $res->message=$e->getMessage();
}
header('Content-type: application/json; charset=utf-8');
echo json_encode($res);
