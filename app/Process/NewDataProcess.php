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
 * @Process(workerId=1)
 */
class NewDataProcess implements ProcessInterface
{
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

        $this->process->useQueue(1,2);

        sgo([$this,'runWhile']);

        Event::wait();
    }

    public function runWhile()
    {
        $limit = 0;
        $num = 10;

        while ($this->runWhile) {
            $num--;
            if (!$num) $this->runWhile = false;

            if ( $this->process->statQueue()["queue_num"]<$limit ){
                CLog::info("new Data");
                $this->process->push(json_encode(['runTime'=>date("Y-m-d H:i:s")]));
            }

            Coroutine::sleep(10);
        }
    }
}
