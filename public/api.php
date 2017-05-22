<?php
require('config.php');
ini_set("display_errors",'on');
if(isset($_REQUEST['action'])) {
    if (isset($_SESSION['id']) and is_numeric($_SESSION['id'])) {
        if (($_REQUEST['action'] == 'get_report') and isset($_REQUEST['url'])) {
            if (!filter_var($_REQUEST['url'], FILTER_VALIDATE_URL) === false) {
                $insights = new InsightsAPI($_REQUEST['url']);
                $insights->run();
                $results = $insights->toObject();
                $pdf = $insights->toPDF();
                print json_encode(array('rates' => $results,'pdf'=>'reporter.php?out='.urlencode($pdf)));
            } else {
                print json_encode(array('error' => "Invalid URL Entered"));
            }
            exit;
        }

    } else {
        if (($_REQUEST['action'] == 'login') and isset($_REQUEST['login']) and isset($_REQUEST['pass'])) {
            $user = DAOMethods::getUserByEmail($_REQUEST['login']);
            if(!is_null($user) and ($user->getPass()==$_REQUEST['pass'])){
                $_SESSION['id']=$user->getId();
                $_SESSION['email']=$user->getEmail();
                print json_encode(array('status'=>0));
                exit;
            }else{
                print json_encode(array('error'=>'Invalid login or password'));
            }
        }
        if (($_REQUEST['action'] == 'register') and isset($_REQUEST['email']) and isset($_REQUEST['pass']) and isset($_REQUEST['pass2'])) {
            if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL) === false) {
                if(mb_strlen($_REQUEST['pass'])>=5){
                        if($_REQUEST['pass']==$_REQUEST['pass2']){
                            $user = new User(null,$_REQUEST['email'],$_REQUEST['pass'],0,date('Y-m-d'),time(),$_SERVER['REMOTE_ADDR']);
                            if(DAOMethods::addUser($user)){
                                $_SESSION['id']=$user->getId();
                                $_SESSION['email']=$user->getEmail();
                                print json_encode(array('status'=>0));
                                exit;
                            }else{
                                print json_encode(array('error'=>'Email already in use.'));
                            }
                        }else{
                            print json_encode(array('error'=>'Passwords not match'));
                        }
                }else{
                    print json_encode(array('error'=>'Password should be 5 or more chars long'));
                }
            }else{
                print json_encode(array('error'=>'Invalid Email'));
            }

        }
    }
}

?>