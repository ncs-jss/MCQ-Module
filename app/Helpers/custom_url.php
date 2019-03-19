<?php
function custom_url($arg)
{
    if (substr($arg, 0, 1) != "/") {
        $arg = "/".$arg;
    }
    return "http://localhost/Proj_mx02/public/".$arg;
}
