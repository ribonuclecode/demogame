<!DOCTYPE html>

<html>
<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="apple-mobile-web-app-capable"
          content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style"
          content="black-translucent"/>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">

    <script src="../js/jquery.ui.touch-punch.min.js"></script>
    <title>Juego</title>


    <link rel="stylesheet" type="text/css" href="../stylesheets/mystyle.css" />

    <style type="text/css">

        canvas {
            -webkit-box-shadow: 4px 6px 14px 3px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 4px 6px 14px 3px rgba(0, 0, 0, 0.75);
            box-shadow: 4px 6px 14px 3px rgba(0, 0, 0, 0.75);
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 100;
            margin: auto !important;
            overflow: hidden;
            image-rendering: optimizeSpeed;
            -ms-interpolation-mode: nearest-neighbor;
            -webkit-optimize-contrast;
            -webkit-touch-callout: none;
        }

    </style>

</head>
<body>
<script src="https://pixijs.download/dev/pixi.min.js"></script>
<script src="http://pixijs.io/pixi-sound/dist/pixi-sound.js"></script>

<script type="text/javascript">

    <?php
    include("../config.php");


    $conn = new mysqli($server, $db_user, $db_pass, $database);


    if ($conn->connect_error) {
        die("error:" . $conn->connect_error);
    }

    if (!$conn->set_charset("utf8")) {
        die("error: ". $conn->error);
    } 
    
    $result = $conn->query(sprintf($select_preguntas, basename(__FILE__, '.php') ));

    $preguntas = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

            $query  = NULL;
            switch ($row["TYPE_QUESTION"]){
                case "Simple":
                    $query = $select_preguntas_simples_with_id;
                    break;
                case "Opción Múltiple":
                    $query =$select_preguntas_multiples_with_id;
                    break;
                case "Rellenar":
                    $query = $select_preguntas_rellenar_with_id;
                    break;
                default:
                    break;
            }

            if(is_null($query)){
                die("error\n");
            } else {
                $result2 = $conn->query(sprintf($query, $row["ID"]));
                if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) {
                        $preguntas[intval($row["N_QUESTION"])] = $row2;
                    }
                }
                else {
                    die("error\n");
                }
            }
        }
    }

    function efectToAnimation($n_efecto){
        switch ($n_efecto){
            case 0:

            default:

                return "calldfMoveSprite";
                break;
        }
    }

    function dataFuncQuestions($preguntas, $position){
        $r = "";

        if(!empty($preguntas) && array_key_exists($position, $preguntas)){
            $pregunta = $preguntas[$position];
            switch ($pregunta["TYPE_QUESTION"]){
                case "Simple":
                    $template_simple = ",fn: fnPregunta(\"%s\", %s, \"%s\", \"%s\", %s, %s)";
                    $r = sprintf($template_simple, $pregunta["TITULO"],
                        efectToAnimation($pregunta["EFECTO"]),
                        $pregunta["RESP_AFF"],
                        $pregunta["RESP_NEG"],
                        "{effect: 'blind', duration: 500}",
                        "{effect: 'blind', duration: 500}");
                    break;
                case "Rellenar":
                    $template_rellenar = ",fn: fnPregunta(\"%s\", %s, \"%s\", %s, %s)";
                    $r = sprintf($template_rellenar, $pregunta["TITULO"],
                        efectToAnimation($pregunta["EFECTO"]),
                        $pregunta["RESP_AFF"],
                        "{effect: 'blind', duration: 500}",
                        "{effect: 'blind', duration: 500}");
                    break;
                case "Opción Múltiple":
                    $template_multiple = ",fn: fnPregunta(\"%s\", %s, \"%s\", %s, %s)";
                    $r = sprintf($template_multiple, $pregunta["TITULO"],
                        efectToAnimation($pregunta["EFECTO"]),
                        $pregunta["MSG_WARNING"],
                        "{effect: 'blind', duration: 500}",
                        "{effect: 'blind', duration: 500}");
                    break;
            }
        }
        return $r;
    }


    $pos = 0;
    ?>



    var punto_actual = 0;

    var out_range_x = false, out_range_y = false;



    var last_offset_x = 0; var last_offset_y = 0;




    var puntos = [
        {x: 179, y: 447 <?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 290, y: 350 <?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 400, y: 430 <?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 416,y:325 <?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 495,y:262<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 539,y:363<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 622,y:405<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 678,y:349<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 664,y:262<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 609,y:188<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 666,y:108<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 758,y:146<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 777,y:254<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 743,y:349<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 740,y:456<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 833,y:487<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 898,y:429<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 879,y:342<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 944,y:320<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 998,y:434<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 1059,y:379<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 1060,y:308<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 1143,y:300<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 1047,y:255<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 1109,y:216<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 1179,y:198<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>},
        {x: 1218,y:64<?php echo dataFuncQuestions($preguntas,$pos); $pos++; ?>}
    ];



    var functions = [];
    functions[String(moveSprite)] = false;


    function hasFunction(fn){
        return functions[String(fn)]
    }

    function jqueryProp(id, property, value){


        var set = false;
        if(typeof value !== "undefined"){
            set = true;
        }
        if (jQuery.fn.jquery < "1.9"){
            if(set){
                $(id).attr(property, value);
            } else {
                return $(id).attr(property);
            }

        } else {
            if(set){
                $(id).prop(property, value);
            } else {
                return $(id).prop(property);
            }
        }
    }



    function fnPregunta(){

        var mQ = [
            {cls: "multiple_unica", fn: fnPreguntaMultipleRespuestaUnica},
            {cls: "multiple_multiple", fn: fnPreguntaMultipleRespuestaMultiple},
            {cls: "rellenar", fn: fnPreguntaRellenarHueco},
            {cls: "simple", fn: fnPreguntaSimple}
        ];
        var _arguments = arguments;
        return function(){
            var ID = "pr" + (punto_actual);
            var clases = $("#" + ID).attr("class");
            for(var i = 0; i < mQ.length; i++){
                var el = mQ[i];
                if (clases.indexOf(el.cls) !== -1){
                    return el.fn.apply(this, _arguments)();
                }
            }

            return fnPreguntaPorDefecto.apply(this, _arguments)();

        }
    }

    function fnPreguntaMultipleRespuestaMultiple(title, callback){

        callback = typeof callback !== "undefined" ? callback: calldfMoveSprite;
        var check = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "<strong>¡Error!</strong> Prueba de nuevo";
        var show_set = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : {effect: "blind", duration: 500};
        var hide_set = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : {effect: "blind", duration: 500};
        var exit = arguments.length > 6 && arguments[6] !== undefined ? arguments[6] : "Salir";

        return function() {
            var ID = "pr" + (punto_actual);

            $("#" + ID).dialog({
                show: show_set,
                hide: hide_set,
                create: function(){
                    _warningMessage(ID, this, check)();
                    $(this).closest(".ui-dialog").draggable();
                    $(this).closest(".ui-dialog").on("change", _checkAnswers(ID, this, callback, checkRespuestasMultiple ,hide_set.duration));
                },
                resizable: false,
                modal: false,
                title: title,
                height: "auto",
                width: 400
            });
        }
    }

    function fnPreguntaMultipleRespuestaUnica(title, callback){

        callback = typeof callback !== "undefined" ? callback: calldfMoveSprite;
        var check = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "<strong>¡Error!</strong> Prueba de nuevo";
        var exit = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : "Salir";
        var show_set = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : {effect: "blind", duration: 500};
        var hide_set = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : {effect: "blind", duration: 500};

        return function() {
            var ID = "pr" + (punto_actual);

            $("#" + ID).dialog({
                show: show_set,
                hide: hide_set,
                resizable: false,
                modal: false,
                title: title,
                height: "auto",
                width: 400,
                create: function(){
                    _warningMessage(ID, this, check)();
                    $(this).closest(".ui-dialog").draggable();
                    $(this).closest(".ui-dialog").on("change", _checkAnswers(ID, this, callback,checkRespuestaUnica ,hide_set.duration));
                }
            });
        }
    }

    function fnPreguntaRellenarHueco(title, callback) {

        callback = typeof callback !== "undefined" ? callback: calldfMoveSprite;
        var correcto = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "Salir";
        var show_set = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : {effect: "blind", duration: 500};
        var hide_set = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : {effect: "blind", duration: 500};


        return function() {
            var ID = "pr" + (punto_actual);
            $("#" + ID).dialog({
                show: show_set,
                hide: hide_set,
                resizable: false,
                modal: true,
                title: title,
                height: "auto",
                width: 400,
                buttons: [
                    {
                        text: correcto,
                        click: function(){
                            $(this).dialog('close');
                            setTimeout(callback() ,hide_set.duration + 5);
                        }
                    }
                ],
                create: function(){
                    $(this).closest(".ui-dialog").draggable();

                    $(this).closest(".ui-dialog-content").find("input").each(function(){

                        var name = $(this).attr("name");
                        $(this).attr("style", "font-family: 'Open Sans', sans-serif;padding: 0px;text-align: center;");
                        $(this).attr("size", name.length);
                        $(this).attr("maxlength", name.length);



                        $(this).on("keyup",function(){

                            if($(this).attr("name") === $(this).val()){
                                $(this).css("background-color","green");
                                $(this).css("color","white");
                                jqueryProp(this, "readonly", true);
                            } else if (!jqueryProp(this, "readonly")){

                                $(this).css("background-color","red");
                                $(this).css("color","white");
                            }
                        });
                    });
                    $(this).closest(".ui-dialog-content").next().hide();
                    $(this).closest(".ui-dialog-content").on("keyup", _checkRespuestaHuecos(ID, this, checkHuecosRellenos));
                }
            });
        }
    }

    function fnPreguntaPorDefecto(title, callback) {


        callback = typeof callback !== "undefined" ? callback: calldfMoveSprite;
        var resp_af = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "Si";
        var resp_neg = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : "No";
        var show_set = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : {effect: "blind", duration: 500};
        var hide_set = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : {effect: "blind", duration: 500};

        return function() {
            var ID = "pr_";
            $("#" + ID).dialog({
                show: show_set,
                hide: hide_set,
                resizable: false,
                modal: true,
                title: title,
                height: "auto",
                width: 400,
                create: function(){
                    $(this).closest(".ui-dialog").draggable();
                },
                buttons: [
                    {
                        text: resp_af,
                        click: function(){
                            $(this).dialog('close');
                            setTimeout(callback() ,hide_set.duration + 5);
                        }
                    },
                    {
                        text: resp_neg,
                        click: function(){
                            $(this).dialog('close');
                        }
                    }
                ]
            });
        }
    }

    function fnPreguntaSimple(title, callback) {

        callback = typeof callback !== "undefined" ? callback: calldfMoveSprite;
        var resp_af = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "Si";
        var resp_neg = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : "No";
        var show_set = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : {effect: "blind", duration: 500};
        var hide_set = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : {effect: "blind", duration: 500};

        return function() {
            var ID = "pr" + (punto_actual);
            $("#" + ID).dialog({
                show: show_set,
                hide: hide_set,
                resizable: false,
                modal: true,
                title: title,
                height: "auto",
                width: 400,
                create: function(){
                    $(this).closest(".ui-dialog").draggable();
                },
                buttons: [
                    {
                        text: resp_af,
                        click: function(){
                            $(this).dialog('close');
                            setTimeout(callback() ,hide_set.duration + 5);
                        }
                    },
                    {
                        text: resp_neg,
                        click: function(){
                            $(this).dialog('close');
                        }
                    }
                ]
            });
        }
    }



    function checkRespuestasMultiple(id) {


        return $( id+" input:not(:checked)[value='*']" ).length === 0 && $(id + " input:checked[value='*']").length === $(id + " input:checked").length
    }

    function checkRespuestaUnica(id) {

        return $( id+" input:checked[value='*']" ).length === 1;
    }

    function checkHuecosRellenos(id){

        var r = true;
        $(id).closest(".ui-dialog-content").find("input").each(function(){
            if($(this).attr("name") !== $(this).val()){
                r = false;
                return false;
            }
        });
        return r;
    }




    function _warningMessage(ID, obj, text){

        return function() {
            var html_code = "<div class=\"ui-widget\">\n" +
                "\t<div id=\"error" + ID + "\"" + " class=\"ui-state-highlight ui-corner-all\" style=\"margin-top: 20px; padding: 0.7em; display: none\">\n" +
                "\t\t<p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>\n" +
                "\t\t" +  text +"</p>\n" +
                "\t</div>\n" +
                "</div>";
            $(obj).closest(".ui-dialog").append(html_code);
        }
    }



    function _checkRespuestaHuecos(ID, obj, checkfn) {

        return function(){
            var b = checkfn("#" + ID);
            if(b){
                $(obj).closest(".ui-dialog-content").next().show("slow");
            }
        }
    }

    function _checkAnswers(ID, obj, callback, checkfn, duration){

        return function() {
            var b = checkfn("#" + ID);
            if(b){
                $(obj).dialog('close');
                setTimeout(callback() ,duration + 5);
            } else {
                $("#error" + ID).show();
            }
        }
    }



    function calldfMoveSprite(){
        return function(){

            if(punto_actual < puntos.length -1){
                punto_actual +=1;
                anim.isMoving = true;
                ticker.add2(moveSprite(background, anim));
            }
        }
    }



    var background_heigth = 543, background_width = 1339;


    var h, w;

    if (PIXI.utils.isMobile.any) {
        w = 600;
        h = 300;
    } else {
        w = 800;
        h = 600;
    }



    h = Math.floor(window.innerHeight*0.9);
    w = Math.floor(window.innerWidth*0.9);

    w = w > background_width ? background_width : w;
    h = h > background_heigth ? background_heigth : h;


    var app = new PIXI.Application(w, h, {antialias: true, preserveDrawingBuffer: true, transparent: true});
    PIXI.settings.SCALE_MODE = PIXI.SCALE_MODES.NEAREST;


    PIXI.loader
        .add('../animation/bird.json')
        .load(onAssetsLoaded);

    PIXI.sound.add('musica', {
        url: '../audio/musica.mp3',
        preload: true,
        volume: 0.8,
        loaded: function() {
            PIXI.sound.play("musica", {loop: true});
        }
    });

    PIXI.sound.add('bird', {
        url: '../audio/bird.mp3',
        preload: true,
        volume: 0.5,
        loaded: function() {
            if (typeof anim !== "undefined" && anim.isMoving){
                PIXI.sound.play("bird", {loop: true});
            }
        }
    });

    var anim;

    function onAssetsLoaded() {
        var frames = [];

        for (var i = 0; i < 8; i++) {
            frames.push(PIXI.Texture.fromFrame('bird0' + i + '.png'));
        }


        anim = new PIXI.extras.AnimatedSprite(frames);


        anim.x = puntos[punto_actual].x;
        anim.y = puntos[punto_actual].y;
        if(app.view.height < background_heigth){
            anim.y = anim.y + (offsetBackground_y)
        }
        anim.anchor.set(0.5);
        anim.animationSpeed = 0.4/2;
        anim._isMoving = false;
        Object.defineProperty(anim, "isMoving", {
            get: function() {
                return anim._isMoving;
            },
            set: function(boolean) {
                anim._isMoving = boolean;
                anim.interactive = !anim._isMoving;
                anim.animationSpeed = anim._isMoving?  anim.animationSpeed * 2: anim.animationSpeed / 2;
                if (PIXI.sound.exists("bird")){
                    anim._isMoving? PIXI.sound.play("bird", {loop: true}): PIXI.sound.stop("bird");
                }
            }
        });


        anim.scale.x = -0.5;
        anim.scale.y = 0.5;
        anim.play();

        anim.interactive = true;
        anim.buttonMode = true;

        anim.on('pointerdown', gameLogic);

        app.stage.addChild(anim);
    }


    document.body.appendChild(app.view);

    var background = new PIXI.Sprite.fromImage('../images/mapa.jpeg');



    app.stage.addChild(background);

    var offsetBackground_y = 0, offsetBackground_x = 0;





    if (app.view.height < background_heigth && app.view.height < puntos[punto_actual].y){
        offsetBackground_y = app.view.height-background_heigth;
        background.y = offsetBackground_y;
    }



    function gameLogic(event) {
        if (typeof puntos[punto_actual].fn !== "undefined"){
            puntos[punto_actual].fn()
        }else{
            fnPreguntaPorDefecto("¿Avanzamos?")();
        }
    }

    var ticker = app.ticker;



    ticker.add2 = function (fn, context) {
        var priority = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : PIXI.UPDATE_PRIORITY.NORMAL;

        if(!hasFunction(fn)){
            functions[String(fn)] = true;
            return this.add(fn, context, priority);
        } else {
            return this;
        }
    };



    ticker.add2(function(){

        if(typeof anim !== "undefined" && !anim.isMoving && punto_actual === puntos.length - 1 && (anim.x < puntos[punto_actual].x + offsetBackground_x + 2 && anim.x > puntos[punto_actual].x + offsetBackground_x - 2) && (anim.y < puntos[punto_actual].y + offsetBackground_y + 2  && anim.y > puntos[punto_actual].y + offsetBackground_y - 2)){

            if( $("canvas").css("z-index") !== "-1"){
                $("canvas").css("z-index", -1);
                $(".wrapper").css("opacity", 1);
                $(".wrapper").css("filter", "alpha(opacity=0)");
                //ticker.remove(calldfMoveSprite);
            }
        }
    }, undefined, PIXI.UPDATE_PRIORITY.UTILITY);


    function moveSprite(background, sprite) {

        return function(delta){


            var dst = puntos[punto_actual];
            var x = dst.x + offsetBackground_x;
            var y = dst.y + offsetBackground_y;
            var mod_x, mod_y, out_y, out_x;

            if (x > sprite.x) {
                mod_x = 1;
            } else if (x < sprite.x) {
                mod_x = -1;
            }
            if (y > sprite.y) {
                mod_y = 1;
            } else if (y < sprite.y) {
                mod_y = -1;
            }

            if(!(out_range_x || out_range_y)){

                out_y = true;
                if (!(y - 2 < sprite.y && sprite.y < y+2) ) {
                    var last_y = sprite.y;
                    sprite.y +=  mod_y + mod_y*delta;

                    if (y !== sprite.y){
                        if(last_y < y && sprite.y < y){
                            out_y = false;
                        } else if(last_y > y && sprite.y > y){
                            out_y = false;
                        }
                    }
                }

                out_x = true;
                if ( !(x - 2 < sprite.x && sprite.x < x + 2) ) {
                    var last_x = sprite.x;
                    sprite.x +=  mod_x + mod_x*delta;
                    if (x !== sprite.x){
                        if(last_x < x && sprite.x < x){
                            out_x = false;
                        } else if(last_x > x && sprite.x > x){
                            out_x = false;
                        }
                    }
                }


                var isDst = out_x && out_y;
                if (isDst) {
                    if(typeof sprite.isMoving !== "undefined" && sprite.isMoving){
                        sprite.isMoving=false;
                    }
                }
                else {
                    sprite.x = Math.floor(sprite.x);
                    sprite.y = Math.floor(sprite.y);
                }


                if(!isDst && mod_x > 0){
                    if(sprite.x + Math.floor(app.view.width/5)>= app.view.width){
                        out_range_x = true;
                        last_offset_x = 0;
                    }
                }
                else if(!isDst) {
                    if(sprite.x - Math.floor(app.view.width/5) <= 0){
                        out_range_x = true;
                        last_offset_x = 0;
                    }
                }

                if(!isDst && mod_y > 0){
                    if(sprite.y +Math.floor(app.view.height/10) >= app.view.height ){
                        out_range_y = true;
                        last_offset_y = 0;
                    }
                }
                else if(!isDst) {
                    if(sprite.y - Math.floor(app.view.height/10) <= 0){
                        out_range_y = true;
                        last_offset_y = 0;
                    }
                }

            }
            else {
                var finish;

                if(out_range_x){

                    var limite_background_izq = 0, limite_background_der = (app.view.width - background.width) > 0 ? app.view.width : app.view.width - background.width;

                    var dx2 = -1*mod_x*(1 + delta);
                    finish = false;

                    if(background.x + dx2 >= limite_background_izq || background.x + dx2 <= limite_background_der){
                        dx2 = mod_x > 0? limite_background_der - background.x : limite_background_izq - background.x;
                        finish = true;
                    }

                    background.x += dx2;
                    offsetBackground_x += dx2;
                    sprite.x += dx2;
                    last_offset_x += Math.abs(mod_x*(1 + delta));

                    background.x = Math.floor(background.x);
                    offsetBackground_x = Math.floor(offsetBackground_x);
                    sprite.x = Math.floor(sprite.x);
                    last_offset_x = Math.floor(last_offset_x);

                    if (Math.abs(last_offset_x) >= Math.floor(app.view.width*0.4) || finish){
                        last_offset_x = 0;
                        out_range_x = false;
                    }
                }
                if (out_range_y){

                    var limite_background_sup = 0, limite_background_inf = (app.view.height - background.height) > 0 ? 0 : app.view.height - background.height;

                    var dy2 = -1*mod_y*(1 + delta);
                    finish = false;

                    if(background.y + dy2 >= limite_background_sup || background.y + dy2 <= limite_background_inf){
                        dy2 = mod_y > 0? limite_background_inf - background.y : limite_background_sup - background.y;
                        finish = true;
                    }

                    background.y += dy2;
                    offsetBackground_y += dy2;
                    sprite.y += dy2;
                    last_offset_y += Math.abs(mod_y*(1 + delta));

                    background.y = Math.floor(background.y);
                    offsetBackground_y = Math.floor(offsetBackground_y);
                    sprite.y = Math.floor(sprite.y);
                    last_offset_y = Math.floor(last_offset_y);

                    if (Math.abs(last_offset_y) >= Math.floor(app.view.height*0.4) || finish){
                        last_offset_y = 0;
                        out_range_y = false;
                    }
                }

            }
        }
    }
