<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$url = parse_url(getenv('CLOUDAMQP_URL'));

$connection = new AMQPStreamConnection(
          $url['host'], //host - CloudAMQP_URL
          5672,         //port - port number of the service, 5672 is the default
          $url['user'], //user - username to connect to server
          $url['pass'], //password - password to connecto to the server
          substr($url['path'], 1) //vhost
);
$channel = $connection->channel();

$data = $argv[1];
if(empty($data)) $data = "Hello World!";
$msg = new AMQPMessage($data, array('delivery_mode' => 2));
$channel->basic_publish($msg, '', 'task_queue');
echo " [x] Sent ", $data, "\n";

$channel->close();
$connection->close();

?>
