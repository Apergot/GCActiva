<?php
include_once('presentation.class.php');
View::start('Gestionar');
View::navigation();
if(!View::checkIfEnterprise()){
    header('Location: index.php');
}
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');

if (isset($_SESSION['user'])) {
    $res=$db->prepare('SELECT * FROM actividades WHERE idempresa='.$_SESSION['user']['id'].';');
    $res->execute();
    $res->setFetchMode(PDO::FETCH_NAMED);
    $datos = $res->fetchAll();
}
?>
<div class="wrapper">
    <main class="container">
        <section class="crudflex">
            <h2>Actividades de mi empresa</h2>
            
            <?php
            if (count($datos) > 0) {
                echo "<table class=\"content-table\">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Precio</th>
                        <th>Apuntados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>";
                    if (isset($_POST['deleteActivity'])) {
                        $res=$db->prepare('DELETE FROM actividades WHERE id='.$_GET['id'].';');
                        $res->execute();
                        header('Location: activitycrud.php');
                    }
                    
                    foreach($datos as $registro){
                        $init = date("d-m-Y H:i", $registro['inicio']);
                        echo "<tr>";
                        echo "<td><a href=\"detail.php?activity={$registro['id']}\">{$registro['nombre']}</a></td>";
                        echo "<td>{$registro['tipo']}</td>";
                        echo "<td>{$init}</td>";
                        echo "<td>{$registro['precio']} euros</td>";
                        echo "<td><a href=\"assistants.php?id={$registro['id']}\">Asistentes</a></td>";
                        $actions =  "<td>
                                        <div class=\"action-buttons\">
                                            <a href=\"editactivity.php?id={$registro['id']}\"><button class=\"edit-button\">Editar</button></a>
                                            <form method=\"post\" action=\"activitycrud.php?id={$registro['id']}\">
                                                <button type=\"submit\" name=\"deleteActivity\" class=\"delete-button\">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>";
                        echo $actions;
                        echo "</tr>";
                    }
                   
                echo "</tbody></table>";
            } else {
                echo "No hay actividades que mostrar";
            }
            
            ?>
        </section>
        <div class="add-button-container">
            <a href="createactivity.php"><button class="add-button">Añadir actividad</button></a>
        </div>
    </main>
</div>
<?php
View::footer();
View::end();
?>