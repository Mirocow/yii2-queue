# Non blocking queue manager for Yii 2.0. It supports queues based on DB, Redis, File etc

[![Latest Stable Version](https://poser.pugx.org/mirocow/yii2-queue/v/stable)](https://packagist.org/packages/mirocow/yii2-queue) [![Latest Unstable Version](https://poser.pugx.org/mirocow/yii2-queue/v/unstable)](https://packagist.org/packages/mirocow/yii2-queue) [![Total Downloads](https://poser.pugx.org/mirocow/yii2-queue/downloads)](https://packagist.org/packages/mirocow/yii2-queue) [![License](https://poser.pugx.org/mirocow/yii2-queue/license)](https://packagist.org/packages/mirocow/yii2-queue)
[![Join the chat at https://gitter.im/Mirocow/yii2-queue](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/Mirocow/yii2-queue?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FMirocow%2Fyii2-queue.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2FMirocow%2Fyii2-queue?ref=badge_shield)
[![Maintainability](https://api.codeclimate.com/v1/badges/c7bbfa3f4412490c877c/maintainability)](https://codeclimate.com/github/Mirocow/yii2-queue/maintainability)

```
----------------------- YII2-QUEUE -----------------------------
Yii2-queue version: 0.0.3          PHP version:7.0.27-0+deb9u1
Process ID: 6930
Channels: 1
Workers: 4
Default queue name: default-queue
----------------------------------------------------------------
Press Ctrl+C to stop. Start success.
Child process starting with PID 6880 ...
Child process 6880 are working...
Child 6880 done
Child process starting with PID 6882 ...
Child process 6882 are working...
Run worker [web] with action [ProductCreate] from common\models\essence\Product
...
```

##### Install:

`php composer.phar require mirocow/yii2-queue "^1.0.0"`

##### Config:

```php
'controllerMap' => [
    'queue' => [
        'class' => 'mirocow\queue\controllers\QueueController',
    ],
],

'components' => [

    'queue' => [
        'class' => 'mirocow\queue\components\QueueComponent',
        'queueName' => 'default-queue',
        'workers' => [
            'notification' => [
                'class' => 'mirocow\queue\components\WorkerComponent',
                'action' => [
                    'class' => 'mirocow\queue\controllers\NotificationController',
                ]
            ],
            ...
        ],
        'channels' => [
            'default' => [
                'class' => 'mirocow\queue\components\ChannelComponent',
                    'driver' => [
                        'class' => 'mirocow\queue\drivers\MysqlConnection',
                        'connection' => 'db',
                    ]
                ]
            ],
            ...
        ]
    ]
]
```

Before use apply migrations for using Mysql driver:
```php
./yii migrate/up --migrationPath=@vendor/mirocow/yii2-queue/migrations
```

### Usage:

#### Worker class:

```php
namespace \console\controllers;

class NotificationController extends Controller
{
    public function actionSayHello($say)
    {
        \Yii::info($say);
    }
}
```

#### Push message to queue:

```php
Yii::$app->queue->getChannel('default')->push(
    new MessageModel([
        'worker' => 'notification',
        'method' => 'actionSayHello',
        'arguments' => [
            'say' => 'hello!'
        ]
    ])
);
```

#### Run queue worker daemon (console app):

```bash
$ php ./yii queue/run --pid-file=/tmp/queue.pid
```        

##### Test:

```bash
$ ./vendor/bin/codecept -c vendor/mirocow/yii2-queue run unit

XDebug could not open the remote debug file '/var/log/php7-fpm/php-fpm-xdebug-remote'.
Codeception PHP Testing Framework v2.4.3
Powered by PHPUnit 6.5.9 by Sebastian Bergmann and contributors.

Unit Tests (6) ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
- ActionsTest: Run job as class methodWorker process starting with PID 23383 ...
Process 23383 are working...
Process 23383 finished
✔ ActionsTest: Run job as class method (0.15s)
- ActionsTest: Run job class static methodWorker process starting with PID 23383 ...
Process 23383 are working...
Process 23383 finished
✔ ActionsTest: Run job class static method (0.04s)
- ActionsTest: Run job as action of controllerWorker process starting with PID 23383 ...
Process 23383 are working...
Process 23383 finished
✔ ActionsTest: Run job as action of controller (0.05s)
- ActionsTest: Run job as static methodWorker process starting with PID 23383 ...
Process 23383 are working...
Process 23383 finished
✔ ActionsTest: Run job as static method (0.04s)
- FileTest: Job as class methodWorker process starting with PID 23383 ...
Process 23383 are working...
Process 23383 finished
✔ FileTest: Job as class method (0.03s)
- RedisTest: Job as classWorker process starting with PID 23383 ...
Process 23383 are working...
Process 23383 finished
✔ RedisTest: Job as class (0.03s)
-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------


Time: 1.34 seconds, Memory: 16.00MB
```

# License

[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2FMirocow%2Fyii2-queue.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2FMirocow%2Fyii2-queue?ref=badge_large)
