<?php
require('vendor/autoload.php');
use Aws\Common\Aws;

class Storage {
  const TABLE_NAME = 'scores';

  public function __construct() {
    $aws = Aws::factory('aws.json');
    $this->client = $aws->get('DynamoDb');
    $this->ensureTableExists();
  }

  public function ensureTableExists() {
    $response = $this->client->listTables();
    if (!in_array(self::TABLE_NAME, $response['TableNames'])) {
      $this->createTable();
    }
  }

  public function createTable() {
    $this->client->createTable(array(
      'TableName' => self::TABLE_NAME,
      'AttributeDefinitions' => array(
        array(
          'AttributeName' => 'id',
          'AttributeType' => 'N'
        )
      ),
      'KeySchema' => array(
        array(
          'AttributeName' => 'id',
          'KeyType' => 'HASH'
        )
      ),
      'ProvisionedThroughput' => array(
        'ReadCapacityUnits' => 1,
        'WriteCapacityUnits' => 1
      )
    ));
    $this->client->waitUntil('TableExists', array(
      'TableName' => self::TABLE_NAME
    ));
  }

  public function populate($score) {
    $this->client->putItem(array(
      'TableName' => self::TABLE_NAME,
      'Item' => array(
        'id' => array('N' => '1'),
        'score' => array('N' => strval($score))
      )
    ));
  }

  public function getScore() {
    $response = $this->client->getItem(array(
      'ConsistentRead' => true,
      'TableName' => self::TABLE_NAME,
      'Key' => array(
        'id' => array('N' => '1')
      )
    ));
    return $response['Item']['score']['N'];
  }
}
?>
