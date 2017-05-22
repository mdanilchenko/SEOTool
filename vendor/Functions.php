<?php

class Functions
{
    public static function formOrderRequest($form,$email){
        $output=array();
        foreach($form as $key=>$value){
            if($key!='action'){
                $output[]=$key.":".$value;
            }
        }
        return "Email: ".$email."\r\n".implode("\r\n",$output);
    }
    public static function sendOrderMain($to,$title,$text){
        mail ( $to , $title , $text);
    }
}