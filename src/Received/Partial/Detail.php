<?php
namespace MrPrompt\Celesc\Received\Partial;

use MrPrompt\ShipmentCommon\Base\Authorization;
use MrPrompt\ShipmentCommon\Base\ConsumerUnity;
use MrPrompt\ShipmentCommon\Base\Dealership;
use MrPrompt\ShipmentCommon\Base\Document;
use MrPrompt\ShipmentCommon\Base\Occurrence;
use MrPrompt\ShipmentCommon\Base\Parcel;
use MrPrompt\ShipmentCommon\Base\Purchaser;
use MrPrompt\ShipmentCommon\Base\Sequence;
use DateTime;

/**
 * File detail
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Detail extends \stdClass
{
    /**
     * Type of register
     *
     * @var string
     */
    const TYPE = '2';

    /**
     * @var ConsumerUnity
     */
    private $consumerUnity;

    /**
     * @var Occurrence
     */
    private $occurrence;

    /**
     * @var Parcel
     */
    private $parcel;

    /**
     * @var Authorization
     */
    private $authorization;

    /**
     * @var Dealership
     */
    private $dealership;

    /**
     * @var Sequence
     */
    private $sequence;

    /**
     * @var Purchaser
     */
    private $purchaser;

    /**
     * Constructor
     * @param string $row
     */
    public function __construct($row)
    {
        $this->consumerUnity = new ConsumerUnity();
        $this->consumerUnity->setNumber((int) substr($row, 1, 13));

        $this->parcel = new Parcel();
        $this->parcel->setPrice(substr($row, 14, 9));
        $this->parcel->setKey(0);
        $this->parcel->setMaturity(DateTime::createFromFormat('dmY', substr($row, 23, 8)));

        $this->occurrence = new Occurrence();
        $this->occurrence->setReturn((int) substr($row, 31, 2));

        $this->authorization = new Authorization();
        $this->authorization->setNumber((int) substr($row, 41, 60));

        $this->dealership = new Dealership();

        $document = new Document();
        $document->setNumber((int) substr($row, 109, 11));

        $this->purchaser = new Purchaser();
        $this->purchaser->setDocument($document);

        $this->sequence = new Sequence((int) substr($row, 144, 6));
    }

    /**
     * @return ConsumerUnity
     */
    public function getConsumerUnity()
    {
        return $this->consumerUnity;
    }

    /**
     * @param ConsumerUnity $consumerUnity
     */
    public function setConsumerUnity(ConsumerUnity $consumerUnity)
    {
        $this->consumerUnity = $consumerUnity;
    }

    /**
     * @return Occurrence
     */
    public function getOccurrence()
    {
        return $this->occurrence;
    }

    /**
     * @param Occurrence $occurrence
     */
    public function setOccurrence(Occurrence $occurrence)
    {
        $this->occurrence = $occurrence;
    }

    /**
     * @return Parcel
     */
    public function getParcel()
    {
        return $this->parcel;
    }

    /**
     * @param Parcel $parcel
     */
    public function setParcel(Parcel $parcel)
    {
        $this->parcel = $parcel;
    }

    /**
     * @return Authorization
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * @param Authorization $authorization
     */
    public function setAuthorization(Authorization $authorization)
    {
        $this->authorization = $authorization;
    }

    /**
     * @return Dealership
     */
    public function getDealership()
    {
        return $this->dealership;
    }

    /**
     * @param Dealership $dealership
     */
    public function setDealership(Dealership $dealership)
    {
        $this->dealership = $dealership;
    }

    /**
     * @return Sequence
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param Sequence $sequence
     */
    public function setSequence(Sequence $sequence)
    {
        $this->sequence = $sequence;
    }

    /**
     * @return Purchaser
     */
    public function getPurchaser()
    {
        return $this->purchaser;
    }

    /**
     * @param Purchaser $purchaser
     */
    public function setPurchaser(Purchaser $purchaser)
    {
        $this->purchaser = $purchaser;
    }
}
