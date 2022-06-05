<?php

include_once 'menu.php'; 
include_once 'functions.php'; 

file_put_contents(__DIR__ . '/all_logs.log', date('[Y-m-d H:i:s] '). getIp()." - index.php". PHP_EOL, FILE_APPEND | LOCK_EX);

?>

<div class="row col-sm-12">
    <div class="btn btn-default btn-warning col-sm-2 col-sm-offset-5" id="show_list"><a href="index.php" id="href_platforms" style="color:white;">Контейнери - список</a></div>
    <div class="btn btn-default btn-success col-sm-2 col-sm-offset-5" id="show_adding">Додати</div>
</div>


        <div class="row col-sm-12 hidden" id="make_platform">            
            <form>
                <div class="row col-sm-4 col-md-offset-4">
                  <label for="exampleInputEmail1">Введіть номер нового контейнера та натисніть кнопку "Зберегти"</label>
                  <input type="text" class="form-control col-md-10" id="new_platform" aria-describedby="emailHelp" placeholder="" readonly="true">                                                      
                </div>
                
                <div class="row col-sm-4 col-md-offset-5" style="margin-top: 10px;">
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="1">1</div>                                
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="2">2</div>                
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="3">3</div>
                </div>
                  
                  <div class="row col-sm-4 col-md-offset-5">
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="4">4</div>                  
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="5">5</div>                  
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="6">6</div>                  
                </div>
                
                <div class="row col-sm-4 col-md-offset-5">
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="7">7</div>                                    
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="8">8</div>                  
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="9">9</div>
                  </div>
                <div class="row col-sm-4 col-md-offset-5">
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="0">0</div>
                  <div class="btn btn-default btn-warning btn-numbers col-md-3 col-sm-3" data-num="Del">Del</div>
                  </div>
                
           <div class="row col-sm-10 col-sm-offset-5">                             
                <button type="button" id="btn_create" class="btn btn-success btn-lg col-sm-2">Зберегти</button>
                </div>
              </form>            
        </div>
<div class="row">
    
    <div class="col-md-12 col-sm-12" id="platforms">
<?php

$date = date('Y.m.d');
$error_text = "<br><center><strong><span>Контейнерів за ".$date." ще немає!<br>Додайте новий контейнер</span></strong></center>";

if (!file_exists("img/".$date)) {    
    echo($error_text);
}
else{
    $platforms = json_decode(get_platform($date));

    if (sizeof($platforms)>0){
        echo("<br><div class='row col-sm-12'><div class='col-md-6 col-md-offset-3'><center>Контейнери поточного дня:</center></div>\n</div>\n");
        echo("<div class='row col-sm-12'>\n<div class='col-md-6 col-md-offset-3'>\n");
            foreach ($platforms as $key => $value) {            
                 echo ("<a href='view_img_by_platform.php?number=".$value."&date=".$date."' class='link_platform' data-number='".$value."'><div style='border:1px solid darkgray;padding-left:10px;'>".$value."</div></a>\n");
            }
        echo("</div>\n</div>\n");
    }
    else{
        echo($error_text);
    }
}
?>
</div>
</div>

<script src="js/lightbox-plus-jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/date.format.js"></script>

<script>
//document.getElementById("href_platforms").classList.add("menu_current");

$("#show_adding").on('click', function(){
   document.getElementById("make_platform").classList.remove("hidden");
   document.getElementById("platforms").classList.add("hidden");
   document.getElementById("show_adding").classList.add("hidden");
   
});

$(".btn-numbers").on('click', function(){
   if ($(this).data("num")!=="Del"){
       $("#new_platform").val($("#new_platform").val()+$(this).data("num")); 
   }
   else {
       $("#new_platform").val($("#new_platform").val().substring(0, $("#new_platform").val().length - 1));
   }
   
});

$( document ).ready(function(){
    
    
    
    $("#if_mgr").removeClass("menu_active");
    $("#if_foto").addClass("menu_active");
    
    
    
    $("#btn_create").on("click", function(){
       var new_platform = $("#new_platform").val();
       if ($("#new_platform").val().length>0){           
           $.ajax({url:'functions.php',
           type: "POST",
           dataType : 'json',
           data:{new_platform:new_platform},// по имени переменной отработает функция
           success: function(data){ 
               if (data.substr(0,6)!=='ERROR!'){
                   $("#platforms").append("<a href='view_img_by_platform.php?number="+new_platform+"&date="+'<?php echo $date; ?>'+"' class='link_platform' data-number='"+new_platform+"'>"+new_platform+"</a><br>\n");               
                   window.location.href = "view_img_by_platform.php?number="+new_platform+"&date="+'<?php echo $date; ?>';
               }               
               console.log(data);               
           }       
       });           
       
       }
       else{
           alert("Введите номер платформы или выберите существующую!");
       }
       
    });
});

</script>