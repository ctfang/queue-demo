<?php


namespace App\Annotation\Parser;


use App\Base\Pool\Process\QueueConfig;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;
use Swoft\Annotation\Exception\AnnotationException;
use App\Annotation\Mapping\JobMapping;
use Swoft\Log\Helper\CLog;

/**
 * Class RequestMappingParser
 *
 * @since 2.0
 *
 * @AnnotationParser(JobMapping::class)
 */
class JobMappingParser extends Parser
{
    /**
     * @param int            $type
     * @param JobMapping $annotation
     *
     * @return array
     * @throws AnnotationException
     */
    public function parse(int $type, $annotation): array
    {
        return [];
    }
}
