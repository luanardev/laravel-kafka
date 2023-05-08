# Laravel Kafak

## Installation

Run the command

```console
composer require luanardev/laravel-kafka
```

Publish configuration file

```console
php artisan vendor:publish --tag=laravel-kafka-config
```

## Configuration

Open `queue.php` in the config directory.

Set `kafka` connection after `redis`

```html
'connections' => [
	.........
	
	'kafka' => [
		'driver' => 'kafka',
		'brokers' => env('KAFKA_BROKERS'),
		'queue' => env('KAFKA_QUEUE','default'),
		'subscribe' => env('KAFKA_SUBSCRIBE','default'),
		'consumer_group_id' => env('KAFKA_CONSUMER_GROUP_ID','group'),
		'sasl_username' => env('KAFKA_SASL_USERNAME'),
		'sasl_password' => env('KAFKA_SASL_PASSWORD'),
		'sasl_mechanisms' => env('KAFKA_SASL_MECHANISMS', 'PLAIN'),
		'security_protocol' => env('KAFKA_SECURITY_PROTOCOL', 'SASL_SSL'),
	],
],
```
### Environment Configuration

#### Open `.env` file at the root of the directory

Add kafka connection details
````
KAFKA_QUEUE=default
KAFKA_SUBSCRIBE=default
KAFKA_BROKERS=localhost:9092
KAFKA_SASL_USERNAME=your username
KAFKA_SASL_PASSWORD=your password
KAFKA_CONSUMER_GROUP_ID=group
````
#### Set QUEUE_CONNECTION to kafka

````
QUEUE_CONNECTION=kafka
````
