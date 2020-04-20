<?php
include_once 'presentation.class.php';
View::start('Actividad');
View::navigation();
$activity_id = $_GET['activity'];
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$res=$db->prepare('SELECT * FROM actividades WHERE id='.$activity_id.';');
$res->execute();
$res->setFetchMode(PDO::FETCH_NAMED);
$datos = $res->fetchAll();
?>
<main class="container">
            <section>
                <?php
                    $init = date("d-m-Y H:i", $datos[0]['inicio']);
                    $duration;
                    if (round($datos[0]['duracion']/3600, 1, PHP_ROUND_HALF_DOWN) >= 1) {
                        $duration = round($datos[0]['duracion']/3600, 1, PHP_ROUND_HALF_DOWN)." horas";
                    } else {
                        $duration = ($datos[0]['duracion']/60)." minutos";
                    }
                    
                    echo "<h2>{$datos[0]['nombre']}</h2>";
                    echo "<div class=\"shadow-container\">";
                    echo "<dl class=\"activity-detail\">";
                    echo "<div class=\"activity-detail-nodesc\">";
                    echo "<div class=\"activity-detail-desc\">";
                    echo "<dt>Tipo de actividad:</dt>";
                    echo "<dd>{$datos[0]['tipo']}</dd>";
                    echo "<dt>Precio de inscripción:</dt>";
                    echo "<dd>{$datos[0]['precio']}</dd>";
                    echo "<dt>Aforo máximo permitido:</dt>";
                    echo "<dd>{$datos[0]['aforo']}</dd>";
                    echo "<dt>Fecha y hora de inicio:</dt>";
                    echo "<dd>{$init}</dd>";
                    echo "<dt>Duración de la actividad:</dt>";
                    echo "<dd>{$duration}</dd>";
                    echo "</div>";
                    $imgb64 = View::imgtobase64($datos[0]['imagen']);
                    echo "<div class=\"activity-img\">
                                <dt><img src=\"{$imgb64}\" alt=\"activityIMG\"></dt>
                            </div>";
                    echo "</div>";
                    echo "<div class=\"activity-description\">";
                    echo "<dt>Descripción detallada</dt>";
                    echo "<dd>{$datos[0]['descripcion']}</dd>";
                    echo "</div></dl>"; 
                     echo "<div class=\"activity-operations\">";
 
                    if (isset($_POST['buyTicket'])) {
                        $db = new PDO("sqlite:./datos.db");
                        $db->exec('PRAGMA foreign_keys = ON;');
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $client_id = $_SESSION['user']['id'];
                        $activity_price = $datos[0]['precio']*$_POST['numberOfTickets'];
                        $tickets_number = $_POST['numberOfTickets'];
                        $sql = 'INSERT INTO tickets (idcliente, idactividad, precio, unidades) VALUES(?,?,?,?)';
                        $res=$db->prepare($sql);
                        $res->execute(array($client_id, $activity_id, $activity_price, $tickets_number));
                    }
                    
                    if (isset($_SESSION['user'])) {
                        if ($_SESSION['user']['tipo'] == 3) {
                            echo "<form method=\"post\">";
                            echo "<select class=\"detail-select\" name=\"numberOfTickets\">";
                            for ($i = 1; $i <= 10; $i++) {
                                 echo "<option value=\"{$i}\">{$i}</option>";
                            }
                            echo "</select>";
                            echo "<input type=\"submit\" name=\"buyTicket\" value=\"Comprar tickets\"/>";
                            echo "</form>";
                        }
                    }
                     echo "<a href=\"enterprise.php?enterprise={$datos[0]['idempresa']}\"><button class=\"std-button\">Empresa organizadora</button></a>";
                    echo "</div>";
                ?>
            </section>
        </main>
<?php
View::footer();
View::end();
?>
























