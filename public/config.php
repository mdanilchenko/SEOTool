<?php
session_start();
define("MAIN_DOMAIN","/home/runaway/public_html/shortlink/seotool/public/");

function autoloader($class) {
    if(file_exists($class.'.php')){
        require($class.'.php');
    }else if(file_exists('../vendor/'.$class.'.php')){
        require('../vendor/'.$class.'.php');
    }else if(file_exists('../vendor/insights/'.$class.'.php')){
        require('../vendor/insights/'.$class.'.php');
    }else if(file_exists('../vendor/pdfbuilder/'.$class.'.php')){
        require('../vendor/pdfbuilder/'.$class.'.php');
    }
}
spl_autoload_register('autoloader');


?>