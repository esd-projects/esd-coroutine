<?php

use ESD\Coroutine\Co;
use ESD\Coroutine\Pool\Runnable;

require __DIR__ . '/../vendor/autoload.php';
Co::enableCo();
enableRuntimeCoroutine();
/**
 * 执行任务
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
    $tasks = [];
    for ($i = 0; $i < 10; $i++) {
        $task = new Task(2);
        $tasks[] = $task;
        $task->justRun();
    }
    foreach ($tasks as $task) {
        print_r("结果->" . $task->getResult() . "\n");
    }
});
