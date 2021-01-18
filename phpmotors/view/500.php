<?php 
    //setup page
    try{
        include_once('../modules/template-init.php');
        init('Server Error', 'view/500-body.php','modules/template-core.php');    
    }
    catch(Exception $e){
        echo "Message"; 
        echo $e;
        exit;
    };
?>


