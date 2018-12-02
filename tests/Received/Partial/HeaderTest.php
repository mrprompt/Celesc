<?php
namespace MrPrompt\Celesc\Tests\Received\Partial;

use DateTime;
use PHPUnit\Framework\TestCase;
use MrPrompt\Celesc\Received\Partial\Header;
use MrPrompt\Celesc\Tests\ChangeProtectedAttribute;
use MrPrompt\ShipmentCommon\Base\Customer;
use MrPrompt\Celesc\Tests\Mock;
use MrPrompt\ShipmentCommon\Base\Sequence;

/**
 * Header test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class HeaderTest extends TestCase
{
    use ChangeProtectedAttribute;
    use Mock;

    /**
     * @var Header
     */
    private $header;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $row = <<<'EOF'
100000000000000000000000000000000000000000000000000000759000012072016R$    000008                                                              1000001
EOF;
        $this->header = new Header($row);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->header = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Header::getCustomer()
     */
    public function getCustomerMustBeReturnCustomerInstance()
    {
        $customer = $this->header->getCustomer();

        $this->assertInstanceOf(Customer::class, $customer);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Header::setCustomer()
     */
    public function setCustomerMustBeReturnNull()
    {
        $result = $this->header->setCustomer($this->customerMock());

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Header::getCreated()
     */
    public function getCreatedMustBeReturnDateTimeInstance()
    {
        $created = $this->header->getCreated();

        $this->assertInstanceOf(DateTime::class, $created);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Header::setCreated()
     */
    public function setCreatedMustBeReturnNull()
    {
        $result = $this->header->setCreated(new DateTime());

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Header::getSequence()
     */
    public function getSequenceMustBeReturnSequenceInstance()
    {
        $sequence = $this->header->getSequence();

        $this->assertInstanceOf(Sequence::class, $sequence);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Header::setSequence()
     */
    public function setSequenceMustBeReturnNull()
    {
        $result = $this->header->setSequence($this->sequenceMock());

        $this->assertNull($result);
    }
}
