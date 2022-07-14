<!DOCTYPE html>

<html lang="en" >
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" charset="utf-8">
<head>
    <meta charset="UTF-8">
    <title>Фотофіксація</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">    
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/style.css">
    <style> 
   
        .menu_active{
/*            border: 1px solid  #007800;
            background:   #E2E100;*/
            text-decoration: underline;
        }
        
        
        
        #spr, #if_foto, #if_mgr{
/*            */
        }
        
        #spr:hover, #if_foto:hover, #if_mgr:hover {
            text-decoration: none;
        }
        
        #show_list{
            margin-top:5px;            
        }
        
        #new_href{
            color: darkgreen;
            background:  #f7e1b5;
        }
        
@media screen and (max-device-width: 979px){
    
    #logo{
         width: 50px;
     }
     
     #href_platforms{
         font-size:20px!important;         
     }
    
    #btn_make_photo, #sel_files {
        height: 100px;
        width: 80%;
        font-size: 25px;
        font-weight: bold;
        border-radius: 20px;
        margin-left: 10%;
     }
     
     
     
     h1 {
         color: #065D08;
         margin-top:0px; 
         font-size: 50px;
     }
     
     #images a{
         font-size:20px!important;         
line-height: 35px;         
     }
     
     a {
         font-size: 35px!important;
         height: 70px!important;
     }
          
     
     .mymenu a{
         font-size: 60px!important;
         height: 100px!important;
     }
     
     .menu_current{
         /*background:  #f7ecb5;*/
         background:  lightgoldenrodyellow;
     }
     
     
     
     .link_platform {         
         color: green;
         font-size: 25px!important;
         
     }
     
     .link_platform div{
         background:  lightgoldenrodyellow!important;
     }
     
     #counter{
         width: 40px;
         font-size: 20px;
         font-weight: bold;
         border: none;
     }
     
    .btn-numbers{
         height: 80px!important;
         width: 80px!important;
         text-align: center;         
         color: black;
         font-size: 20px;
         padding-top: 30px;
margin-bottom: 2px;         
         font-weight: bold;
         
     }
     
     
     #show_adding {         
         font-size: 20px;
         margin-top: 5px;
     }
     
     form {
         padding-left: 2%;
         padding-right: 2%;
     }
     
     #form_search_container{
         margin-top: 5px;
     }
     
     #container_number{
     
     }
     
     #btn_search_container{
         
     }
}




@media screen and (min-device-width: 980px){
    
    #counter{
         width: 40px;
         font-size: 20px;
         border: none;
     }
    
    #images a{
         font-size: 20px!important;         
     }
    
    #show_list a{
            font-size: 15px!important;
        }
        
    #href_platforms{
         font-size:18px!important;
         color: black!important;
     }
    
      #btn_make_photo, #sel_files {
        height: 100px;
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
     
     a {
         font-size: 35px!important;
         height: 70px!important;
     }
     
     
     
     .mymenu a{
         font-size: 60px!important;
         height: 100px!important;
     }
     
     .menu_current{
         /*background:  #f7ecb5;*/
         background:  lightgoldenrodyellow;
     }
     
     
     
     .link_platform {
         font-size: 20px!important;         
     }
     
     .link_platform div:hover{
         background:  lightgoldenrodyellow!important;
     }
     
     
     
    .btn-numbers{
         height: 50px!important;
         width: 50px!important;
         text-align: center;         
         color: black;
         font-size: 20px;
         padding-top: 10px;
         margin-right: 5px;
         margin-bottom: 5px;
         
     }
         
     #show_adding {         
         font-size: 20px;
         margin-top: 5px;
     }
     
     #form_search_container{
         margin-top: 5px;
     }
     
     #container_number{
     
     }
     
     #btn_search_container{
         
     }
}

.mymenu a {
            font-size: 15px!important;
            font-weight: bold;
            padding: 2px;
            color: #007800;
        }

    </style>    
</head>

<body>

<div class="container">    
    
    <div class="row">
        <div class="col-md-12 col-sm-12" align="center">
            <img src="logo.png" id="logo">
        </div>
    </div>
   
    <div class="row mymenu col-sm-12">        
        <a href="spr.php" id="spr">Довідка</a>
        <a href="index.php" id="if_foto">Фотограф</a>
        <a href="view_search_platform.php" id="if_mgr">Менеджер</a>  
        
        
    </div>
    
    
    <script src="js/jquery.min.js"></script>
    
