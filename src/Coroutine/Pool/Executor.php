<?php
/**
 * Created by PhpStorm.
 * User: administrato
 * Date: 2019/6/14
 * Time: 11:20
 */

namespace ESD\Coroutine\Pool;


interface Executor
{
    public function execute($runnable);
}