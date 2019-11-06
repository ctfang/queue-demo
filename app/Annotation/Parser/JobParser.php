<?php


namespace App\Annotation\Parser;

use App\Base\Pool\Process\QueueConfig;
use App\Process\QueueProcess;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Bean\Annotation\Mapping\Bean;
use App\Annotation\Mapping\Job;

/**
 * Class ProcessParser
 *
 * @since 2.0
 *
 * @AnnotationParser(annotation=Job::class)
 */
class JobParser extends Parser
{
    /**
     * Parse object
     *
     * @param  int  $type  Class or Method or Property
     * @param  Job  $annotationObject  Annotation object
     *
     * @return array
     */
    public function parse(int $type, $annotationObject): array
    {
        return [$this->className, $this->className, Bean::SINGLETON, ''];
    }
}
