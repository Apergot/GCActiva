<?php
include_once('presentation.class.php');
include_once('business.class.php');
View::start('Login');
View::navigation();
$error = "";
if(isset($_POST['name']) && isset($_POST['password'])){
    if(trim($_POST['name']) != "" && trim($_POST['password']) != "") {
        if (User::login($_POST['name'], $_POST['password'])) {
            $error="";
            header('Location: index.php');   
        } else {
            $error = "Inténtelo de nuevo";
        }
    } else {
        $error = "Inténtelo de nuevo";
    }
}

?>

<div class="wrapper">
    <main class="container">
        <section>
            <h2>Inicio de sesión</h2>
            <form class="form-container" action="login.php" method="post">
                <?php
                if ($error != "") {
                    echo "<p class=\"error\">{$error}</p>";
                }
                ?>
                <div class="form-userdata">
                    <div>
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" placeholder="Nombre de usuario"/>
                    </div>
                </div>
                <div class="form-userdata">
                    <div>
                        <label for="name">Contraseña:</label>
                        <input type="password" id="password" name="password" placeholder="Contraseña"/>
                    </div>
                </div>
                <div class="submit-btn">
                    <input type="submit" value="Iniciar sesión" />
                </div>
            </form>
        </section>        
    </main>
</div>

<?php
View::footer();
View::end();
?>
