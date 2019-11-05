<?php


namespace App\Process;


use Swoft\Log\Helper\CLog;
use Swoft\Process\Annotation\Mapping\Process;
use Swoft\Process\Contract\ProcessInterface;
use Swoft\Redis\Redis;
use Swoole\Process\Pool;

/**
 * Class TestRedisProcess
 * @package App\Process
 * @Process(workerId=2)
 */
class TestRedisProcess implements ProcessInterface
{
    /**
     * Run
     *
     * @param Pool $pool
     * @param int $workerId
     */
    public function run(Pool $pool, int $workerId): void
    {
        CLog::info("开始测试redis读取");
        if ( $msg = Redis::brPop(['test'],0) ){
            CLog::info(serialize($msg));
        }
        CLog::info("开始测试redis读取 end");
    }
}