</script>
<?php

$n_puntos = 27;

function parsePregunta_simple($pregunta, $n){
    $template_simple = "<div class=\"widget simple\" id=\"pr%d\">\n"
        ."%s"
        ."\n</div>";

    return sprintf($template_simple, $n, str_replace("\n","<br>",$pregunta["PREGUNTA"]));
}

function parsePregunta_multiple($pregunta, $n){
    $template_multiple = "<div class=\"widget multiple_multiple\" id=\"pr%d\">\n"
        ."%s"
        ."\n</div>";

    $template_multiple_input = "<input type=\"checkbox\" name=\"checkbox-%d\" id=\"checkbox-%d\" %s>\n"
        ."<label for=\"checkbox-%d\">%s</label>\n";

    $resp_correct = "value=\"*\"";

    $contenido = "";
    $arrayPreguntas =  preg_split('/ \|\| /', $pregunta["PREGUNTA"], -1);
    $arrayChecks = preg_split('/ \|\| /', $pregunta["VALID_PREGUNTA"], -1) ;

    for($i=0; $i < count($arrayPreguntas); $i++){
        $check = $arrayChecks[$i];
        $q = $arrayPreguntas[$i];

        $valid = "";
        if($check == "true"){
            $valid = $resp_correct;
        }

        $contenido .= sprintf($template_multiple_input, $i+1, $i+1, $valid, $i+1,str_replace("\n","<br>",$q));
    }

    return sprintf($template_multiple, $n, $contenido);
}

