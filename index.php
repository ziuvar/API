<?php

require 'flight/Flight.php';

Flight::register('db', 'PDO', array('mysql:host=sql312.epizy.com;dbname=epiz_34330430_apiinstitucion', 'epiz_34330430_XXX', 'odsw68DwanuVY'));

//leer datos y mostrar
Flight::route('GET /aulas', function () {
    $sentencia = Flight::db()->prepare("SELECT * FROM `aulas`");
    $sentencia->execute();
    $datos = $sentencia->fetchAll();
    Flight::json($datos);
});

//Recepciona los datos por post e inserta
Flight::route('POST /aulas', function () {
    $Numero=(Flight::request()->data->Numero);
    $Bloque = (Flight::request()->data->Bloque);
    $Descripcion = (Flight::request()->data->Descripcion);

    $sql = "INSERT INTO aulas (Numero,Bloque,Descripcion) VALUES (?,?,?)";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$Numero);
    $sentencia->bindParam(2, $Bloque);
    $sentencia->bindParam(3, $Descripcion);
    $sentencia->execute();

    Flight::jsonp(["Aula agregada"]);

});

// Actualizar una aula por su Numero
Flight::route('PUT /aulas/@Numero', function ($Numero) {
    $data = Flight::request()->data;
    $Bloque = $data->Bloque;
    $Descripcion = $data->Descripcion;

    $sql = "UPDATE aulas SET Bloque = ?, Descripcion = ? WHERE Numero = ?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->execute([$Bloque, $Descripcion, $Numero]);

    Flight::jsonp(["Aula actualizada"]);
});

// Eliminar una aula por su Numero
Flight::route('DELETE /aulas/@Numero', function ($Numero) {
    $sql = "DELETE FROM aulas WHERE Numero = ?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->execute([$Numero]);

    Flight::jsonp(["Aula eliminada"]);
});

// Obtener una aula por su Numero
Flight::route('GET /aulas/@Numero', function ($Numero) {
    $sql = "SELECT * FROM aulas WHERE Numero = ?";
    $sentencia = Flight::db()->prepare($sql);
    $sentencia->execute([$Numero]);
    $datos = $sentencia->fetch();
    Flight::json($datos);
});
 
Flight::start();
