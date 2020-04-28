<?php
include_once('presentation.class.php');
View::start('Resultados');
View::navigation()
?>
<div class="wrapper">
    <main class="container">
        <section>
            <form action="search.php" method="post">
                <input type="text" name="search" placeholder="Busca actividades..."  onkeyup="searchForActivities(this.value)">
            </form>
            <div id="result">
                <h2>Resultados de la búsqueda</h2>
                <table id="content-table" class="content-table">
                    <thead>
                        <tr>
                            <th>Actividad</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody  id="activities-table">
                    </tbody>
                </table>
                <div id="not-found">
                    <p>No se han encontrado resultados para la búsqueda</p>
                    <p>Inténtelo de nuevo</p>
                </div>
            </div>
            <div id="no-result">
                Introduzca alguna actividad que desee buscar.
            </div>
        </section>
    </main>
</div>
<script src="scripts.js"></script>
<?php
View::footer();
View::end();
?>