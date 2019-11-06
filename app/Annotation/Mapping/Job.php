<?php


namespace App\Annotation\Mapping;

/**
 * Class Process
 *
 * @since 2.0
 *
 * @Annotation
 * @Target("CLASS")
 * @Attributes({
 *     @Attribute("group", type="string"),
 * })
 */
class Job
{
    /**
     * 队列路由名称
     *
     * @var string
     */
    private $group= "*";

    /**
     * Process constructor.
     *
     * @param  array  $values
     */
    public function __construct(array $values)
    {
        if (isset($values['group'])) {
            $this->group = $values['group'];
        }
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }
}
