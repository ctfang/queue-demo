<?php


namespace App\Annotation\Mapping;

use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

/**
 * HTTP action method annotation
 *
 * @Annotation
 * @Target("METHOD")
 *
 * @since 2.0
 */
class JobMapping
{
    /**
     * Route name
     *
     * @var string
     */
    private $name = '';

    /**
     * RequestMapping constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->name = (string)$values['value'];
        }

        if (isset($values['name'])) {
            $this->name = (string)$values['name'];
        }
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }
}
