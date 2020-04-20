<?php
include_once('presentation.class.php');
View::start('Crear');
View::navigation();
if(!View::checkIfEnterprise()){
    header('Location: index.php');
}

if (isset($_POST['doActivity'])) {
    $target_dir="uploads/";
    $target_file= $target_dir.basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $identerprise = $_SESSION['user']['id'];
    $name=$_POST['name'];
    $capacity=$_POST['capacity'];
    $price=$_POST['price'];
    $type=$_POST['type'];
    $date=$_POST['date'];
    $from=$_POST['from'];
    $to=$_POST['to'];
    $init = strtotime($date." ".$from);
    $duration = strtotime($to) -strtotime($from);
    $description=$_POST['description'];
    
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }
    
    if ($_FILES["fileToUpload"]["size"] > 100000) {
        $uploadOk = 0;
    }
    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
        error_log("User with {$_SESSION['user']['id']} tried to upload something which is not an image", 0);
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            error.log("Image uploaded correctly, image can be found at {$target_file}");
        } else {
            error.log("There was an error uploading an image");
        }
    }
    
    $db = new PDO("sqlite:./datos.db");
    $db->exec('PRAGMA foreign_keys = ON;');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'INSERT INTO actividades (idempresa, nombre, tipo, descripcion, precio, aforo, inicio, duracion, imagen) VALUES(?,?,?,?,?,?,?,?,?)';
    $res=$db->prepare($sql);
    $res->execute(array($identerprise, $name, $type, $description, $price, $capacity, $init, $duration, file_get_contents($target_file)));
   
    header('Location: activitycrud.php');
}
?>

<main class="container">
    <section>
        <h2>Crear actividad</h2>
        <div class="form-container create-edit-activity">
            <p>Una actividad debe tener como mínimo un nombre, un tipo, una descripción y un precio.
             Asegúrese de completar esos campos como mínimo.</p>
            <form method="post" accept-charset="utf-8" enctype="multipart/form-data">
                <div class="form-userdata">
                    <div>
                        <label for="name">Nombre:</label>
                        <input type="text" id="name" name="name" placeholder="Nombre de la actividad..." required/>
                    </div>
                    <div>
                        <label for="capacity">Aforo:</label>
                        <input type="number" id="capacity" min="0" name="capacity" placeholder="Número de participantes..."/>
                    </div>
                </div>
                <div class="form-usercontact">
                    <div>
                        <label for="price">Precio:</label>
                        <input type="number" id="price" name="price" step="0.01" min="0" placeholder="Precio por persona..." required/>
                    </div>
                    <div>
                        <label for="type">Tipo:</label>
                        <select id="type" name="type" required>
                            <option value="Musical">Musical</option>
                            <option value="Senderismo">Senderismo</option>
                            <option value="Espiritual">Espiritual</option>
                            <option value="Deportivo">Deportivo</option>
                            <option value="Riesgo">Riesgo</option>
                            <option value="Acuático">Acuático</option>
                        </select>
                    </div>
                </div>
                <div class="form-userdata">
                    <div>
                        <label for="date">Fecha:</label>
                        <input type="date" id="date" name="date"/>
                    </div>
                    <div>
                        <label for="time">Hora de inicio:</label>
                        <input type="time" id="from" name="from"/>
                    </div>
                    <div>
                        <label for="to">Hora de finalización:</label>
                        <input type="time" id="to" name="to"/>
                    </div>
                </div>
                <div class="textarea-container">
                    <label for="description">Descripción de la actividad:</label>
                    <textarea name="description" id="description" required rows="8" cols="40" placeholder="Escriba aquí una breve descripción de la actividad..."></textarea>
                </div>
                <div class="form-userdata">
                    <div>
                        <label for="fileToUpload">Imagen publicitaria para la actividad:</label>
                        <input type="file" id="fileToUpload" name="fileToUpload"/>
                    </div>
                </div>
                <div class="submit-btn">
                    <button type="submit" name="doActivity" class="std-button">Crear actividad</button>
                </div>
            </form>
        </div>
    </section>
</main>

<?php
View::footer();
View::end();
?>