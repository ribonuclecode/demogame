
<!DOCTYPE html>
<html lang="eng">
<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>

<head>


    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../stylesheets/mystyle.css" />
<style>

    .responsive-container {
        
    }

    .dummy {
        padding-top: 100%; 
    }

    #img-container {
        width: 100%;
        height: 100%;
        position: absolute;
    }

    #img-container img {
        
        background-color: rgb(255, 255, 255);
        border-radius: 12pt;
        border: 3pt solid black;
        margin: 24.5px auto 0px;
        text-align: center;
    }

    .pr {
        display: none;
    }

    

    .ui-draggable, .ui-droppable {
        background-position: top;
    }

    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    .ui-dialog .ui-state-error { padding: .3em; }

    .ui-resizable-se {
        bottom: 17px;
    }
    textarea { width: 300px; height: 150px; padding: 0.5em; }


    p.label_field_pair {
        clear: both;
        float: none;
    }

    p.label_field_pair label {
        clear: left;
        display: block;
        float: left;
        text-align: right;
        width: 100px;
        padding: .4em; 
    }

    p.label_field_pair label {
        clear: left;
        display: block;
        float: left;
        text-align: right;
        width: 100px;
        padding: .4em; 
    }

    p.label_field_pair button {
        clear: left;
        display: block;
        float: left;
        text-align: center;
    }

    p.label_field_pair input  {
        clear: right;
        float: left;
        margin-left: 10px;
        width: 200px;
    }

    p.label_field_pair textarea  {
        clear: right;
        float: left;
        margin-left: 10px;
        width: 90%!important;
    }

    p.label_field_pair div.ui-wrapper{
        width: 85%!important;
    }

    .ui-selectmenu-button.ui-button {
        width: 90%;
    }

    .widget-template input {
        display: inline-block;
    }

    label.checklabel {
        width: 20px!important;
        text-align: center!important;
    }

    .check-template label {
        text-align: left!important;
    }


</style>

</head>
<body id="body">
<div class="responsive-container">
   

    <div id="img-container">
        <img id="mapa" onclick="showCoords(event)" src="../images/mapa.jpeg">
    </div>
</div>

