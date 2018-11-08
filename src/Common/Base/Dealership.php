<?php
namespace MrPrompt\Celesc\Common\Base;

use Respect\Validation\Exceptions\AllOfException;
use Respect\Validation\Validator;

/**
 * Dealership
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Dealership
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * Return the dealeship code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Dealership code
     *
     * @param string $code
     */
    public function setCode($code)
    {
        try {
            Validator::create()->notEmpty()->assert($code);

            $this->code = $code;
        } catch (AllOfException $ex) {
            throw new \InvalidArgumentException(sprintf('Invalid dealership code: %s', $code));
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        try {
            Validator::create()->notEmpty()->assert($name);

            $this->name = $name;
        } catch (AllOfException $ex) {
            throw new \InvalidArgumentException(sprintf('Invalid dealership name: %s', $name));
        }
    }
}
