<?php
include_once('presentation.class.php');
View::start('Resultados');
View::navigation();
$search = $_POST['search'];
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$res=$db->prepare('SELECT * FROM actividades WHERE (nombre=? OR tipo=? OR inicio=?);');
$res->execute(array($search, $search, strtotime($search)));
$res->setFetchMode(PDO::FETCH_NAMED);
$searchedActivities = $res->fetchAll();
?>
<div class="wrapper">
    <main class="container">
        <section>
            <?php
                if(count($searchedActivities) != 0) {
                ?>
                <h2>Resultados de la búsqueda</h2>
                <table class="content-table">
                <thead>
                    <tr>
                        <th>Actividad</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach($searchedActivities as $register){
                    $date = date("d-m-Y", $register['inicio']);
                    echo "<tr>";
                    echo "<td><a href=\"detail.php?activity={$register['id']}\">{$register['nombre']}</a></td>";
                    echo "<td>{$register['tipo']}</td>";
                    echo "<td>{$date}</td>";
                    echo "<td>{$register['precio']} euros</td>";
                    echo "</tr>";
                }
                ?>
                    </tbody>
                </table>
                <?php
                } else {
                    echo "<p>No se han encontrado resultados para la búsqueda</p>";
                    echo "<p>Inténtelo de nuevo</p>";
                }
                ?>
        </section>
    </main>
</div>

<?php
View::footer();
View::end();
?>