<script>

    <?php
    include("../config.php");

   
    $conn = new mysqli($server, $db_user, $db_pass, $database);

   
    if ($conn->connect_error) {
        die("error:" . $conn->connect_error);
    }

    if (!$conn->set_charset("utf8")) {
        die("error:". $conn->error);
    } 

    $result = $conn->query(sprintf($select_preguntas, basename(__FILE__, '_mod.php') ));

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



    function dataQ($pregunta, $position){
        $r = "";
       
       
        if(!empty($pregunta) && array_key_exists($position, $pregunta)){
            $r = ", data: ".json_encode($pregunta[$position]);
        }
        return $r;
    }

    $pos = 0;
    ?>



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

    var puntos = [
        {x: 179, y: 447 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 290, y: 350 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 400, y: 430 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 416,y:325 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 495,y:262 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 539,y:363 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 622,y:405 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 678,y:349 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 664,y:262 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 609,y:188 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 666,y:108 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 758,y:146 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 777,y:254 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 743,y:349 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 740,y:456 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 833,y:487 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 898,y:429 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 879,y:342 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 944,y:320 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 998,y:434 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 1059,y:379 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 1060,y:308 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 1143,y:300 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 1047,y:255 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 1109,y:216 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 1179,y:198 <?php echo dataQ($preguntas,$pos); $pos++; ?>},
        {x: 1218,y:64 <?php echo dataQ($preguntas,$pos); $pos++; ?>}
    ];


    var img = document.getElementById("body");

    function getMousePos(element, evt) {
        var rect = element.getBoundingClientRect();
        return {
            x: Math.floor(evt.clientX - rect.left),
            y: Math.floor(evt.clientY - rect.top)
        };
    }


    function showCoords(event) {
        var pos = getMousePos(img, event);

        var x = pos.x - parseInt($("img#mapa").css("margin-left"));
        var y = pos.y - parseFloat($("img#mapa").css("margin-top"));
        var coords = "x: " + x + ", y: " + y;
        
        positionInPoint(x,y);
    }

    function positionInPoint(x,y){
        
        var r = 25;
        var d;
        for(var i=0; i < puntos.length; i++){
            d = Math.sqrt( Math.pow(x-puntos[i].x,2) + Math.pow(y-puntos[i].y, 2) );
            if(d <= r){
                $(".widget-template").dialog({
                    autoOpen: true,
                    height: "auto",
                    width: 400,
                    modal: true
                });
                showDialogs(i);
                break;
            }
        }
    }

    var form;
    var AllFieldWithErrors = $([]);


    function parseIdTag(id) {
        if(id.includes("title")){
            return "title"
        } else if(id.includes("efecto")){
            return "efecto";
        } else {
            return id;
        }
    }

    function getFormData($form, index){
       
        var indexed_array = {};
       
        indexed_array["n_question"] = index;
       
        if(typeof puntos[index].data !== "undefined"){
            if(typeof puntos[index].data.ID !== "undefined"){
                indexed_array["ID"] = puntos[index].data.ID;
            }
        }
       
        indexed_array["url"] = /(.*)_mod\.php/.exec(window.location.href.split("/")[window.location.href.split("/").length-1])[1];
        var form = $form[0];
        var element;
        var boolCapture = false;
        var j = 0;
        var z_check = 0;
        var z_preg = 0;
        var isMultipleForm = false;
        for(var i=0; i < form.length; i++){
            element = $(form[i]);


            if (element.is("select") && jqueryProp(element, "id") === "type-question"){
               
                var t = element.find("option:selected").text();
                indexed_array[jqueryProp(element, "id")] = t;
               
                if(t === "Opción Múltiple"){
                    isMultipleForm = true;
                    indexed_array["check-resp-multiple"] = {};
                    indexed_array["pregunta-multiple"] = {};
                }
               
                if(typeof puntos[index].data !== "undefined" && typeof puntos[index].data.TYPE_QUESTION !== "undefined"){
                    indexed_array["last_type"] = puntos[index].data.TYPE_QUESTION;
                } else {
                    indexed_array["last_type"] = t;
                }
            }

            if(element.is("fieldset") && element.hasClass("pr")){
               
                boolCapture = element.css("display") !== "none";
            }

            if(boolCapture){
                var r = {};
                if (element.is("input")){
                    r._type = "input";
                    r.type = jqueryProp(element, "type");
                    r.id = jqueryProp(element, "id");
                    if(r.type === "checkbox"){
                        r.value = !!element.prev("label").hasClass("ui-checkboxradio-checked");
                    } else {
                        r.value = element.val();
                    }
                    
                    if(typeof r.id !== "undefined"){
                        if(isMultipleForm && r.id.includes("check-resp-multiple")){
                            indexed_array["check-resp-multiple"][z_check] = r;
                            z_check++;
                        } else {
                            indexed_array[parseIdTag(r.id)] = r;
                        }

                    } else {
                        indexed_array[j] = r;
                        j++;
                    }
                    
                    
                }
                else if(element.is("select")){
                    r.id = jqueryProp(element, "id");
                    r._type = "select";
                    r.value = element[0].selectedIndex;
                    r.text = element.find("option:selected").text();
                    if(typeof r.id !== "undefined"){
                        indexed_array[parseIdTag(r.id)] = r;
                    } else {
                        indexed_array[j] = r;
                        j++;
                    }
                }
                else if(element.is("textarea")){
                    r.id = jqueryProp(element, "id");
                    r.value = element.val();
                    r._type = "textarea";

                    if(typeof r.id !== "undefined"){
                        if(isMultipleForm && r.id.includes("pregunta-multiple")){
                            indexed_array["pregunta-multiple"][z_preg] = r;
                            z_preg++;
                        } else {
                            indexed_array[parseIdTag(r.id)] = r;
                        }
                    } else {
                        indexed_array[j] = r;
                        j++;
                    }
                }
            }
        }

       
       
       
       
       
       
       
       

        return indexed_array;
    }

    function isJson(item) {
        item = typeof item !== "string"
            ? JSON.stringify(item)
            : item;

        try {
            item = JSON.parse(item);
        } catch (e) {
            return false;
        }

        if (typeof item === "object" && item !== null) {
            return true;
        }

        return false;
    }

    function saveQuestion(index) {
        var form = $("form");
        var data = getFormData(form, index);
        
        form.dialog("close");
        $.ajax({
           data: data,
           type: "POST",
           url: "../save_mod_game.php",
            timeout: 20000,
            contentType: "application/x-www-form-urlencoded;charset=UTF-8",
            success: function(response){
               
               if(isJson(response)){
                   response = JSON.parse(response)[0];
                   puntos[parseInt(response.N_QUESTION)]["data"] = response;
               }
            },
            error: function(xmlhttprequest, textstatus, message){
                if(textstatus==="timeout") {
                } else {
                }
            }
        });
    }

    function position_widgetTemplate_topRight(){
        $(".widget-template").parent().css("top", $(window).height()*0.02 + $(window).scrollTop());
        $(".widget-template").parent().css("left", $(window).width() - $(".widget-template").parent().width()-10 + $(window).scrollLeft());
    }

    function resetDialogTemplate(){
        $(".widget-template").dialog("option", "title", "");
        $(".widget-template").dialog("option", "buttons", []);
        $(".widget-template").parent().find(".ui-dialog-content").html("");

        $(".ui-widget.error").remove();
    }

    function editTitle(text){
       
        var title = typeof text ==="object" ? $(this).val() : text;
        $(".widget-template").dialog("option", "title", title);
    }

    function editFirstButton(text){
        var title = typeof text ==="object" ? $(this).val() : text;
        $(".widget-template").parent().find(".ui-dialog-buttonset").find("button").eq(0).html(title);
    }

    function editSecondButton(text){
        var title = typeof text ==="object" ? $(this).val() : text;
        $(".widget-template").parent().find(".ui-dialog-buttonset").find("button").eq(1).html(title);
    }

    function editPregunta(){
        _editPregunta(formatPreguntaHtml($(this).val()));
    }

    function editPreguntaMultiple(id){
            return function(text) {
                var contenidoPregunta = typeof text ==="object" ? $(this).val() :text;
                var pregunta = formatPreguntaHtml(contenidoPregunta);
                var specific_div = $(".widget-template").parent().find(".ui-dialog-content").find("div[id='check-template-" + id +"']");
                var existDivs = $(".widget-template").parent().find(".ui-dialog-content").find("div[id*='check-template-']").length;

                if(specific_div.length){
                   
                    if(pregunta!==""){
                        specific_div.children().closest("label").html(pregunta);
                    } else {
                        specific_div.remove();
                    }

                } else if(existDivs){
                   
                    var contenido = "";
                    if(pregunta !== ""){
                        contenido = "<div id=\"check-template-" + id + "\" class='check-template'>";
                        contenido += "<label for=\"checkbox-" + id + "\">" + pregunta + "</label>";
                        contenido += "<input type=\"checkbox\" name=\"checkbox-" + id + "\" id=\"checkbox-" + id + "\">";
                        contenido += "<\div>";
                    }

                    $(".widget-template").parent().find(".ui-dialog-content").append(contenido);
                    $(".widget-template input[id='checkbox-" + id +"']").checkboxradio({icon: false});
                    $(".widget-template input[id='checkbox-" + id +"']").css("width", "100%");
                } else {
                   
                    var contenido = "";
                    if(pregunta !== ""){
                        contenido = "<div id=\"check-template-" + id + "\" class='check-template'>";
                        contenido += "<label for=\"checkbox-" + id + "\">" + pregunta + "</label>";
                        contenido += "<input type=\"checkbox\" name=\"checkbox-" + id + "\" id=\"checkbox-" + id + "\">";
                        contenido += "<\div>";
                    }
                    _editPregunta(contenido);

                    $(".widget-template input[type='checkbox']").checkboxradio({icon: false});
                    $(".widget-template").controlgroup( {
                        direction: "vertical"
                    } );
                }


            }
    }

    function editPreguntaRellenar(text){
        var _pregunta = typeof text ==="object" ? $(this).val() : text;
        var pregunta = formatPreguntaHtml(_pregunta);
        pregunta = pregunta.replace(/\{(.*?)\}/g, function(x){
            var x = x.replace(/\{|\}/g,"");
            return "<input type='text' value='" + x + "'" +
                "style=\"font-family: 'Open Sans', sans-serif;padding: 0px;text-align: center;background-color: green; color:white\"" +
                "maxlength='" + x.length + "'" +
                "size='" + x.length +"'" +
                ">";
        });
        _editPregunta(pregunta);
    }

    function formatPreguntaHtml(text){
        function _enterKeyToHtml(text){
            return text.replace(/\n/g,"<br>");
        }
        return _enterKeyToHtml(text);
    }

    function _edit_warningMessage(text){
       
        var msg = typeof text ==="object" ? $(this).val() : text;
        var html_code = "<div id=\"error" + "multiple" + "\"" + " class=\"ui-state-highlight ui-corner-all\" style=\"margin-top: 20px; padding: 0.7em; display: block\">\n" +
            "\t\t<p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>\n" +
            "\t\t"+ msg.replace(/¡(.*?)!/g, function(x){ return "<strong>" + x + "</strong>"}) +"</p>\n" +
            "\t</div>";
        $(".widget-template").parent().find(".ui-widget.error").html(html_code);
    }
    function _warningMessage(ID, obj){
       
        return function() {
            var html_code = "<div class=\"ui-widget error\">\n" +
                "\t<div id=\"error" + ID + "\"" + " class=\"ui-state-highlight ui-corner-all\" style=\"margin-top: 20px; padding: 0.7em; display: block\">\n" +
                "\t\t<p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>\n" +
                "\t\t<strong>¡Error!</strong> Prueba de nuevo </p>\n" +
                "\t</div>\n" +
                "</div>";
            $(obj).closest(".ui-dialog").append(html_code);
        }
    }
    function _editPregunta(question){
        $(".widget-template").parent().find(".ui-dialog-content").html(question);
    }

    function parseId(str){
        var arr = str.split("-");
        var n = parseInt(arr[arr.length-1]);
        var string = arr.slice(0, arr.length-1).join("-");
        return [string, n]
    }

    function replaceId(str, newId){
        var arr = str.split("-");
        var string = arr.slice(0, arr.length-1).join("-");
        return string + "-" + newId;
    }

    function updateIdOfRespMultiple(clone, id, addRemoveClick){
        addRemoveClick = typeof addRemoveClick !== "undefined"? addRemoveClick: true;
        var isChecked = false;
        clone.attr("id", replaceId( clone.attr("id"), id ));
        clone.children().each(function(){
            var id2;

            var attrName = "id";
            if($(this).is("label")){
                attrName = "for";
            }
            id2 = $(this).attr(attrName);
            if(typeof id2 !== "undefined"){
                $(this).attr(attrName, replaceId( $(this).attr(attrName), id ));
            }

            if(addRemoveClick && $(this).is("button") && $(this).attr("class").includes("remove")){
                $(this).show();
                $(this).on("click", function(e){
                    var nameId, id3;
                    var parent = $(e.target).parent();
                    [nameId, id3] = parseId(parent.attr("id"));
                    $("#div-resp-multiple").find("p").each(function(index){
                        if(index+1 === id3){
                            
                            $(this).remove();
                            $(".widget-template").parent().find(".ui-dialog-content").find("div[id='check-template-" + id3 +"']").remove();
                            $(".widget-template").parent().find(".ui-dialog-content").find("div[id*='check-template-']").each(function(index){
                                $(this).attr("id", replaceId( $(this).attr("id"), index+1 ));
                                $(this).children().closest("label").attr("for", replaceId( $(this).children().closest("label").attr("for"), index+1 ));
                                $(this).children().closest("input").attr("id", replaceId( $(this).children().closest("input").attr("id"), index+1 ));
                            });
                        }
                    });

                    $("#div-resp-multiple").find("p").each(function(index){
                        
                       
                        updateIdOfRespMultiple($(this), index+1 , false);

                        if(index === 0){
                           
                            $(this).children().eq(2).hide();
                        }
                    });
                });
            }
            else if($(this).is("label") && $(this).attr("class").includes("checklabel")){
                if($(this).attr("class").includes("ui-checkboxradio-checked")){
                    isChecked = true;
                }
                $(this).replaceWith("<label for=\"check-resp-multiple-" + id +"\" class=\"checklabel\"></label>");
            }
            else if($(this).is("input") && $(this).attr("type") === "checkbox" && $(this).attr("class").includes("check")){
                $(this).replaceWith("<input type=\"checkbox\" id=\"check-resp-multiple-" + id +"\" class=\"check\" style=\"text-align: center;\">");
            }

            if($(this).is(":parent")){
                $(this).children().each(function(){
                    var attrName = "id";
                    id2 = $(this).attr(attrName);
                    if(typeof id2 !== "undefined"){
                        $(this).attr(attrName, replaceId( $(this).attr(attrName), id ));
                    }

                    if($(this).is("textarea")){
                        if(addRemoveClick){
                            $(this).val("");
                        }
                        $(this).off("keyup");
                        $(this).on("keyup", editPreguntaMultiple(id));
                    }



                });
            }
        });

       
        clone.find("input.check").checkboxradio({
            label: "",
            create: function(e){
                $(this).prev().on("click", function(){
                    var nameId, id4;
                    [nameId, id4]= parseId($(this).attr("for"));
                   
                    if($("textarea#pregunta-multiple-" + id4).length && $("textarea#pregunta-multiple-" + id4).val().replace(/\s/g, "") !== ""){
                        $(".widget-template").parent().find(".ui-dialog-content").find("div[id='check-template-" + id4 +"']").children().closest("label").trigger("click");
                    }

                });
                if(isChecked){
                    var nameId, id5;
                    $(this).prev().trigger("click");
                    [nameId, id5]= parseId($(this).prev().attr("for"));
                    $(".widget-template").parent().find(".ui-dialog-content").find("div[id='check-template-" + id5 +"']").children().closest("label").trigger("click");
                }
            }
        });

    }

    function showMessageError(element, warn, f){
        var valid = true;
        var error;
        if(!element.next().hasClass("ui-state-error")){
            element.after(_boxError(warn));
            element.next().css("width", element.width()/element.parent().width()*100 + "%");
        }

        error = element.next();
        if(!f(element)){
            error.hide();
        } else {
            valid = false;
            error.css("display", "inline-block");
        }

        return valid;

    }

    function _boxError(msg){
        return "<div class=\"ui-state-error ui-corner-all\" style=\"display:none\">\n" +
            msg + "</div>";
    }

    function validForm() {
        var valid = false;
        var form = $("form").parent();
        var msg_empty = "No puede estar vacio";
        var f_empty = function(t){ return t.val().trim().length === 0};
        switch (form.find("#type-question").val()){
            case "Simple":
                valid = showMessageError(form.find("input#title"),          msg_empty, f_empty);
                valid = showMessageError(form.find("textarea#pregunta"),     msg_empty, f_empty) && valid;
                valid = showMessageError(form.find("input#resp-aff"),        msg_empty, f_empty) && valid;
                valid = showMessageError(form.find("input#resp-neg"),        msg_empty, f_empty) && valid;
                break;
            case "Opción Múltiple":
                valid = showMessageError(form.find("input#title-multiple"),          msg_empty, f_empty);
                valid = showMessageError(form.find("input#warning-msg"),        msg_empty, f_empty) && valid;

                form.find("textarea[id^='pregunta-multiple-']").each(function(){
                    valid = showMessageError($(this), msg_empty, f_empty) && valid;
                });

                break;
            case "Rellenar":
                valid = showMessageError(form.find("input#title-rellenar"),          msg_empty, f_empty);
                valid = showMessageError(form.find("textarea#pregunta-rellenar"),     msg_empty, f_empty) && valid;
                valid = showMessageError(form.find("input#confirmacion-rellenar"),        msg_empty, f_empty) && valid;
                break;
            default:
                break;
        }
        return valid;
    }

    function fChange_type_question(this_dialog) {
        return function (event, data) {
            if(typeof data !== "undefined"){
                switch (data.item.value) {
                    case "Simple":
                        lastOption.hide();
                        resetDialogTemplate();
                        lastPositionTopDialog = this_dialog.css("top");
                        this_dialog.css("top", "0");

                       
                        $(".widget-template").dialog("option", "buttons", [{text: "Si"}, {text: "No"}]);

                        position_widgetTemplate_topRight();

                        
                       
                        if (typeof puntos[posCasilla].data !== "undefined" && puntos[posCasilla].data.TYPE_QUESTION === data.item.value) {
                            var data = puntos[posCasilla].data;
                            this_dialog.find("input#title").val(data.TITULO);
                            editTitle(data.TITULO);
                            this_dialog.find("textarea#pregunta").val(data.PREGUNTA);
                            _editPregunta(data.PREGUNTA);

                            this_dialog.find("input#checkbox-resp[type='checkbox']").prev().trigger("click");
                            this_dialog.find("input#resp-aff").val(data.RESP_AFF);
                            editFirstButton(data.RESP_AFF);
                            this_dialog.find("input#resp-neg").val(data.RESP_NEG);
                            editSecondButton(data.RESP_NEG);

                        }

                        simpleQuestion.show();
                        lastOption = simpleQuestion;
                        $("form").parent().find(".ui-dialog-buttonset").children().eq(0).show();

                        break;
                    case "Rellenar":
                        lastOption.hide();
                        resetDialogTemplate();
                        lastPositionTopDialog = this_dialog.css("top");
                        this_dialog.css("top", "0");

                       
                        $(".widget-template").dialog("option", "buttons", [{text: "Confirmar"}]);
                        position_widgetTemplate_topRight();

                       
                        if (typeof puntos[posCasilla].data !== "undefined" && puntos[posCasilla].data.TYPE_QUESTION === data.item.value) {
                            var data = puntos[posCasilla].data;
                            this_dialog.find("input#title-rellenar").val(data.TITULO);
                            editTitle(data.TITULO);
                            this_dialog.find("textarea#pregunta-rellenar").val(data.PREGUNTA);
                            editPreguntaRellenar(data.PREGUNTA);

                            this_dialog.find("input#checkbox-resp-rellenar[type='checkbox']").prev().trigger("click");
                            this_dialog.find("input#confirmacion-rellenar").val(data.RESP_AFF);
                            editFirstButton(data.RESP_AFF);
                        }
                        fillQuestion.show();
                        lastOption = fillQuestion;
                        $("form").parent().find(".ui-dialog-buttonset").children().eq(0).show();
                        break;
                    case "Opción Múltiple":

                        lastOption.hide();
                        resetDialogTemplate();
                        lastPositionTopDialog = this_dialog.css("top");
                        this_dialog.css("top", "0");

                       
                        _warningMessage("multiple", $(".widget-template"))();
                        $("#div-resp-multiple").find("p").each(function (index) {
                            if (index > 0) {
                                $(this).remove();
                            }
                        });
                        position_widgetTemplate_topRight();
                       
                        if (typeof puntos[posCasilla].data !== "undefined" && puntos[posCasilla].data.TYPE_QUESTION === data.item.value) {
                            var data = puntos[posCasilla].data;
                            this_dialog.find("input#title-multiple").val(data.TITULO);
                            editTitle(data.TITULO);

                            var sep = " || ";
                            var arrayPreguntas = data.PREGUNTA.split(sep);
                            var arrayValidsPreguntas = data.VALID_PREGUNTA.split(sep);

                            for(var j=0; j< arrayPreguntas.length - 1; j++){
                                this_dialog.find("button#add-resp-multiple").trigger("click");
                            }

                            for(j=0; j< arrayPreguntas.length; j++){
                                var id = j+1;
                                var contenido = arrayPreguntas[j];
                                var check = arrayValidsPreguntas[j];
                                this_dialog.find("textarea#pregunta-multiple-" + id).val(contenido);
                                editPreguntaMultiple(id)(contenido);
                                if(check === "true"){
                                    this_dialog.find("input#check-resp-multiple-" + id + "[type='checkbox']").prev().trigger("click");
                                   
                                }
                            }

                            

                            this_dialog.find("input#checkbox-warning[type='checkbox']").prev().trigger("click");
                            this_dialog.find("input#warning-msg").val(data.MSG_WARNING);
                            _edit_warningMessage(data.MSG_WARNING);
                        }
                        multipleQuestion.show();
                        lastOption = multipleQuestion;
                        $("form").parent().find(".ui-dialog-buttonset").children().eq(0).show();
                        break;
                    default:

                        this_dialog.css("top", lastPositionTopDialog);
                        lastOption.hide();
                        resetDialogTemplate();
                        position_widgetTemplate_topRight();
                        $("form").parent().find(".ui-dialog-buttonset").children().eq(0).hide();
                        break;
                }
            }
        }
    }
   
    var posCasilla = -1;
    function showDialogs(i){
        posCasilla = i;
        position_widgetTemplate_topRight();
        $( "form" ).dialog({
                autoOpen: true,
                height: "auto",
                width: 400,
                title: "Crear nueva pregunta",
                modal: true,
                open: function(){
                    var this_dialog = $(this).closest(".ui-dialog");
                    this_dialog.find("input#checkbox-resp[type='checkbox']").each(function(){
                        var resp_aff = $(this).next();
                        var resp_neg = resp_aff.next();
                        if($(this).is( ":checked" )){
                            resp_aff.show();
                            resp_neg.show();
                        } else {
                            resp_aff.hide();
                            resp_neg.hide();
                        }
                    });
                    this_dialog.find("input#checkbox-resp-rellenar[type='checkbox']").each(function(){
                        var conf = $(this).next();

                        if($(this).is( ":checked" )){
                            conf.show();
                        } else {
                            conf.hide();
                        }
                    });
                    this_dialog.find("input#checkbox-warning[type='checkbox']").each(function(){
                        var conf = $(this).next();

                        if($(this).is( ":checked" )){
                            conf.show();
                        } else {
                            conf.hide();
                        }
                    });
                    $("form").parent().find(".ui-dialog-buttonset").children().eq(0).hide();

                   
                    if (typeof puntos[i].data !== "undefined"){
                        if( $(this).find( "#type-question").children().filter(function(e){return $(this).val().trim() == puntos[i].data.TYPE_QUESTION}).length > 0){
                            $(this).find( "#type-question ").val(puntos[i].data.TYPE_QUESTION).selectmenu("refresh").trigger("selectmenuselect");
                        }
                    }

                },
                create: function(){
                    $("form").parent().find(".ui-dialog-buttonset").children().eq(0).hide();
                    var this_dialog = $(this).closest(".ui-dialog");

                    $(this).find("input#title").on("keyup", editTitle);
                    $(this).find("input#title-rellenar").on("keyup", editTitle);
                    $(this).find("input#title-multiple").on("keyup", editTitle);

                    $(this).find("input#resp-aff").on("keyup", editFirstButton);
                    $(this).find("input#resp-neg").on("keyup", editSecondButton);

                    $(this).find("input#confirmacion-rellenar").on("keyup", editFirstButton);

                    $(this).find("input#warning-msg").on("keyup", _edit_warningMessage);

                    $(this).find("textarea#pregunta").on("keyup", editPregunta);
                    $(this).find("textarea#pregunta-rellenar").on("keyup", editPreguntaRellenar);
                    $(this).find("textarea#pregunta-multiple-1").on("keyup", editPreguntaMultiple(1));

                    $(this).find("button#add-resp-multiple").on("click", function () {
                        var nameid, id;
                        var target = $(this).prev().children().eq(-1);
                        [nameid, id] = parseId(target.attr("id"));
                        id = id+1;

                       
                        var clone = target.clone();
                        updateIdOfRespMultiple(clone, id);
                        clone.appendTo($(this).prev());

                        $( "button" ).click( function( event ) {
                            event.preventDefault();
                        } );


                    });

                    this_dialog.find("input#checkbox-resp[type='checkbox']").on("change", function(e){
                        var target = $(e.target);
                        var resp_aff = target.next();
                        var resp_neg = resp_aff.next();
                        if(target.is( ":checked" )){
                            position_widgetTemplate_topRight();
                            resp_aff.show();
                            resp_neg.show();
                        } else {
                            position_widgetTemplate_topRight();
                            resp_aff.hide();
                            resp_neg.hide();
                            resp_aff.find("input#resp-aff").val("Si");
                            resp_neg.find("input#resp-neg").val("No");
                            $(".widget-template").parent().find(".ui-dialog-buttonset").find("button").eq(0).html(resp_aff.find("input#resp-aff").val());
                            $(".widget-template").parent().find(".ui-dialog-buttonset").find("button").eq(1).html(resp_neg.find("input#resp-neg").val());
                        }
                    });

                    this_dialog.find("input#checkbox-resp-rellenar[type='checkbox']").on("change", function(e){
                        var target = $(e.target);
                        var conf = target.next();
                        if(target.is( ":checked" )){
                            position_widgetTemplate_topRight();
                            conf.show();
                        } else {
                            position_widgetTemplate_topRight();
                            conf.hide();
                            conf.find("input#confirmacion-rellenar").val("Confirmar");
                            $(".widget-template").parent().find(".ui-dialog-buttonset").find("button").eq(0).html(conf.find("input#confirmacion-rellenar").val());
                        }
                    });

                    this_dialog.find("input#checkbox-warning[type='checkbox']").on("change", function(e){
                        var target = $(e.target);
                        var conf = target.next();
                        if(target.is( ":checked" )){
                            position_widgetTemplate_topRight();
                            conf.show();
                        } else {
                            position_widgetTemplate_topRight();
                            conf.hide();
                            conf.find("input#warning-msg").val("¡Error! Prueba de nuevo");
                            $(".widget-template").parent().find(".ui-dialog-buttonset").find("button").eq(0).html(conf.find("input#warning-msg").val());
                            _edit_warningMessage(conf.find("input#warning-msg").val());
                        }
                    });

                    $(this).find( ".resizable" ).resizable({
                        handles: "se",
                        containment: "form"
                       
                    });
                    $(this).find( ".resizable" ).css("width", "95%");
                    $(this).find( ".resizable" ).parent().css("width", "100%");
                    $(this).find( ".resizable" ).parent().css("height", "auto");

                    $(this).find("#pregunta-multiple-1").css("height", "50px");

                    $(this).find( "form" ).on( "submit", function( event ) {
                            event.preventDefault();
                        });

                    $(this).find( ".efecto" ).selectmenu({});
                    $(this).find( "#type-question" ).unbind("selectmenuselect").bind( "selectmenuselect", fChange_type_question(this_dialog));

                    $(this).find( "#type-question" ).selectmenu({
                        change: fChange_type_question(this_dialog, i)
                    });

                },
                buttons: {
                    "Guardar": function(){
                        if(validForm()){
                            saveQuestion(i);
                        }
                    },
                    Cancel: function() {
                        $(this).dialog( "close" );

                    }
                },
                close: function() {
                    resetDialogTemplate();
                    $(".widget-template").dialog("close");

                    $("form")[0].reset();

                    lastOption.hide();
                    $(this).closest(".ui-dialog").css("top", lastPositionTopDialog);

                    jqueryProp("#type-question option:eq(0)", "selected", true);
                    AllFieldWithErrors.removeClass( "ui-state-error" );
                }
            });
    }
