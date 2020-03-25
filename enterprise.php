<?php
include_once 'presentation.class.php';
View::start('Empresa');
View::navigation();
$enterpriseid=$_GET['enterprise'];
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');

$res1=$db->prepare('SELECT * FROM empresas WHERE idempresa='.$enterpriseid.';');
$res1->execute();
$res1->setFetchMode(PDO::FETCH_NAMED);
$enterpriseData = $res1->fetchAll();

$res2=$db->prepare('SELECT * FROM actividades WHERE idempresa='.$enterpriseid.';');
$res2->execute();
$res2->setFetchMode(PDO::FETCH_NAMED);
$enterpriseActivities = $res2->fetchAll();
?>
<main class="container">
    <section>
        <?php
            echo "<h2>{$enterpriseData[0]['nombre']}</h2>";
            echo "<div class=\"shadow-container\">";
            echo "<p>{$enterpriseData[0]['descripcion']}</p>";
            echo "<p>Datos de contacto: {$enterpriseData[0]['contacto']}</p>";
            $imgb64 = View::imgtobase64($enterpriseData[0]['logo']);
            echo "<img src=\"{$imgb64}\">";
            echo"<h3>Listado de actividades organizadas por {$enterpriseData[0]['nombre']}</h3>";
        ?>
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
                    foreach($enterpriseActivities as $register){
                        $date = date("d-m-Y H:i", $register['inicio']);
                        echo "<tr>";
                        echo "<td><a href=\"detail.php?activity={$register['id']}\">{$register['nombre']}</a></td>";
                        echo "<td>{$register['tipo']}</td>";
                        echo "<td>{$date}</td>";
                        echo "<td>{$register['precio']} euros</td>";
                        echo "<td>{$register['descripcion']}</td>";
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
