<?php

// ==========================================================================
// ========== Получение массива файлов по дате и контейнеру =================
// ==========================================================================
function get_images($date, $platform){
 $file_list=[]; // первичный массив
 $newfilelist=[]; // отсортированные по дате
 $iterator = new DirectoryIterator("img/".$date."/".$platform);
 
        foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile()) {         
                // ассоц. массив: дата файла - файл 
                $file_list[$fileinfo->getMTime()][] = $fileinfo->getFilename();
            }
        }
        ksort($file_list); // сортировка ассоц. массива
        foreach($file_list as $key => $value) {            
            array_push($newfilelist, $value[0]); // выходной массив
        }                
        return json_encode($newfilelist);
                
}

// ==========================================================================
// ========== Получение массива контейнеров по дате =========================
// ==========================================================================
function get_platform($date){   

$path = "img/".$date;
$platform_list=[];
    
    // ----- для каждой папки контейнера
    foreach (new DirectoryIterator($path) as $folder_platform) {
                    if($folder_platform->isDot()) {
                        continue;
                    }  
                    else {
                        $curr_platform = $folder_platform->getFilename();
                        array_push($platform_list, $curr_platform);
                    }    
    }    
        return json_encode($platform_list);    
}

// ==========================================================================
// == Создание, если не существуют, папки текущей даты и контейнера =========
// ==========================================================================

if (isset($_REQUEST['new_platform'])){        
    make();
}

// ==========================================================================
// == Создание, если не существуют, папки текущей даты и контейнера =========
// ==========================================================================

function make () {
    
    $new_platform = $_REQUEST['new_platform'];    
        $date = date('Y.m.d');
        file_put_contents(__DIR__ . '/all_logs.log', date('[Y-m-d H:i:s] '). 
                getIp()." - make_platfom.php"." - ".$new_platform. PHP_EOL, FILE_APPEND | LOCK_EX);
        
        if (!file_exists("img/".$date)) {
            mkdir('img/'.$date);    
            mkdir('img/'.$date."/".$new_platform);            
            echo (json_encode("Платформа ".$new_platform." создана!"));
        }
        else {
            if (!file_exists("img/".$date."/".$new_platform)) {
                mkdir('img/'.$date."/".$new_platform);
                echo (json_encode("Платформа ".$new_platform." создана!"));
            }
            else{
                echo (json_encode("ERROR! Платформа уже существует!"));
            }
        }

}

function getIp() {
      $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
      ];
      foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
          $ip = trim(end(explode(',', $_SERVER[$key])));
          if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
          }
        }
      }
    }
    
    
//    function get_subfolders($path){        
//     $subfolders_list=[];
//     $files_list=[];            
//    foreach (new DirectoryIterator($path) as $subfolder) {
//                    if($subfolder->isDot()) {
//                        continue;
//                    }  
//                    else {
//                        if ($subfolder->isFile()){
//                            $curr_file = $subfolder->getPathname();
//                            array_push($files_list, $curr_file);
//                        }
//                        else {
//                            $curr_folder = $subfolder->getFilename();
//                            array_push($subfolders_list, $curr_folder);
//                        }
//                        
//                    }    
//    }    
//        return json_encode(array(folders=>$subfolders_list, files=>$files_list));                   
//    }
    
 
    
