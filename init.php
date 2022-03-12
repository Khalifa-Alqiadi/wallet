<?php
    $row = `row p-2 border d-flex justify-content-between col-sm-8`;
    include 'dashboard/database.php';
    $db = new Database();
    $tepl    = 'include/templates/'; 
    $css     = 'layout/css/'; 
    $js      = 'layout/js/';  
    $func    = 'include/functions/'; 


    include $func . 'function.php';
    include $tepl . 'header.php';
    include $tepl . 'navbar.php';


    
    
 