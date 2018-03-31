<?php
$server="localhost";

$database = "mijuegop_gamesDB";

$db_user = "mijuegop";

$db_pass = "greRiRnxIrZ7QOxMIA74";



$insert_pregunta_simple = "INSERT INTO `PreguntaSimple`(`ID_PREGUNTA` ,`PREGUNTA`, `RESP_AFF`, `RESP_NEG`) VALUES (?,?,?,?)";
$insert_pregunta_multiple = "INSERT INTO `PreguntaMultiple`(`ID_PREGUNTA` , `PREGUNTA`, `VALID_PREGUNTA`, `MSG_WARNING`) VALUES (?,?,?,?)";
$insert_pregunta_relleno = "INSERT INTO `PreguntaRellenar`(`ID_PREGUNTA` , `PREGUNTA`, `RESP_AFF`) VALUES (?,?,?)";

$insert_pregunta = "INSERT INTO `Preguntas`(`TITULO`, `URL`, `EFECTO`, `EFECT_TEXT`, `N_QUESTION`, `TYPE_QUESTION`) VALUES (?,?,?,?,?,?)";

$insert_juego_pregunta = "INSERT INTO `JuegosPreguntas`( `ID_JUEGO`, `ID_PREGUNTA`) VALUES (?,?)";


$update_pregunta = "UPDATE `Preguntas` SET `TITULO`=?,`EFECTO`=?,`EFECT_TEXT`=?,`TYPE_QUESTION`=? WHERE `ID`=?";

$delete_pregunta_simple = "DELETE FROM `PreguntaSimple` WHERE `ID_PREGUNTA`=?";
$delete_pregunta_rellenar = "DELETE FROM `PreguntaRellenar` WHERE `ID_PREGUNTA`=?";
$delete_pregunta_multiple = "DELETE FROM `PreguntaMultiple` WHERE `ID_PREGUNTA`=?";



$select_preguntas_simples = "SELECT p.ID,`TITULO`,`URL`,`EFECTO`,`EFECT_TEXT`,`N_QUESTION`,`TYPE_QUESTION`,`PREGUNTA`,`RESP_AFF`,`RESP_NEG` FROM `Preguntas` as p,`PreguntaSimple` as ps,`JuegosPreguntas` as jp , `Juegos`  as j WHERE p.ID = jp.ID_PREGUNTA AND jp.ID_JUEGO = j.ID AND  p.ID = ps.ID_PREGUNTA AND p.ID = %s AND j.ID = %s";
$select_preguntas_multiples = "SELECT p.ID, `TITULO`, `URL`, `EFECTO`, `EFECT_TEXT`, `N_QUESTION`, `TYPE_QUESTION`,`PREGUNTA`, `VALID_PREGUNTA`, `MSG_WARNING` FROM `Preguntas` as p, `PreguntaMultiple` as pm,`JuegosPreguntas` as jp, `Juegos`  as j WHERE p.ID = jp.ID_PREGUNTA AND jp.ID_JUEGO = j.ID AND   p.ID = pm.ID_PREGUNTA AND p.ID = %s AND j.ID = %s";
$select_preguntas_rellenar = "SELECT p.ID, `TITULO`, `URL`, `EFECTO`, `EFECT_TEXT`, `N_QUESTION`, `TYPE_QUESTION`,`PREGUNTA`, `RESP_AFF` FROM `Preguntas` as p, `PreguntaRellenar` as pr,`JuegosPreguntas` as jp, `Juegos`  as j WHERE p.ID = jp.ID_PREGUNTA AND jp.ID_JUEGO = j.ID AND  p.ID = pr.ID_PREGUNTA AND p.ID = %s AND j.ID = %s";

$select_preguntas = "SELECT p.N_QUESTION, p.ID, p.TYPE_QUESTION FROM `Preguntas` as p,`JuegosPreguntas` as jp , `Juegos`  as j WHERE p.ID = jp.ID_PREGUNTA AND jp.ID_JUEGO = j.ID AND j.NOMBRE = '%s'";

$select_preguntas_simples_with_id = "SELECT `ID_PREGUNTA` as `ID`,`TITULO`,`URL`,`EFECTO`,`EFECT_TEXT`,`N_QUESTION`,`TYPE_QUESTION`,`PREGUNTA`,`RESP_AFF`,`RESP_NEG` FROM `Preguntas` as p,`PreguntaSimple` as ps WHERE p.ID = ps.ID_PREGUNTA AND ps.ID_PREGUNTA = %s";
$select_preguntas_multiples_with_id = "SELECT `ID_PREGUNTA` as `ID`, `TITULO`, `URL`, `EFECTO`, `EFECT_TEXT`, `N_QUESTION`, `TYPE_QUESTION`,`PREGUNTA`, `VALID_PREGUNTA`, `MSG_WARNING` FROM `Preguntas` as p, `PreguntaMultiple` as pm WHERE p.ID = pm.ID_PREGUNTA AND pm.ID_PREGUNTA = %s";
$select_preguntas_rellenar_with_id = "SELECT `ID_PREGUNTA` as `ID`, `TITULO`, `URL`, `EFECTO`, `EFECT_TEXT`, `N_QUESTION`, `TYPE_QUESTION`,`PREGUNTA`, `RESP_AFF` FROM `Preguntas` as p, `PreguntaRellenar` as pr WHERE p.ID = pr.ID_PREGUNTA AND pr.ID_PREGUNTA = %s";


?>