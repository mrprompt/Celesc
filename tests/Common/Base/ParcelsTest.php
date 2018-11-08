<?php
namespace MrPrompt\Celesc\Tests\Common\Base;

use DateTime;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use MrPrompt\Celesc\Common\Base\Parcels;
use MrPrompt\Celesc\Common\Util\ChangeProtectedAttribute;
use MrPrompt\Celesc\Tests\Mock;

/**
 * Parcels test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class ParcelsTest extends TestCase
{
    use ChangeProtectedAttribute;
    use Mock;

    /**
     * @var Parcels
     */
    private $parcels;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->parcels = new Parcels(4);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->parcels = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Common\Base\Parcels::__construct
     * @covers \MrPrompt\Celesc\Common\Base\Parcels::addParcel
     */
    public function addParcelMustReturnNullWhenReceiveParcelObject()
    {
        $this->assertNull($this->parcels->addParcel($this->parcelMock()));
    }
}
