<?php

namespace App\Http\Controllers;

use http\Env\Request;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Faker\Factory;
use App\Providers\AppServiceProvider;

class MainController extends Controller
{
    public function index()
    {
        echo 'Index Page';
    }

    public function producer()
    {
        $queue = "queue1";
        $queue2 = "queue2";
        $exchange = "exchange1";
        $exchange2 = 'exchange2';
        $connection = $this->getConnForLocal();

        $channel = $connection->channel();
//        $channel->queue_declare($queue, false, true, false, false);
//        $channel->queue_declare($queue2, false, true, false, false);

        $channel->exchange_declare($exchange, 'direct', false, true, false);

//        $channel->queue_bind($queue, $exchange);
//        $channel->queue_bind($queue2, $exchange);

        $faker = Factory::create();
        $limit = 5;
        $iteration = 0;

        while ($iteration < $limit) {

            $messageBody = json_encode([
                'name' => $faker->name,
                'email' => $faker->email,
                'address' => $faker->address,
                'subscribed' => true,
            ]);

            $messsage = new AMQPMessage($messageBody, [
                'content_type' => 'application/json',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]);

            $channel->basic_publish($messsage, $exchange, $queue2);

            $iteration++;
        }

        echo 'Finished publishing the exchange '. $exchange;

        $channel->close();
        $connection->close();
        die;
    }

    public function consumer($queue = null)
    {
        //dump($queue);die;
        //$queue = "queue1";
        //$queue2 = "queue2";
        $exchange = "exchange1";
        $exchange2 = 'exchange2';
        $consumerTag = 'local.laravel.consumer';

        $connection = $this->getConnForLocal();

        $channel = $connection->channel();

        $channel->queue_declare($queue, false, true, false, false);

        $channel->exchange_declare($exchange2, 'fanout', false, true, false);
        $channel->queue_bind($queue, $exchange2);

        $channel->basic_consume($queue, '', false, false, false, false, [$this, 'process_message']);

        register_shutdown_function([$this, 'shutdown'], $channel, $connection);

        // Loop as long as the channel has callbacks registered
        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    public function consumerBind($queue,$exchange)
    {
        //$queue = 'queue1';
        //$exchange = 'exchange';
        $connection = $this->getConnForLocal();
        $channel = $connection->channel();

        $channel->queue_declare($queue, false, true, false, false);
//        $channel->exchange_declare($exchange, 'fanout', false, true, false);
        $channel->queue_bind($queue, $exchange, $queue);
        $this->shutdown($channel, $connection);
        dump('DONE'); die;
    }

    public function consumerUnBind($queue)
    {
        //$queue = 'queue1';
        $exchange = 'exchange1';
        $connection = $this->getConnForLocal();
        $channel = $connection->channel();

        //$channel->queue_declare($queue, false, true, false, false);
        //$channel->exchange_declare($exchange, 'fanout', false, true, false);
        $channel->queue_unbind($queue, $exchange);
        $this->shutdown($channel, $connection);
        dump('DONE'); die;
    }

    public function process_message(AMQPMessage $message)
    {
        $messageBody = json_decode($message->body);
        $email = $messageBody->email;
        $storagePath = storage_path();
        file_put_contents($storagePath."/subscribers/".$email.".json", $message->body);

        $message->delivery_info['channel']->basic_ack($message->delivery_info['delivery_tag']);
    }

    public function shutdown(AMQPChannel $channel, AbstractConnection $connection)
    {
        $channel->close();
        $connection->close();
    }

    public function getConnForLocal()
    {
        $host = "localhost";
        $port = 5672;
        $user = "guest";
        $pass = "guest";
        $vhost = "/";
        $connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);

        return $connection;
    }

    public function getConnForRemote()
    {
        $host = "barnacle-01.rmq.cloudamqp.com";
        $port = 5672;
        $user = "jamakpdk";
        $pass = "mk0BXyjsK1wvHTDlGP5-BJT78olhKXZV";
        $vhost = "jamakpdk";
        $connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);

        return $connection;
    }

}
