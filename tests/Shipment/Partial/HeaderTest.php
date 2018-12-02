<?php
namespace MrPrompt\Celesc\Tests\Shipment\Partial;

use DateTime;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use MrPrompt\Celesc\Shipment\Partial\Header;
use MrPrompt\Celesc\Tests\ChangeProtectedAttribute;
use MrPrompt\Celesc\Tests\Mock as CelescMock;
use MrPrompt\ShipmentCommon\Base\Customer;
use MrPrompt\ShipmentCommon\Base\Sequence;

/**
 * Header test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class HeaderTest extends TestCase
{
    use ChangeProtectedAttribute;
    use CelescMock;

    /**
     * Header
     *
     * @var Header
     */
    private $header;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->header = new Header(
            $this->customerMock(),
            $this->dealershipMock(),
            $this->sequenceMock(),
            new DateTime()
        );
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
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::getCustomer()
     */
    public function getCustomerMustBeReturnCustomerAttribute()
    {
        $this->assertInstanceOf(Customer::class, $this->header->getCustomer());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::setCustomer()
     */
    public function setCustomerMustBeReturnCustomerAttribute()
    {
        $customer = new Customer();

        $result   = $this->header->setCustomer($customer);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::getCreated()
     */
    public function getCreatedMustBeReturnCreatedAttribute()
    {
        $this->assertInstanceOf(DateTime::class, $this->header->getCreated());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::setCreated()
     */
    public function setCreatedMustBeReturnCreatedAttribute()
    {
        $Created = new DateTime();

        $result   = $this->header->setCreated($Created);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::getSequence()
     */
    public function getSequenceMustBeReturnSequenceAttribute()
    {
        $this->assertInstanceOf(Sequence::class, $this->header->getSequence());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::setSequence()
     */
    public function setSequenceMustBeReturnSequenceAttribute()
    {
        $Sequence = new Sequence();

        $result   = $this->header->setSequence($Sequence);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Header::render()
     */
    public function renderReturnExactLength()
    {
        $this->assertEquals(150, strlen($this->header->render()));
    }
}
