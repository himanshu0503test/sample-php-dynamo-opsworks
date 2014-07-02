<?php
require_once("storage.php");
$storage = new Storage();
$storage->populate(1234);
$score = $storage->getScore();
echo 'Hello world, ' . $score . '!';
?>