function parsePregunta_rellenar($pregunta, $n){
    $template_rellenar = "<div class=\"widget rellenar\" id=\"pr%d\">\n"
        ."%s"
        ."\n</div>";

    $template_rellenar_input = " <input name=\"%s\" type=\"text\"> ";

    $contenido = $pregunta["PREGUNTA"];
    preg_match_all('/\{(.*)?\}/',
        $contenido,
        $salida, PREG_SET_ORDER, 0);

    foreach ($salida as $match){
        $s = sprintf($template_rellenar_input, $match[1]);
        $contenido = str_replace($match[0], $s, $contenido);
    }

    return sprintf($template_rellenar, $n, $contenido);
}

function parsePregunta($pregunta, $n){
    $r = "";
    switch ($pregunta["TYPE_QUESTION"]){
        case "Simple":
            $r.= parsePregunta_simple($pregunta, $n);
            break;
        case "Opción Múltiple":
            $r .= parsePregunta_multiple($pregunta, $n);
            break;
        case "Rellenar":
            $r.= parsePregunta_rellenar($pregunta, $n);
            break;
    }
    return $r;
}


for ($i = 0; $i < $n_puntos; $i++){
    $r = "";
    if(!empty($preguntas) && array_key_exists($i, $preguntas)){
        $r .= parsePregunta($preguntas[$i], $i);
    }
    echo $r."\n\n";
}

?>


<div class="widget" id="pr_">
</div>


<div id="alert" class="widget alert ui-widget-content ui-corner-all">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
        Mensaje de alerta
    </p>
</div>

<div class="wrapper">
    <div class="modal modal--congratulations">
        <div class="modal-top">
            <img class="modal-icon u-imgResponsive" src="../images/trophie.png" alt="Trophy" />
            <div class="modal-header">Felicidades</div>
            <div class="modal-subheader">¡Has completado la aventura!</div>
        </div>
    </div>
</div>

<script>
    $(".multiple_unica input").checkboxradio({icon: false});
    $(".multiple_multiple input").checkboxradio({icon: false});

    $( ".multiple_unica" ).controlgroup( {
        direction: "vertical"
    } );

    $( ".multiple_multiple" ).controlgroup( {
        direction: "vertical"
    } );
</script>

</body>
</html>