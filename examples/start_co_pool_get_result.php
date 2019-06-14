<?php

use ESD\Coroutine\Co;
use ESD\Coroutine\CoPoolFactory;
use ESD\Coroutine\Pool\Runnable;

require __DIR__ . '/../vendor/autoload.php';
Co::enableCo();
enableRuntimeCoroutine();
/**
 * 用连接池执行任务并获取结果
 * Class Task
 */

goWithContext(function () {
    $pool = CoPoolFactory::createCoPool("Executor-1", 5, 10, 1);
    $tasks = [];
    for ($i = 0; $i < 10; $i++) {
        $task = new Runnable(function () {
            sleep(2);
            print_r("[" . Co::getCid() . "]\tRunnable执行完毕\n");
            return 2;
        });
        $tasks[] = $task;
        $pool->execute($task);
    }
});
