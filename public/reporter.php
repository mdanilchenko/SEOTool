<?php
if(isset($_GET['out']) and !empty($_GET['out'])){
    if(file_exists('../pdfreports/'.$_GET['out'])){
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="url_report.'.date('YmdH').'.pdf"');
        readfile('../pdfreports/'.$_GET['out']);
    }
}