<?php
namespace MrPrompt\Celesc\Tests\Common\Base;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use MrPrompt\Celesc\Common\Base\Sequence;
use MrPrompt\Celesc\Common\Util\ChangeProtectedAttribute;

/**
 * Sequence test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class SequenceTest extends TestCase
{
    use ChangeProtectedAttribute;

    /**
     * @var Sequence
     */
    private $sequence;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->sequence = new Sequence();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->sequence = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Common\Base\Sequence::__construct()
     * @covers \MrPrompt\Celesc\Common\Base\Sequence::getValue()
     */
    public function getValueReturnValueAttribute()
    {
        $this->modifyAttribute($this->sequence, 'value', 1);

        $this->assertEquals(1, $this->sequence->getValue());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Common\Base\Sequence::__construct()
     * @covers \MrPrompt\Celesc\Common\Base\Sequence::setValue()
     * @covers \MrPrompt\Celesc\Common\Base\Sequence::getValue()
     */
    public function setValueModifyValueAttribute()
    {
        $this->sequence->setValue(1);

        $this->assertEquals(1, $this->sequence->getValue());
    }
}
