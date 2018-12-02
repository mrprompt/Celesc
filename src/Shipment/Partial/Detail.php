<?php
namespace MrPrompt\Celesc\Shipment\Partial;

use MrPrompt\ShipmentCommon\Base\Authorization;
use MrPrompt\ShipmentCommon\Base\ConsumerUnity;
use MrPrompt\ShipmentCommon\Base\Parcels;
use MrPrompt\ShipmentCommon\Base\Purchaser;
use MrPrompt\ShipmentCommon\Base\Seller;
use MrPrompt\ShipmentCommon\Base\Sequence;
use MrPrompt\ShipmentCommon\Type\Alphanumeric;
use MrPrompt\ShipmentCommon\Type\Numeric;

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
     * @var int
     */
    const TYPE = 2;

    /**
     * Sent code
     *
     * @const int
     */
    const CODE = '00';

    /**
     * Date Format
     *
     * @var string
     */
    const DATE_FORMAT = 'dmY';

    /**
     * Consumer Unity
     *
     * @var ConsumerUnity
     */
    private $consumerUnity;

    /**
     * Seller
     *
     * @var Seller
     */
    private $seller;

    /**
     * Purchaser
     *
     * @var Purchaser
     */
    private $purchaser;

    /**
     * Parcels
     *
     * @var Parcels
     */
    private $parcels;

    /**
     * Authorization
     *
     * @var Authorization
     */
    private $authorization;

    /**
     * Sequence
     *
     * @var Sequence
     */
    private $sequence;

    /**
     * Constructor
     *
     * @param Seller $seller
     * @param Purchaser $purchaser
     * @param Parcels $parcels
     * @param Authorization $authorization
     * @param ConsumerUnity $consumerUnity
     * @param Sequence $sequence
     */
    public function __construct(
        Seller $seller,
        Purchaser $purchaser,
        Parcels $parcels,
        Authorization $authorization,
        ConsumerUnity $consumerUnity,
        Sequence $sequence
    ) {
        $this->seller           = $seller;
        $this->purchaser        = $purchaser;
        $this->parcels          = $parcels;
        $this->authorization    = $authorization;
        $this->consumerUnity    = $consumerUnity;
        $this->sequence         = $sequence;
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
     * @return Seller
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * @param Seller $seller
     */
    public function setSeller(Seller $seller)
    {
        $this->seller = $seller;
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

    /**
     * @return Parcels
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param Parcels $parcels
     */
    public function setParcels(Parcels $parcels)
    {
        $this->parcels = $parcels;
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
     * Render detail registry line
     *
     * @return string
     */
    public function render()
    {
        // Register code
        $result  = str_pad(self::TYPE, 1, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // Consumer Unity from client
        $result .= str_pad($this->consumerUnity->getNumber(), 13, Numeric::FILL, Numeric::ALIGN);

        // Value
        $result .= str_pad(preg_replace('/[^0-9]+/', '', $this->getPrice()->getPrice()), 9, Numeric::FILL, Numeric::ALIGN);

        // Maturity
        $result .= $this->getPrice()->getMaturity()->format(self::DATE_FORMAT);

        // Sent Status
        $result .= self::CODE;

        // accounting account code
        $result .= str_pad('11307O63', 8, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // internal control
        $result .= str_pad($this->authorization->getNumber(), 60, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // computed date
        $result .= str_pad(' ', 8, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // client document
        $result .= str_pad(preg_replace('/[^0-9]+/', '', $this->purchaser->getDocument()->getNumber()), 11, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // administrative unity
        $result .= str_pad(' ', 10, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // CNPJ complement (?!?)
        $result .= str_pad(' ', 3, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // spaces only
        $result .= str_pad(' ', 11, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // sequence number from line
        $result .= str_pad($this->sequence->getValue(), 6, Numeric::FILL, Numeric::ALIGN);

        // resulting....
        return $result;
    }

    /**
     * @return mixed
     */
    private function getPrice()
    {
        $parcel = $this->parcels->offsetGet(0);

        return $parcel;
    }
}
