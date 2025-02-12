<?php
class DB{
    private static $connection=null;
    public static function get(){
        if(self::$connection === null){
            self::$connection = new PDO('sqlite:' . __DIR__ . '/datos.db');
            self::$connection->exec('PRAGMA foreign_keys = ON;');
            self::$connection->exec('PRAGMA encoding="UTF-8";');
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
    public static function execute_sql($sql,$parms=null){
        try {
            $db = self::get();
            $ints= $db->prepare ( $sql );
            if ($ints->execute($parms)) {
                return $ints;
            }
        }
        catch (PDOException $e) {
            // ¡Esto debería estar en presentation !
            echo '<h3>Error en al DB: ' . $e->getMessage() . '</h3>';
        }
        return false;
    }
    public static function user_exists($usuario,$pass, &$res){
        $db = self::get();
        $inst=$db->prepare('SELECT * FROM usuarios WHERE cuenta=? and clave=?');
        $inst->execute(array($usuario,md5($pass)));
        $inst->setFetchMode(PDO::FETCH_NAMED);
        $res=$inst->fetchAll();
        return count($res) == 1;
    }
    
    public static function getUserRole($name, $password) {
        $db = self::get();
        $res=$db->prepare('SELECT * FROM usuarios WHERE nombre=\''.$user.'\' AND clave=\''.md5($password).'\';');
        $res->execute();
        $res->setFetchMode(PDO::FETCH_NAMED);
        $datos = $res->fetchAll();
        return $datos;
    }
    
}
