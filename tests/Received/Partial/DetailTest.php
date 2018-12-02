<?php
namespace MrPrompt\Celesc\Tests\Received\Partial;

use PHPUnit\Framework\TestCase;
use MrPrompt\Celesc\Received\Partial\Detail;
use MrPrompt\Celesc\Tests\ChangeProtectedAttribute;
use MrPrompt\Celesc\Tests\Mock;
use MrPrompt\ShipmentCommon\Base\Authorization;
use MrPrompt\ShipmentCommon\Base\Client;
use MrPrompt\ShipmentCommon\Base\ConsumerUnity;
use MrPrompt\ShipmentCommon\Base\Dealership;
use MrPrompt\ShipmentCommon\Base\Occurrence;
use MrPrompt\ShipmentCommon\Base\Parcel;
use MrPrompt\ShipmentCommon\Base\Purchaser;
use MrPrompt\ShipmentCommon\Base\Sequence;

/**
 * Detail test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class DetailTest extends TestCase
{
    use ChangeProtectedAttribute;
    use Mock;

    /**
     * @var Detail
     */
    private $detail;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $row = <<<'EOF'
20000000001010000000.011108201681        32046                                                       1108201694908443904                        000002
EOF;

        $this->detail = new Detail($row);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->detail = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::getConsumerUnity()
     */
    public function getConsumerUnityMustBeReturnConsumerUnityObject()
    {
        $unity = $this->detail->getConsumerUnity();

        $this->assertInstanceOf(ConsumerUnity::class, $unity);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::setConsumerUnity()
     */
    public function setConsumerUnityMustNull()
    {
        $unity  = $this->consumerUnityMock();
        $result = $this->detail->setConsumerUnity($unity);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::getOccurrence()
     */
    public function getOccurrenceMustBeReturnOccurrenceObject()
    {
        $occurrence = $this->detail->getOccurrence();

        $this->assertInstanceOf(Occurrence::class, $occurrence);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::setOccurrence()
     */
    public function setOccurrenceMustBeReturnNull()
    {
        $occurrence = $this->occurrenceMock();
        $result     = $this->detail->setOccurrence($occurrence);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::getParcel()
     */
    public function getParcelMustBeReturnParcelObject()
    {
        $parcel = $this->detail->getParcel();

        $this->assertInstanceOf(Parcel::class, $parcel);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::setParcel()
     */
    public function setParcelMustBeReturnParcelObject()
    {
        $parcel = $this->parcelMock();
        $result = $this->detail->setParcel($parcel);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::getAuthorization()
     */
    public function getAuthorizationMustBeReturnAuthorizationObject()
    {
        $authorization = $this->detail->getAuthorization();

        $this->assertInstanceOf(Authorization::class, $authorization);
    }
    
    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::setAuthorization()
     */
    public function setAuthorizationMustBeReturnAuthorizationObject()
    {
        $authorization = $this->authorizationMock();
        $result = $this->detail->setAuthorization($authorization);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::getDealership()
     */
    public function getDealershipMustBeReturnDealershipObject()
    {
        $dealership = $this->detail->getDealership();

        $this->assertInstanceOf(Dealership::class, $dealership);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::setDealership()
     */
    public function setDealershipMustBeReturnDealershipObject()
    {
        $dealership = $this->dealershipMock();
        $result = $this->detail->setDealership($dealership);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::getSequence()
     */
    public function getSequenceMustBeReturnSequenceObject()
    {
        $sequence = $this->detail->getSequence();

        $this->assertInstanceOf(Sequence::class, $sequence);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::setSequence()
     */
    public function setSequenceMustBeReturnSequenceObject()
    {
        $sequence = $this->sequenceMock();
        $result = $this->detail->setSequence($sequence);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::getPurchaser()
     */
    public function getPurchaserMustBeReturnPurchaserObject()
    {
        $purchaser = $this->detail->getPurchaser();

        $this->assertInstanceOf(Purchaser::class, $purchaser);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::__construct()
     * @covers \MrPrompt\Celesc\Received\Partial\Detail::setPurchaser()
     */
    public function setPurchaserMustBeReturnPurchaserObject()
    {
        $purchaser = $this->purchaserMock();
        $result = $this->detail->setPurchaser($purchaser);

        $this->assertNull($result);
    }
}
