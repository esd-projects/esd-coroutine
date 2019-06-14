<?php
/**
 * Created by PhpStorm.
 * User: administrato
 * Date: 2019/6/14
 * Time: 11:22
 */

namespace ESD\Coroutine\Pool;


class CoroutineExecutor implements Executor
{
    private static $instance;
    public static function getInstance(){
        if(self::$instance==null){
            self::$instance = new CoroutineExecutor();
        }
        return self::$instance;
    }
    public function execute($runnable)
    {
        goWithContext(function ()use ($runnable) {
            if ($runnable instanceof Runnable) {
                $result = $runnable->run();
                $runnable->sendResult($result);
            }
            if (is_callable($runnable)) {
                $runnable();
            }
        });
    }
}