<?php
require_once("storage.php");
class StorageTest extends PHPUnit_Framework_TestCase {
  public function test() {
    $storage = new Storage();
    $storage->populate(1234);
    $this->assertEquals($storage->getScore(), 1234);
  }
}
?>
