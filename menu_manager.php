<!DOCTYPE html>

<html lang="en" >
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" charset="utf-8">
<head>
    <meta charset="UTF-8">
    <title>Фотофіксація</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/lightbox.min.css">     
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <style> 
    

    
               
       
@media screen and (max-device-width: 979px){
    
    #logo{
         width: 50px;
     }
    
     
     
     #href_platforms {
         heigth:15px;
     }
     
     #platforms span {
         
     }
     
      #btn_make_photo, #sel_files {
        height: 400px;
        font-size: 50px;
        border-radius: 25px;
     }
     
     
     
     h1 {
         color: #065D08;
         margin-top:0px; 
         font-size: 50px;
     }
     
     .menu_current{
         /*background:  #f7ecb5;*/
         background:  lightgoldenrodyellow;
     }
     
     #form_search_container{
         margin-top: 5px;
     }
  }

@media only screen and
  (min-device-width: 1368px)
  {
    
/*     .mymenu #href_platforms {
         font-size: 30px!important;         
         height: 100px!important;
     }*/
     
      #btn_make_photo, #sel_files {
        height: 400px;
        font-size: 50px;
        border-radius: 25px;
     }
     
     #logo{
         width: 150px;
     }
     
     h1 {
         color: #065D08;
         margin-top:0px; 
         font-size: 50px;
     }
     
     .menu_current{
         /*background:  #f7ecb5;*/
         background:  lightgoldenrodyellow;
     }
     
     #form_search_container{
         margin-top: 5px;
     }
  }  
            
    </style>
</head>

<body>

<div id="controls">
    <div align=right>
        <a class="close" title="Закрыть" onclick="document.getElementById('controls').style.display='none';">X</a>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12" align="center">
            <img src="logo.png" id="logo" />
        </div>
    </div>
   
    <div class="row mymenu col-sm-12">                               
        <div  class="btn btn-success btn-lg col-sm-2 col-sm-offset-5">            
            <a href="index.php" id="href_platforms" style="color:white;">Фотограф</a>   
        </div>        
              </div> 
    <hr>