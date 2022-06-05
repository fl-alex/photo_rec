<?php

include_once 'menu.php';
include_once 'functions.php';
$myip = getIp();
echo($myip);
$root_path="../leiko/photo";
if (isset($_REQUEST['dir'])){    
        $path = $root_path."/".$subfolder."/".$_REQUEST['dir'];        
        $message="| ".getIp()." | getFoto | ".$path." |";        
        $subfolder=$subfolder."/".$_REQUEST['dir'];                    
        file_put_contents($mypath = __DIR__ . '/all_logs.log', date('[Y-m-d H:i:s] ').$message. PHP_EOL, FILE_APPEND | LOCK_EX);
}

else { 
    $path=$root_path;
    $message="| ".$myip." | getFoto | ".$path." |";
        file_put_contents($mypath = __DIR__ . '/all_logs.log', date('[Y-m-d H:i:s] ').$message. PHP_EOL, FILE_APPEND | LOCK_EX);
}
   
$result = json_decode(get_subfolders($path));

foreach ($result as $key => $value) {              
    if (($key=="my_folders")&&(sizeof($value)>0)){        
        foreach ($value as $k => $v) {            
            if (strlen($subfolder)==0){
                echo("<a href='view_all_photos.php?dir=".$v."'>".$v."</a><br>");
            }
            else {
                echo("<a href='view_all_photos.php?dir=".$subfolder."/".$v."'>".$v."</a><br>");
            }            
        }
    }
        
    if (($key=="files")&&(sizeof($value)>0)){        
        foreach ($value as $k => $v) {                        
                echo("<a href='".$v."'><img src='".$v."' style='height:200px;margin:2px;' ></a>");            
        }
    }
    
}

function get_subfolders($path){        
     $subfolders_list=[];
     $files_list=[];            
    foreach (new DirectoryIterator($path) as $subfolder) {
                    if($subfolder->isDot()) {
                        continue;
                    }  
                    else {
                        if ($subfolder->isFile()){
                            $curr_file = $subfolder->getPathname();
                            array_push($files_list, $curr_file);
                        }
                        else {
                            $curr_folder = $subfolder->getFilename();
                            array_push($subfolders_list, $curr_folder);
                        }
                        
                    }    
    }    
        return json_encode(array('my_folders'=>$subfolders_list, 'files'=>$files_list));                   
    }

?>