</script>

<div class="widget-template" title="Pregunta">

</div>

<div id="dialog-form"  class="widget"  title="Crear nueva pregunta">
    <form >
        <fieldset class="type-question">
            <legend> Tipo de Pregunta</legend>
            <div class="controlgroup-vertical">
                <select id="type-question">
                    <option selected="selected">----</option>
                    <option>Simple</option>
                    <option>Rellenar</option>
                    <option>Opción Múltiple</option>
                </select>
            </div>
        </fieldset>
        <fieldset class="pr simple">
            
            <label for="title">Título</label>
            <input type="text" name="title" id="title" value="Pregunta" class="text ui-widget-content ui-corner-all">
            <label for="efecto">Efecto</label>
            <select id="efecto" class="efecto" name="efecto">
                <option selected="selected">Moverse a la siguiente casilla</option>
            </select>
            <label for="pregunta">Pregunta</label>
            
            <textarea id="pregunta" class="resizable text ui-widget-content ui-corner-all" rows="5" cols="20"> </textarea>

            <label for="checkbox-resp">¿Modificar Respuestas?</label>
            <input type="checkbox" class="checkbox" name="checkbox-resp" id="checkbox-resp">

            <p class="label_field_pair">
                <label for="resp-aff">Respuesta 1º</label>
                <input type="text" name="resp-aff" id="resp-aff" value="Si" class="text ui-widget-content ui-corner-all">
            </p>
            <p class="label_field_pair">
                <label for="resp-neg">Respuesta 2º</label>
                <input type="text" name="resp-neg" id="resp-neg" value="No" class="text ui-widget-content ui-corner-all">
            </p>

        </fieldset>
        <fieldset class="pr rellenar">
            
            <label for="title-rellenar">Título</label>
            <input type="text" name="title-rellenar" id="title-rellenar" value="Pregunta" class="text ui-widget-content ui-corner-all">
            <label for="efecto-rellenar">Efecto</label>
            <select id="efecto-rellenar" class="efecto" name="efecto">
                <option selected="selected">Moverse a la siguiente casilla</option>
            </select>
            <label for="pregunta-rellenar">Pregunta (las respuestas contenidas entre corchetes. Ej.: Esta es la {respuesta} )</label>
            
            <textarea id="pregunta-rellenar" class="resizable text ui-widget-content ui-corner-all" rows="5" cols="20"> </textarea>

            <label for="checkbox-resp-rellenar">¿Modificar texto de confirmación?</label>
            <input type="checkbox" class="checkbox" name="checkbox-resp" id="checkbox-resp-rellenar">

            <p class="label_field_pair">
                <label for="confirmacion-rellenar">Confirmación</label>
                <input type="text" name="confirmacion-rellenar" id="confirmacion-rellenar" value="Confirmar" class="text ui-widget-content ui-corner-all">
            </p>

        </fieldset>
        <fieldset class="pr multiple">
            
            <label for="title-multiple">Título</label>
            <input type="text" name="title-multiple" id="title-multiple" value="Pregunta" class="text ui-widget-content ui-corner-all">
            <label for="efecto-multiple">Efecto</label>
            <select id="efecto-multiple" class="efecto" name="efecto">
                <option selected="selected">Moverse a la siguiente casilla</option>
            </select>

            <label for="pregunta-multiple-1">Pregunta</label>

                <div id="div-resp-multiple">
                    <p id="resp-multiple-1" class="label_field_pair">
                        <label for="check-resp-multiple-1" class="checklabel"></label>
                        <input type="checkbox" id="check-resp-multiple-1" class="check" style="text-align: center;">
                        <button id="remove-resp-multiple-1" class="remove" style="text-align: center;display:none">Eliminar</button>
                        <textarea id="pregunta-multiple-1" class="resizable text ui-widget-content ui-corner-all" rows="1" cols="20"> </textarea>
                    </p>
                </div>

            <button id="add-resp-multiple">Añadir</button>


            <label for="checkbox-warning">¿Modificar Mensaje de error?</label>
            <input type="checkbox" class="checkbox" name="checkbox-warning" id="checkbox-warning">

            <p class="label_field_pair">
                <label for="warning-msg">Mensaje:</label>
                <input type="text" name="warning-msg" id="warning-msg" value="¡Error! Prueba de nuevo" class="text ui-widget-content ui-corner-all">
            </p>

        </fieldset>
        
        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </form>
