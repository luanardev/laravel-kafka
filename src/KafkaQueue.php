<?php

namespace Luanardev\LaravelKafka;

use Carbon\Exceptions\Exception;
use Illuminate\Queue\Queue;
use Illuminate\Contracts\Queue\Queue as QueueContract;
use Junges\Kafka\Config\Sasl;
use Junges\Kafka\Facades\Kafka;

class KafkaQueue extends Queue implements QueueContract
{
    protected mixed $producer;
    protected mixed $consumer;
    protected array $config;

    public function __construct(array $config)
    {
       $this->config = $config;
    }

    public function push($job, $data = '', $queue = null)
    {
        $brokers = $this->config['brokers'];

        if(empty($queue)){
            $queue = $this->config['queue'];
        }

        $saslConfig = new Sasl(
            $this->config['sasl_username'],
            $this->config['sasl_password'],
            $this->config['sasl_mechanisms'],
            $this->config['security_protocol']
        );

        try{
            $producer = Kafka::publishOn($queue, $brokers)->withSasl($saslConfig);
            $producer->withBodyKey('job', serialize($job) );
            $producer->send();
        }catch (\Exception $ex){
            var_dump($ex->getMessage());
        }

    }

    public function pop($queue = null)
    {
        $brokers = $this->config['brokers'];
        $consumerGroupId= $this->config['consumer_group_id'];
        $subscription = explode(",", $this->config['subscription']);

        $topics = array_unique(array_merge($subscription, [$queue]));

        $saslConfig = new Sasl(
            $this->config['sasl_username'],
            $this->config['sasl_password'],
            $this->config['sasl_mechanisms'],
            $this->config['security_protocol']
        );

        $consumer = Kafka::createConsumer()
            ->subscribe($topics)
            ->withBrokers($brokers)
            ->withConsumerGroupId($consumerGroupId)
            ->withSasl($saslConfig)
            ->withHandler(new KafkaHandler)
            ->build();
        try {
            $consumer->consume();
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function size($queue = null)
    {
        // TODO: Implement size() method.
    }

    public function pushRaw($payload, $queue = null, array $options = [])
    {
        // TODO: Implement pushRaw() method.
    }

    public function later($delay, $job, $data = '', $queue = null)
    {
        // TODO: Implement later() method.
    }
}
