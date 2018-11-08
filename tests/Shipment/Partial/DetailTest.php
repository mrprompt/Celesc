<?php
namespace MrPrompt\Celesc\Tests\Shipment\Partial;

use MrPrompt\Celesc\Common\Base\Bank;
use MrPrompt\Celesc\Common\Base\Holder;
use PHPUnit\Framework\TestCase;
use MrPrompt\Celesc\Shipment\Partial\Detail;
use MrPrompt\Celesc\Common\Util\ChangeProtectedAttribute;
use MrPrompt\Celesc\Tests\Mock as CelescMock;
use MrPrompt\Celesc\Common\Base\Customer;
use MrPrompt\Celesc\Common\Base\Charge;
use MrPrompt\Celesc\Common\Base\Seller;
use MrPrompt\Celesc\Common\Base\Purchaser;
use MrPrompt\Celesc\Common\Base\Parcels;
use MrPrompt\Celesc\Common\Base\Authorization;
use MrPrompt\Celesc\Common\Base\BankAccount;
use MrPrompt\Celesc\Common\Base\ConsumerUnity;
use MrPrompt\Celesc\Common\Base\Sequence;

/**
 * Detail test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class DetailTest extends TestCase
{
    use ChangeProtectedAttribute;
    use CelescMock;

    /**
     * Detail
     * @var Detail
     */
    private $detail;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->detail = new Detail(
            $this->sellerMock(),
            $this->purchaserMock(),
            $this->parcelsMock(),
            $this->authorizationMock(),
            $this->unityMock(),
            $this->sequenceMock()
        );
    }

    /**
     * Cleanup
     */
    public function tearDown()
    {
        $this->detail = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::getConsumerUnity()
     */
    public function getConsumerunityMustBeReturnConsumerunityAttribute()
    {
        $consumerunity = ConsumerUnity::class;

        $this->assertInstanceOf($consumerunity, $this->detail->getConsumerUnity());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::setConsumerunity()
     */
    public function setConsumerunityMustBeReturnNull()
    {
        $consumerunity = new ConsumerUnity();
        $result   = $this->detail->setConsumerunity($consumerunity);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::getSeller()
     */
    public function getSellerMustBeReturnSellerAttribute()
    {
        $seller = Seller::class;

        $this->assertInstanceOf($seller, $this->detail->getSeller());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::setSeller()
     */
    public function setSellerMustBeReturnNull()
    {
        $seller   = new Seller();
        $result   = $this->detail->setSeller($seller);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::getPurchaser()
     */
    public function getPurchaserMustBeReturnPurchaserAttribute()
    {
        $purchaser = Purchaser::class;

        $this->assertInstanceOf($purchaser, $this->detail->getPurchaser());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::setPurchaser()
     */
    public function setPurchaserMustBeReturnNull()
    {
        $purchaser = new Purchaser();
        $result   = $this->detail->setPurchaser($purchaser);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::getParcels()
     */
    public function getParcelsMustBeReturnParcelsAttribute()
    {
        $parcels = Parcels::class;

        $this->assertInstanceOf($parcels, $this->detail->getParcels());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::setParcels()
     */
    public function setParcelsMustBeReturnNull()
    {
        $parcels = new Parcels();
        $result  = $this->detail->setParcels($parcels);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::getAuthorization()
     */
    public function getAuthorizationMustBeReturnAuthorizationAttribute()
    {
        $authorization = Authorization::class;

        $this->assertInstanceOf($authorization, $this->detail->getAuthorization());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::setAuthorization()
     */
    public function setAuthorizationMustBeReturnNull()
    {
        $authorization  = new Authorization();
        $result         = $this->detail->setAuthorization($authorization);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::getSequence()
     */
    public function getSequenceMustBeReturnSequenceAttribute()
    {
        $sequence = Sequence::class;

        $this->assertInstanceOf($sequence, $this->detail->getSequence());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::setSequence()
     */
    public function setSequenceMustBeReturnNull()
    {
        $sequence = new Sequence();
        $result   = $this->detail->setSequence($sequence);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Shipment\Partial\Detail::render()
     */
    public function renderReturnExactSize()
    {
        $result = $this->detail->render();

        $this->assertNotEmpty($result);
        $this->assertEquals(150, strlen($result));
    }
}
