<?php
namespace MrPrompt\Celesc\Common\Base;

use InvalidArgumentException;
use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator;

/**
 * Sequence
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Sequence
{
    /**
     * @var int
     */
    private $value;

    /**
     * Sequence constructor.
     * @param string $value
     */
    public function __construct($value = "0001")
    {
        $this->value = $value;
    }

    /**
     * Return the value from sequence
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value from sequence
     *
     * @param string $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function setValue($value)
    {
        try {
            Validator::create()->notEmpty()->assert($value);

            $this->value = $value;
        } catch (AllOfException $ex) {
            throw new InvalidArgumentException('Sequence value can not be empty');
        }
    }
}
