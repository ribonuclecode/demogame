<?php

include("config.php");

$folder = "games/";
$folder_mod = "mod/";
$referencia = $folder."game0.php";
$referencia_mod = $folder_mod."game0_mod.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = htmlspecialchars($_POST["value"]);
    $name_juego = trim($value);
    $id_mapa = $_POST["mapa"];
    $value = str_replace(" ", "_", $name_juego);
    $value_path = $folder.$value.".php";
    $value_path_mod = $folder_mod.$value."_mod.php";

    $conn = new mysqli($server, $db_user, $db_pass, $database);
   
    if ($conn->connect_error) {
        http_response_code(405);
        die("" . $conn->connect_error);
    }

   
    $stmt = $conn->prepare("INSERT INTO Juegos (NOMBRE, ID_MAPA) VALUES (?, ?)");
    $stmt->bind_param("si", $name_juego, $id_mapa);

    if($stmt->execute()){
        if (file_exists($value_path) || file_exists($value_path_mod)){
            http_response_code(406);
        }elseif (!copy($referencia, $value_path) || !copy($referencia_mod, $value_path_mod)) {
            http_response_code(405);
        } else {
            echo $value_path."|".$value_path_mod;
        }
    }
    else {
        http_response_code(405);
    }

    $stmt->close();
    $conn->close();

}
?>