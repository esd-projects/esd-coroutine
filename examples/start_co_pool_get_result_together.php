<?php

use ESD\Coroutine\Co;
use ESD\Coroutine\CoPoolFactory;
use ESD\Coroutine\Pool\Runnable;

require __DIR__ . '/../vendor/autoload.php';
Co::enableCo();
enableRuntimeCoroutine();
/**
 * 用连接池执行任务，统一获取结果
 * Class Task
 */
class Task extends Runnable
{
    private $max;

    public function __construct($max)
    {
        parent::__construct(true);
        $this->max = $max;
    }

    function run()
    {
        sleep($this->max);
        print_r("[" . Co::getCid() . "]\tRunnable执行完毕\n");
        return $this->max;
    }
}

goWithContext(function () {
    $pool = CoPoolFactory::createCoPool("Executor-1", 5, 10, 1);
    $tasks = [];
    for ($i = 0; $i < 10; $i++) {
        $task = new Task(2);
        $tasks[] = $task;
        $pool->execute($task);
    }
    foreach ($tasks as $task) {
        print_r("结果->" . $task->getResult() . "\n");
    }
});
