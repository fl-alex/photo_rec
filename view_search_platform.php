<?php 
include_once 'menu.php';
include_once 'functions.php';

file_put_contents(__DIR__ . '/all_logs.log', date('[Y-m-d H:i:s] '). getIp()." - view_search_platfom.php". PHP_EOL, FILE_APPEND | LOCK_EX);

?>
<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-offset-3 text-center">
        <form class="form-inline" id="form_search_container" action="view_search_platform.php" method="POST">  
          <div class="form-group mx-sm-3 mb-2 form-group-lg">            
            <input type="text" name="container_number" class="form-control" id="container_number" placeholder="Номер контейнера">
          </div>
          <button type="submit" class="btn btn-lg btn-warning" id="btn_search_container">Знайти</button>
        </form>
    </div>
</div>
<script>
$( document ).ready(function(){
    $("#if_mgr").addClass("menu_active");
    $("#if_foto").removeClass("menu_active");
});


</script>

<?php

if (isset($_REQUEST['container_number'])){
    newscan($_REQUEST['container_number']);
}

function newscan ($container_number){ 
    $info=0;
    foreach (new DirectoryIterator("img") as $folder_date) {//---для каждой даты
        if($folder_date->isDot()) {
            continue;
        }  
        else {            
                foreach (new DirectoryIterator("img/".$folder_date) as $folder_platform) {// ----- для каждой платформы
                    if($folder_platform->isDot()) {
                        continue;
                    }  
                    else {
                        
                        if ($folder_platform==$container_number){                            
                            $info = 1;
                            $images = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("img/".$folder_date."/".$folder_platform));
                            echo("<div>\n<hr>\n<span>Контейнер №: <strong>".$folder_platform."</strong>. Дата съемки: <strong>".$folder_date."</strong></span>\n</div>\n<hr>\n");
                            
                            foreach($images as $curr_image => $images){// ----для каждого файла
                                
                                 if (is_dir($curr_image)) {         
                                 }
                                 else {                                     
                                     print_r ("<a href=".$curr_image."><img src=".$curr_image." style='height:150px;margin-bottom:5px;'/></a>&nbsp;");
                                     $info=2;
                                 }    
                            }
                            
                        }
                        
                        else{  
                            
                        }
                    }                        
                }
        }        
    }            
    if ($info===0) {
        echo ("Контейнер с таким номером не найден!");
    }
    if ($info===1) {
        echo ("Снимков по данному контейнеру еще нет!");
    }
}
?>