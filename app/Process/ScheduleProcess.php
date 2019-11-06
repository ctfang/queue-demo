<?php


namespace App\Process;

use Swoft\Log\Helper\CLog;
use Swoft\Process\Annotation\Mapping\Process;
use Swoft\Process\Contract\ProcessInterface;
use Swoole\Coroutine;
use Swoole\Event;
use Swoole\Process\Pool;

/**
 * Class ScheduleProcess
 * @package App\Process
 * @Process(workerId=0)
 */
class ScheduleProcess implements ProcessInterface
{
    /**
     * 中断任务
     */
    public const STOP = "stop worker";

    /**
     * @var bool
     */
    protected $runWhile = true;

    /**
     * @var int
     */
    protected $workerId = 0;

    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @var \Swoole\Process
     */
    protected $process;

    /**
     * @param Pool $pool
     * @param int $workerId
     */
    public function run(Pool $pool, int $workerId): void
    {
        $this->workerId = $workerId;
        $this->pool = $pool;
        $this->process = $pool->getProcess($workerId);
        $this->process->useQueue(2,2);

        $this->addSignal();

        sgo([$this,'runWhile']);

        Event::wait();
    }



    public function runWhile()
    {
        while ($this->runWhile) {
            $msg = $this->process->pop();

            if ( $msg == self::STOP  ){
                $this->runWhile = false;
                break;
            }

            CLog::info("开始处理任务");
            Coroutine::sleep(1);
            CLog::info("结束处理任务");
        }
    }

    public function addSignal()
    {
        \Swoole\Process::signal(SIGINT, function () {
            CLog::info("拦截信号signal(2),防止直接关闭,应该收到signal(15)才真正关闭");
            //\Swoole\Process::kill($this->process->pid, SIGTERM);
        });

        \Swoole\Process::signal(SIGTERM, function () {
            CLog::info("收到信号 signal(15)");
            $this->onStop();
        });
    }

    public function onStop()
    {
        $queueNum = $this->process->statQueue()["queue_num"];
        if ( !$queueNum ){
            CLog::info("发送停止信息到通道");
            $this->process->push(self::STOP);
        }
        file_put_contents(alias("@runtime/").date("Y-m-d H:i:s").'.txt', '结束');
        $this->runWhile = false;
        Event::wait();
        $this->process->exit(1);
    }
}
