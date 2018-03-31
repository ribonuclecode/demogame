<?php

include("config.php");

$continue = true;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli($server, $db_user, $db_pass, $database);

    if ($conn->connect_error) {
        die("" . $conn->connect_error);
    }

   
    $url =   $_POST["url"];
    $sql = "SELECT id FROM `Juegos` WHERE `NOMBRE` = \"".$url."\"";
    $result = $conn->query($sql);

   
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ID_JUEGO  = $row["id"];
        }
    } else {
        $continue = false;
    }

    
    if (!$conn->set_charset("utf8")) {
        $continue = false;
    }

    if(array_key_exists("ID", $_POST)){
       
        $id_pregunta = $_POST["ID"];
        $UPDATE = true;
       
    } else {
        $UPDATE = false;
    }



   
    $last_type = $_POST["last_type"];
    switch ($last_type){
        case "Simple":
            $stmt = $conn->prepare($delete_pregunta_simple);
            $stmt->bind_param("i",$id_pregunta);
            break;
        case "Rellenar":
            $stmt = $conn->prepare($delete_pregunta_rellenar);
            $stmt->bind_param("i",$id_pregunta);
            break;
        case "Opción Múltiple":
            $stmt = $conn->prepare($delete_pregunta_multiple);
            $stmt->bind_param("i",$id_pregunta);
            break;
        default:
            http_response_code(400);
            break;
    }


    if(!$stmt->execute()){
        http_response_code(400);
        $conn->rollback();
        die(" ||| ".$stmt->error);
    }

    if($UPDATE){
        $stmt = $conn->prepare($update_pregunta);
        $stmt->bind_param("ssssi", $title,  $efecto, $efecto_texto, $type_question, $id_pregunta);
    } else {
        $stmt = $conn->prepare($insert_pregunta);
        $stmt->bind_param("ssisis", $title, $url, $efecto, $efecto_texto, $n_question, $type_question);
    }

    $type_question =$_POST["type-question"];
    $n_question =   $_POST["n_question"];
    $title =        $_POST['title']["value"];
    $efecto =       $_POST['efecto']["value"];
    $efecto_texto = $_POST['efecto']["text"];

    if($continue && $stmt->execute()){

        if(is_null($id_pregunta)){
            $id_pregunta = $stmt->insert_id;
        }

        $stmt = NULL;

        switch ($type_question){
            case "Simple":
                $pregunta =     $_POST["pregunta"]["value"];
                $button_aff =   $_POST["resp-aff"]["value"];
                $button_neg =   $_POST["resp-neg"]["value"];

                $stmt = $conn->prepare($insert_pregunta_simple);
                $stmt->bind_param("isss",$id_pregunta,$pregunta, $button_aff, $button_neg);
                break;
            case "Rellenar":
                $pregunta =     $_POST["pregunta-rellenar"]["value"];
                $button_aff =   $_POST["confirmacion-rellenar"]["value"];

                $stmt = $conn->prepare($insert_pregunta_relleno);
                $stmt->bind_param("iss",$id_pregunta,$pregunta, $button_aff);
                break;
            case "Opción Múltiple":
                $pregunta = "";
                $valid_pregunta = "";
               
                $n = count($_POST["check-resp-multiple"]);
                for($i = 0; $i < $n ; $i ++){
                    $sep = ($i >= $n - 1)? "" : " || ";
                    $valid_pregunta .= $_POST["check-resp-multiple"][$i]["value"].$sep;
                }

                $n = count($_POST["pregunta-multiple"]);
                for($i = 0; $i < $n ; $i ++){
                    $sep = ($i >= $n - 1)? "" : " || ";
                    $pregunta.=$_POST["pregunta-multiple"][$i]["value"].$sep;
                }

                $msg_warning = $_POST["warning-msg"]["value"];
               

                $stmt = $conn->prepare($insert_pregunta_multiple);
                $stmt->bind_param("isss",$id_pregunta,$pregunta, $valid_pregunta, $msg_warning);
                break;

            default:
               
                break;
        }

        if($stmt !== NULL && $stmt->execute()){
            $stmt = NULL;
            if(!$UPDATE){
                $stmt = $conn->prepare($insert_juego_pregunta);
                $stmt->bind_param("ii",$ID_JUEGO, $id_pregunta);
            }

            if($UPDATE || $stmt->execute()){

                $stmt = NULL;
                $select = "";

                switch ($type_question){
                    case "Simple":
                        $stmt = $conn->query(sprintf($select_preguntas_simples, $id_pregunta, $ID_JUEGO));
                        $select = $select_preguntas_simples;
                        break;
                    case "Rellenar":
                        $stmt = $conn->query(sprintf($select_preguntas_rellenar, $id_pregunta, $ID_JUEGO));
                        $select = $select_preguntas_rellenar;
                        break;
                    case "Opción Múltiple":
                        $stmt = $conn->query(sprintf($select_preguntas_multiples, $id_pregunta, $ID_JUEGO));
                        $select = $select_preguntas_multiples;
                        break;
                }


                if ($stmt !== NULL &&  $stmt->num_rows > 0) {
                    $i = 0;
                    $rawdata = array();
                    while($row = $stmt->fetch_assoc()) {
                        $rawdata[$i] = $row;
                        $i++;
                    }
                   
                    echo json_encode($rawdata);
                } elseif ($stmt === NULL){
                    http_response_code(400);
                    $conn->rollback();
                } elseif ($stmt->num_rows == 0){
                   
                    http_response_code(400);
                    $conn->rollback();
                }
                else {
                    http_response_code(400);
                    $conn->rollback();
                    echo " ||| ".$stmt->error;
                }
            } else {
                http_response_code(400);
                $conn->rollback();
                echo " ||| ".$stmt->error;
            }
        }
        elseif($stmt == NULL) {
            http_response_code(400);
            $conn->rollback();
        }
        else {
            http_response_code(400);
            $conn->rollback();
        }
    }
    elseif(!$continue) {
        http_response_code(400);
        $conn->rollback();
    }
    else {
        http_response_code(400);
        $conn->rollback();
        echo " ||| ".$stmt->error;
    }
    $conn->close();
}
?>