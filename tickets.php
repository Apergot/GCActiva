<?php
include_once('presentation.class.php');
View::start('Mis tickets');
View::navigation();
if(!View::checkIfClient()){
    header('Location: index.php');
}
if (isset($_SESSION['user'])) {
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    $res=$db->prepare('SELECT * FROM tickets WHERE idcliente='.$_SESSION['user']['id'].';');
    $res->execute();
    $res->setFetchMode(PDO::FETCH_NAMED);
    $datos = $res->fetchAll();
}
?>
<div class="wrapper">
    <main class="container">
        <section>
            <h2>Tickets adquiridos</h2>
            <?php
            if (count($datos) > 0) {
                echo "<table class=\"content-table\">
                <thead>
                    <tr>
                        <th>ID Ticket</th>
                        <th>Actividad</th>
                        <th>Precio</th>
                        <th>Nº tickets</th>
                    </tr>
                </thead>
                <tbody>";
                foreach($datos as $tickets){
                    $res1=$db->prepare('SELECT * FROM actividades WHERE id='.$tickets['idactividad'].';');
                    $res1->execute();
                    $res1->setFetchMode(PDO::FETCH_NAMED);
                    $datos1 = $res1->fetchAll();
                    echo "<tr>";
                    echo "<td>{$tickets['id']}</td>";
                    echo "<td><a href=\"detail.php?activity={$tickets['idactividad']}\">{$datos1[0]['nombre']}</a></td>";
                    echo "<td>{$tickets['precio']} euros</td>";
                    echo "<td>{$tickets['unidades']} tickets</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>"; 
            } else {
                echo "<p>Aún no has adquirido ningún ticket para actividades</p>";
            }
            ?>
            
        </section>
    </main>
</div>
<?php
View::footer();
View::end();
?>