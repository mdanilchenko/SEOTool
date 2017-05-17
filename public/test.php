<?php
ini_set('display_errors','on');
require 'config.php';
$insights = new InsightsAPI('https://vk.com');
$insights->run();
$insights->toPDF();
print 'Done';
//print_r($insights->getResults());
