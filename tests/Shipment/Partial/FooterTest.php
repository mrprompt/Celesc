<?php
namespace MrPrompt\Celesc\Tests\Shipment\Partial;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use MrPrompt\Celesc\Shipment\Partial\Footer;
use MrPrompt\Celesc\Common\Util\ChangeProtectedAttribute;
use MrPrompt\Celesc\Tests\Mock as CelescMock;

/**
 * Footer test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class FooterTest extends TestCase
{
    use ChangeProtectedAttribute;
    use CelescMock;

    /**
     * Footer object
     *
     * @var Footer
     */
    private $footer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->footer = new Footer(1, 1, $this->sequenceMock());
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->footer = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Footer::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Footer::render()
     * @covers \MrPrompt\Celesc\Common\Base\Sequence::getValue()
     */
    public function renderReturnExactLength()
    {
        $this->assertEquals(150, strlen($this->footer->render()));
    }
}
