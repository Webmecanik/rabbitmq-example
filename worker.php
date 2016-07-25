<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$url = parse_url(getenv('CLOUDAMQP_URL'));

$connection = new AMQPStreamConnection(
          $url['host'], //host - CloudAMQP_URL
          5672,         //port - port number of the service, 5672 is the default
          $url['user'], //user - username to connect to server
          $url['pass'], //password - password to connecto to the server
          substr($url['path'], 1) //vhost
);

$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function($msg){
  echo " [x] Received ", $msg->body, "\n";
  sleep(1);
  echo " [x] Done", "\n";
  $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

?>
