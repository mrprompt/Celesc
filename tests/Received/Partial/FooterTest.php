<?php
namespace MrPrompt\Celesc\Tests\Received\Partial;

use PHPUnit\Framework\TestCase;
use MrPrompt\Celesc\Received\Partial\Footer;
use MrPrompt\Celesc\Common\Base\Sequence;
use MrPrompt\Celesc\Common\Util\ChangeProtectedAttribute;
use MrPrompt\Celesc\Tests\Mock;

/**
 * Footer test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class FooterTest extends TestCase
{
    use ChangeProtectedAttribute;
    use Mock;

    /**
     * @var Footer
     */
    private $footer;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $row = <<<'EOF'
900000000002                                                                                                                                    000004
EOF;

        $this->footer = new Footer($row);
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
     * @cover \Celesc\Gateway\Received\Partial\Footer::__construct()
     * @cover \Celesc\Gateway\Received\Partial\Footer::getSequence()
     */
    public function getSequenceMustBeReturnSequenceInstance()
    {
        $sequence = $this->footer->getSequence();

        $this->assertInstanceOf(Sequence::class, $sequence);
    }

    /**
     * @test
     * @cover \Celesc\Gateway\Received\Partial\Footer::__construct()
     * @cover \Celesc\Gateway\Received\Partial\Footer::setSequence()
     */
    public function setSequenceMustBeReturnNull()
    {
        $sequence = $this->footer->setSequence(new Sequence());

        $this->assertNull($sequence);
    }
}
