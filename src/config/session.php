<?php

 function validSession(){
    $user = $_SESSION['user'];
     if(!isset($user)){
         header('Location: login_controller.php');
         exit();
     }
 }

 ?>