<?php
namespace MrPrompt\Celesc\Received\Partial;

use DateTime;
use MrPrompt\Celesc\Common\Base\Dealership;
use MrPrompt\Celesc\Common\Base\Occurrence;
use MrPrompt\Celesc\Common\Base\Customer;
use MrPrompt\Celesc\Common\Base\Sequence;

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
     * Charge Code
     *
     * @const int
     */
    const CODE = 2;

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
     * Occurrence
     *
     * @var Occurrence
     */
    private $occurrence;

    /**
     * File date creation
     *
     * @var DateTime
     */
    private $created;

    /**
     * Sequence number on file
     *
     * @var Sequence
     */
    private $sequence;

    /**
     * Constructor
     * @param string $row
     */
    public function __construct($row)
    {
        $this->customer = new Customer();
        $this->customer->setCode(substr($row, 1, 56));
        $this->customer->setName(substr($row, 83, 60));

        $this->dealership = new Dealership();
        $this->dealership->setCode(substr($row, 57, 2));

        $this->created  = DateTime::createFromFormat('dmY', substr($row, 61, 8));

        $this->occurrence = new Occurrence();
        $this->occurrence->setReturn(substr($row, 81, 2));

        $this->sequence = new Sequence(substr($row, 144, 6));
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
}
