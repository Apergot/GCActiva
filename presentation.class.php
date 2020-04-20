<?php
include_once 'business.class.php';

class View{
    
    public static function  start($title){
        $html = "<!DOCTYPE html>
                <html>
                <head>
                <meta charset=\"utf-8\">
                <link rel=\"stylesheet\" type=\"text/css\" href=\"estilos.css\">
                <script src=\"scripts.js\"></script>
                <title>$title</title>
                <link rel=\"stylesheet\" href=\"estilo.css\" type=\"text/css\"/>
                </head>
                <body>";
        User::session_start();
        echo $html;
    }

    public static function imgtobase64($img){
        $b64 = base64_encode($img);
        $signature = substr($b64, 0, 3);
        if ( $signature == '/9j') {
            $mime = 'data:image/jpeg;base64,';
        } else if ( $signature == 'iVB') {
            $mime = 'data:image/png;base64,';
        }
        return $mime . $b64;
    }
    
    public static function checkIfEnterprise(){
        if(isset($_SESSION['user'])){
            if($_SESSION['user']['tipo'] == 2){
                return true;
            }
        }
        return false;
    }
    
    public static function checkIfClient() {
        if(isset($_SESSION['user'])){
            if($_SESSION['user']['tipo'] == 3){
                return true;
            }
        }
        return false;
    }

    public static function navigation(){
        if(isset($_POST['logOut'])) {
            unset($_SESSION['user']);;
            header('Location: index.php');
        }
        
        $logo = "<header>
                    <nav>
                        <div class=\"logo-container\">
                            <a href=\"index.php\" class=\"logo\"><span>G</span><span>C</span>Activa</a>
                        </div>";
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['tipo'] == 2) {
                $links = "<div class=\"links-container\">
                            <a href=\"index.php\">Inicio</a>
                            <a href=\"tabla.php\">Catálogo</a>
                            <a href=\"activitycrud.php\">Mis Actividades</a>
                        </div>";
            } elseif ($_SESSION['user']['tipo'] == 3) {
                $links = "<div class=\"links-container\">
                            <a href=\"index.php\">Inicio</a>
                            <a href=\"tabla.php\">Catálogo</a>
                            <a href=\"tickets.php\">Mis tickets</a>
                        </div>";
            }else {
                $links = "<div class=\"links-container\">
                        <a href=\"index.php\">Inicio</a>
                        <a href=\"tabla.php\">Catálogo</a>
                    </div>";   
            }
        } else {
            $links = "<div class=\"links-container\">
                    <a href=\"index.php\">Inicio</a>
                    <a href=\"tabla.php\">Catálogo</a>
                </div>";   
        }
                
        $search = "<form class=\"search-form\" action=\"search.php\" method=\"post\">
                        <input type=\"text\" name=\"search\" placeholder=\"Busca actividades...\">
                        <button type=\"submit\">Buscar</button>
                    </form>";
                    
        if (isset($_SESSION['user'])) {
             $buttons = "<div class =\"nav-buttons\">
                                <button disabled class=\"loggeduser\"><img src=\"./img/user.png\">{$_SESSION['user']['nombre']}</button>
                                <form method=\"post\">
                                    <button type=\"submit\" name=\"logOut\">Cerrar sesión</button>
                                </form>
                        </div>";  
        } else {
             $buttons = "<div class =\"nav-buttons\">
                            <a href=\"login.php\">
                                <button>Iniciar sesión</button>
                            </a>
                        </div>";   
        }
        $ending = "</nav></header>"; 
        echo $logo,$links,$search,$buttons,$ending;
    }
    
    public static function footer(){
        $footer = "<footer>
                        <p>&copy;2020 Grupo 01 P4</p>
                        <p>Contact information: <a class=\"mailto\" href=\"mailto:someone@example.com\">someone@example.com</a>.</p>
                        <p>Tlfno: 123456789</p>
                    </footer>";
        
        echo $footer;
    }

    public static function end(){
        echo '</body>
</html>';
    }
}
