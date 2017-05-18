<?php
require('config.php');
if(isset($_REQUEST['action'])){
    if(($_REQUEST['action']=='get_report') and isset($_REQUEST['url'])){
        if (!filter_var($_REQUEST['url'], FILTER_VALIDATE_URL) === false) {
            $insights = new InsightsAPI($_REQUEST['url']);
            $insights->run();
            $results = $insights->toObject();
            print json_encode(array('rates'=>$results));
        }else{
            print json_encode(array('error'=>"Invalid URL Entered"));
        }
        exit;
    }
}


if(isset($_SESSION['id']) and is_numeric($_SESSION['id'])){

}else{
    print json_encode(array('error'=>"Для получениея доступа к функционалу необходимо зарегистрироваться"));
}

?>