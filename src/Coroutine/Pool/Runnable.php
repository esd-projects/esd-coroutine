<?php
/**
 * Created by PhpStorm.
 * User: 白猫
 * Date: 2019/4/17
 * Time: 13:44
 */

namespace ESD\Coroutine\Pool;

use ESD\Coroutine\Channel\ChannelImpl;
use ESD\Coroutine\Co;

class Runnable
{
    /**
     * @var ChannelImpl
     */
    private $channel;

    /**
     * @var mixed
     */
    private $result;

    private $runnable;

    public function __construct(callable $runnable, bool $needResult = false)
    {
        $this->runnable = $runnable;
        if ($needResult) {
            $this->channel = new ChannelImpl();
        }
    }

    /**
     * 获取结果
     * @param float $timeOut
     * @return mixed
     */
    public function getResult(float $timeOut = 0)
    {
        if ($this->channel == null) return null;
        if ($this->result == null) {
            $this->result = $this->channel->pop($timeOut);
        }
        $this->channel->close();
        return $this->result;
    }

    /**
     * 发送结果
     * @param $result
     */
    public function sendResult($result)
    {
        if ($this->channel == null) {
            return;
        }
        $this->channel->push($result);
    }

    /**
     * 直接执行
     */
    public function justRun()
    {
        Co::runTask($this);
    }

    public function run()
    {
        return call_user_func($this->runnable);
    }
}