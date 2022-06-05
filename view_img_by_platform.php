<?php

include_once 'menu.php'; 
include_once 'functions.php'; 

file_put_contents(__DIR__ . '/all_logs.log', date('[Y-m-d H:i:s] '). getIp()." - view_images_by_platfom.php". PHP_EOL, FILE_APPEND | LOCK_EX);

if   (isset($_REQUEST['number']) 
        and (isset($_REQUEST['date']))
        ){
    $platform = $_REQUEST['number'];    
    $date = $_REQUEST['date'];    
    ?>

<hr>
<div class="row col-sm-12">
    <div class="btn btn-default btn-warning col-sm-4 col-sm-offset-4"><a href="index.php" id="href_platforms" style="color:white;">Контейнери - список</a></div>
</div>

    <div class="row col-sm-12" id="my_counter">        
        <span id="txt">Контейнер №: <?php echo $platform;?>, знімків:  </span><input type="text" id="counter" value="0" disabled="true">
    </div>
    <div class="row col-sm-12">        
        <input type="button" class="btn btn-primary btn-lg col-md-6 col-md-offset-3" value="Зробити фото" id="btn_make_photo">
    </div>
    
    <div class="row">
        <form id="myform" method="post" class="col-6" enctype="multipart/form-data">            
            <div class="form-group">                         
                <input type="file" class="btn btn-success btn-lg col-md-12 col-sm-12" id="sel_files" name="file[]" style="display:none"><br>
                <input type="submit" class="btn btn-lg col-md-12 col-sm-12" id="btn_upload_photo" value="Отправить" style="display:none">                
            </div>                
            </form>
        <div class="col-md-12 col-sm-12" id="log">
        </div> 
    </div>
<span>Знімки контейнера:</span>
<hr> 
    
<div class="row">    
    <div class="col-md-12 col-sm-12" id="images">
</div>
        <!--script src="js/lightbox-plus-jquery.js"></script-->
<script src="js/jquery-ui.js"></script>
<script src="js/date.format.js"></script>

<?php
    
    
    
            
    $images = json_decode(get_images($date, $platform));    
    
    if (sizeof($images)>0){
        ?>
        <script>$("#counter").val('<?php echo sizeof($images); ?>');</script>
        <?php
        $cnt = 1;
        foreach ($images as $key => $value) {            ?>
            
        <script>$("#images").prepend('<?php echo("<a href=img/".$date."/".$platform."/".$value.">".$cnt." - ".$value."</a><br>"); ?>');</script>
        
                <?php 
                $cnt++;
        }
    }
    else{
        echo($error_text);
    }
    
    
}
 else {
     echo("Ошибка");
}
  
?>
        
    </div>
</div><!-- container -->
        


<script>
 //document.getElementById("href_images").classList.add("menu_current");
 var cur_date="";
var ttt;
var tmp_str;
var dates_array = new Array();
var msg = '';//в логах ошибок

$(document).ready(function(){

    $("#if_foto").addClass("menu_active");
    



 $('#btn_make_photo').on('click', function(){       
      document.getElementById('sel_files').click(); 
   });
   
   $('#sel_files').on('change', function(){
       if (document.getElementById("sel_files").files[0].name.length>0){
            $.each(document.getElementById("sel_files").files, function(key, value){                                
            });                        
            document.getElementById('btn_upload_photo').click();
        }
        else {
            alert("Помилка. Немає фото для завантаження");
        }
   });
                     
    
     $('#myform').submit( function(e) {        

         var fd = new FormData(this);
         fd.append("dir_upl", "img/"+'<?php echo $date; ?>'+"/"+'<?php echo $platform; ?>');           
        $.ajax({
          url: 'upload_files.php',
          type: 'POST',
          data: fd,
          retryLimit : 3,
          processData: false,
          contentType: false,
          
          beforeSend: function() {
               $('#btn_make_photo').val("Зачекайте...");
               $('#btn_make_photo').css({'background':'red'});
               $('#btn_make_photo').css({'color':'yellow'});
          },
          
          success: function (data){       
              
              $.each(JSON.parse(data), function (key, value){
                if (key=='success'){                    
                    $('#btn_make_photo').val("Файл завантажено!");
                    $('#counter').val((Number($('#counter').val()))+Number(1));
                    $('#btn_make_photo').css({'background':'#ffc107'});
                    $('#btn_make_photo').css({'color':'black'});
                    window.setTimeout(clear_info, 1500);
                    cur_date=$('#datepicker').val();                 
                }
                
                if (key=='filename'){       
                    $("#new_href").removeAttr('id');
                    let dd = '<?php echo($date."/".$platform."/");?>';
                    let sss = "<a href='img/"+dd+value+"' id='new_href'>"+$("#counter").val()+" - "+value+"</a><br>";
                    $("#images").prepend(sss);
                }
                
                if (key=='error'){
                    
                    $('#btn_make_photo').val("Файл НЕ завантажено! Спробуйте ще раз!");
                    this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            console.log('Start retry');
                            $.ajax(this);
                            console.log('Попытка №' + this.tryCount);
                            msg = 'Попытка №' + this.tryCount;
                            $('#log').append(Date()+"  ==>"+msg+"<br>");
                            return;
                        }  
            
                    $('#counter').val((Number($('#counter').val()))+Number(1));
                    $('#btn_make_photo').css({'background':'#F8D7DA'});
                    $('#btn_make_photo').css({'color':'red'});
                    window.setTimeout(clear_info, 2000);
                    cur_date=$('#datepicker').val();                    
                }                    
                
              });                            
          },
          
          error: function (jqXHR, exception) {
                
                     
                
                if (jqXHR.status === 0) {                    
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }


                $('#log').append(Date()+"  "+msg+"<br>");
                    
                                $.ajax({
                      url: 'client_log.php',
                      type: 'POST',
                      data: msg,
                      processData: false,
                      contentType: false,
                      success: function (data){
                          console.log("Повідомлення про помилку клієнта було записане на сервері: "+msg);
                          console.log(data);
                      }          
                    });
                    
                $('#btn_make_photo').val("Файл НЕ завантажено! Спробуйте ще раз!");
                $('#counter').val((Number($('#counter').val()))+Number(1));
                $('#btn_make_photo').css({'background':'#F8D7DA'});
                $('#btn_make_photo').css({'color':'red'});
                window.setTimeout(clear_info, 5000);
                cur_date=$('#datepicker').val();
                
            }          
        });
          e.preventDefault();
    });
         
   
   function clear_info(){       
       $('#btn_make_photo').val('Зробити фото');
       $('#btn_make_photo').css({'background':'#337ab7'});
       $('#btn_make_photo').css({'color':'white'});
       document.getElementById("sel_files").value = null;
       $('#dir_upl_name').val('type');
   }
   
 });
</script>


