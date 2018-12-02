<?php
namespace MrPrompt\Celesc\Shipment\Partial;

use DateTime;
use MrPrompt\ShipmentCommon\Base\Dealership;
use MrPrompt\ShipmentCommon\Base\Customer;
use MrPrompt\ShipmentCommon\Base\Sequence;
use MrPrompt\ShipmentCommon\Type\Numeric;
use MrPrompt\ShipmentCommon\Type\Alphanumeric;

/**
 * File header
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Header
{
    /**
     * Type of register
     *
     * @const string
     */
    const TYPE = '1';

    /**
     * Sequencial line
     *
     * @const int
     */
    const LINE = 1;

    /**
     * Sent code
     *
     * @const int
     */
    const CODE = 1;

    /**
     * Currency
     *
     * @const string
     */
    const CURRENCY = 'R$';

    /**
     * Customer Code
     *
     * @var Customer
     */
    private $customer;

    /**
     * Dealership
     *
     * @var Dealership
     */
    private $dealership;

    /**
     * File date creation
     *
     * @var DateTime
     */
    private $created;

    /**
     * Sequencial number of file
     *
     * @var Sequence
     */
    private $sequence;

    /**
     * Constructor
     *
     * @param Customer $customer
     * @param Dealership $dealership
     * @param Sequence $sequence
     * @param DateTime $created
     */
    public function __construct(Customer $customer, Dealership $dealership, Sequence $sequence, DateTime $created)
    {
        $this->customer     = $customer;
        $this->dealership   = $dealership;
        $this->sequence     = $sequence;
        $this->created      = $created;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
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
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
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
     * Render header line
     *
     * @return string
     */
    public function render()
    {
        // register type
        $line  = self::TYPE;

        // customer code
        $line .= str_pad($this->customer->getCode(), 56, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // dealership code
        $line .= str_pad($this->dealership->getCode(), 4, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // date from file
        $line .= $this->created->format('dmY');

        // Currency
        $line .= str_pad(self::CURRENCY, 6, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // sequence file
        $line .= str_pad($this->sequence->getValue(), 6, Numeric::FILL, Numeric::ALIGN);

        // Result code
        $line .= str_pad(' ', 2, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // Company name
        $line .= str_pad($this->customer->getName(), 20, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // Spaces only
        $line .= str_pad(' ', 40, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // sent code
        $line .= self::CODE;

        // sequence line
        $line .= str_pad(self::LINE, 6, Numeric::FILL, Numeric::ALIGN);

        // resulting...
        return $line;
    }
}
