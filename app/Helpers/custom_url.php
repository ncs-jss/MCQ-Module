<?php
function custom_url($arg){
    if(substr($arg, 0, 1 ) != "/")
        $arg = "/".$arg;
    return "http://localhost/laravel/test2/Proj_mx02/public/".$arg;
}
?>