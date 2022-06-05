<?php

include_once 'menu.php'; 
include_once 'get_platform_by_date.php'; 

?>
<hr>
<div class="row">
    <div class="btn btn-lg btn-warning col-md-6 col-sm-6 col-sm-offset-3 col-md-offset-3" id="show_adding">Додати</div>
</div>

        <div class="row hidden" id="make_platform">            
            <form>
                <div class="row">
                  <label for="exampleInputEmail1">Введіть номер нового контейнера та натисніть кнопку "Зберегти"</label>
                  <input type="text" class="form-control" id="new_platform" aria-describedby="emailHelp" placeholder="" readonly="true">                                                      
                </div>
                
                <div class="row" style="margin-top: 10px;">
                  <div class="btn btn-lg btn-warning btn-numbers col-md-4 col-sm-3" data-num="1">1</div>
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="2">2</div>
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="3">3</div>
                  </div>
                  <div class="row">
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="4">4</div>
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="5">5</div>
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="6">6</div>
                  </div>
                  <div class="row">
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="7">7</div>
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="8">8</div>
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="9">9</div>
                  </div>
                  <div class="row" style="margin-bottom: 10px;">
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="0">0</div>
                  <div class="btn btn-lg btn-warning btn-numbers col-md-3 col-sm-3" data-num="Del">Del</div>
                
        </div>   <div class="row">                             
                <button type="button" id="btn_create" class="btn btn-success col-md-12 col-sm-12">Зберегти</button>
                </div>
              </form>            
        </div>
<div class="row">
    <div class="col-md-12 col-sm-12" id="platforms">
<?php

$date = date('Y.m.d');
$error_text = "<br>Съемка за ".$date." еще не проводилась!";

if (!file_exists("img/".$date)) {    
    echo($error_text);
}
else{
    $platforms = json_decode(get_platform($date));

    if (sizeof($platforms)>0){
        echo("<div class='row'><div class='col-sm-10 col-md-10 col-sm-offset-1 col-md-offset-1' style='font-size:40px; text-align:center;margin-top:10px; margin-bottom:10px;'>Контейнери поточного дня:</div>\n</div>\n");
        echo("<div class='row'>\n");
            foreach ($platforms as $key => $value) {            
                 echo ("<a href='view_img_by_platform.php?number=".$value."&date=".$date."' class='link_platform' data-number='".$value."' style='color:green;font-weight:bold;'><div style='border:1px solid darkgray;padding-left:10px;'>".$value."</div></a>\n");
            }
        echo("</div>\n");
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
    $("#btn_create").on("click", function(){
       var new_platform = $("#new_platform").val();
       if ($("#new_platform").val().length>0){           
           $.ajax({url:'make_platform.php',
           type: "POST",
           dataType : 'json',
           data:{new_platform:new_platform},
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