</div>




<script>
    $("form input.checkbox").checkboxradio({icon: false});

    $("form button").button();
    $( "button" ).click( function( event ) {
        event.preventDefault();
    } );


    $("form button#add-resp-multiple").button({
        icon: "ui-icon-plusthick"
    });

    $("form button.remove").button({
       icon:  "ui-icon-close",
        showLabel: false
    });

   
    $("form input.check").checkboxradio({
        label: "",
        create: function(e) {
            $(this).prev().on("click", function () {
                var nameId, id4;
                [nameId, id4] = parseId($(this).attr("for"));
                if ($("textarea#pregunta-multiple-" + id4).length && $("textarea#pregunta-multiple-" + id4).val().replace(/\s/g, "") !== "") {
                    $(".widget-template").parent().find(".ui-dialog-content").find("div[id='check-template-" + id4 + "']").children().closest("label").trigger("click");
                }

            });
        }
    });



    var simpleQuestion = $(".simple");
    var fillQuestion = $(".rellenar");
    var multipleQuestion = $(".multiple");
    var lastOption = simpleQuestion;
    var lastPositionTopDialog = -1;


    function adjustImgInCenter(container, inner){
        var inHeight = inner.offsetHeight;
        container.style.height=(window.innerHeight);
        container.style.width=window.innerWidth;
        var conHeight=container.offsetHeight;
        inner.style.marginTop = (conHeight-inHeight)/2+'px';

        var inWidth = inner.offsetWidth;
        container.style.height=(window.innerHeight);
        container.style.width=window.innerWidth;
        var conWidth=container.offsetWidth;
        inner.style.marginLeft = (conWidth-inWidth)/2+'px';
    }

    window.onload = function(){
        var container = document.getElementById("img-container");
        var img = document.getElementById("mapa");
        adjustImgInCenter(container, img);
    }

    window.onresize = function(){
        var container = document.getElementById("img-container");
        var img = document.getElementById("mapa");
        adjustImgInCenter(container, img);
    }
</script>
</body>
</html>