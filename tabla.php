<?php
include_once 'presentation.class.php';
View::start('Actividades');
View::navigation();
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$res=$db->prepare('SELECT * FROM actividades;');
$res->execute();
$res->setFetchMode(PDO::FETCH_NAMED);
$datos = $res->fetchAll();
?>
<main class="container">
    <section>
    <h2>Catálogo de actividades</h2>
    <table class="content-table">
        <thead>
            <tr>
                <th>Actividad</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Precio</th>
                <th>Descripción sucinta</th>
            </tr>
        </thead>
        <tbody>
           <?php
            foreach($datos as $registro){
                $init = date("d-m-Y H:i", $registro['inicio']);
                echo "<tr>";
                echo "<td><a href=\"detail.php?activity={$registro['id']}\">{$registro['nombre']}</a></td>";
                echo "<td>{$registro['tipo']}</td>";
                echo "<td>{$init}</td>";
                echo "<td>{$registro['precio']} euros</td>";
                echo "<td>{$registro['descripcion']}</td>";
                echo "</tr>";
            }
           ?>
        </tbody>
    </table>
    </section>
</main>
<?php 
View::footer();
View::end();
?>