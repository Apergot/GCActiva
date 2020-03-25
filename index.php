<?php
include_once 'presentation.class.php';
View::start('GCActiva');
View::navigation();
$db = new PDO("sqlite:./datos.db");
$db->exec('PRAGMA foreign_keys = ON;');
$res=$db->prepare('SELECT * FROM actividades;');
$res->execute();
$res->setFetchMode(PDO::FETCH_NAMED);
$datos = $res->fetchAll();
?>

<section class="banner">
            <div class="banner-content">
                <h1>Descubre Gran Canaria</h1>
                <p>Junto a nosotros</p>
            </div>
        </section>
        <main>
            <section class="container">
                <h2>Confía en nosotros</h2>
                <div class="paragraph">
                    <p>Portal web para la venta de tickets de actividades a realizar
                    en la isla de Gran Canaria. Por un lado ofrece actividades atractivas
                    a los visitantes y por otro ofrece un medio de ofrecer en internet sus
                    servicios a los empresarios del sector en la isla. Los productos incluyen
                    , entradas a espectáculos, parques temáticos, tours guiados, senderismo, 
                    actividades gratuitas, etc.</p>
                </div>
            </section>
            <section class="container">
                <div class="activities-cards-display">
                    <?php
                    for ($i = 0; $i < 3; $i++) {
                        echo "<div class=\"activity-card\">";
                        echo "<a href=\"detail.php?activity={$datos[$i]['id']}\" class=\"link-card\">";
                        echo "<div class=\"activity-card-img\">";
                        $imgb64 = View::imgtobase64($datos[$i]['imagen']);
                        echo "<img src=\"{$imgb64}\">";
                        echo "<h1 class=\"card-title\">{$datos[$i]['nombre']}</h1>";
                        echo "</div>";
                        echo "<div class=\"activity-card-text\">";
                        echo "<p>{$datos[$i]['descripcion']}</p>";
                        echo "</div></a></div>";
                    }
                    ?> 
                </div>
            </section>
            <section class="parallaxprep">
                <div class="container">
                    <h2 class="bgdis">Catálogo de actividades</h2>
                    <div class="paragraph">
                        <p class="bgdis">Disponemos un amplio catálogo de actividades, ¡Encuentra 
                        aquella que mejor se ajuste a ti y a tu disponibilidad!</p>
                    </div>
                    <div class="center-button">
                        <a href="tabla.php"><button>Catálogo</button></a>
                    </div>
                </div>
            </section>
        </main>

<?php
View::footer();
View::end();
?>
