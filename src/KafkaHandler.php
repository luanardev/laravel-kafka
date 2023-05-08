<?php

namespace Luanardev\LaravelKafka;

use Junges\Kafka\Contracts\KafkaConsumerMessage;

class KafkaHandler
{

    public function __invoke(KafkaConsumerMessage $message): void
    {
        $messageBody = $message->getBody();
        $job = unserialize($messageBody['job']);
        $job->handle();
    }
}
