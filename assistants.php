<?php
include_once('presentation.class.php');
View::start('Asistentes');
View::navigation();
if(!View::checkIfEnterprise()){
    header('Location: index.php');
}

$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$res=$db->prepare('SELECT DISTINCT * FROM usuarios u INNER JOIN tickets t ON t.idcliente=u.id WHERE t.idactividad='.$_GET['id'].';');
$res->execute();
$res->setFetchMode(PDO::FETCH_NAMED);
$datos = $res->fetchAll();
?>

<div class="wrapper">
    <main class="container">
        <section>
        <h2>Lista de asistentes</h2>
        <?php
            if (count($datos)>0) {
                echo "<table class=\"content-table\">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>E-mail</th>
                        <th>Población</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                    </tr>
                </thead>
                <tbody>";
                foreach($datos as $registro){
                    echo "<tr>";
                    echo "<td>{$registro['nombre']}</td>";
                    echo "<td>{$registro['email']}</td>";
                    echo "<td>{$registro['poblacion']}</td>";
                    echo "<td>{$registro['direccion']}</td>";
                    echo "<td>{$registro['telefono']}</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
            }else {
                echo "<p>Todavía no se ha apuntado nadie</p>";
            }
        ?>
        </section>
    </main>
</div>

<?php
View::footer();
View::end();
?>