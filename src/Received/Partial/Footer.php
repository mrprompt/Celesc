<?php
namespace MrPrompt\Celesc\Received\Partial;

use MrPrompt\Celesc\Common\Base\Parcel;
use MrPrompt\Celesc\Common\Base\Sequence;

/**
 * File footer
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class Footer
{
    /**
     * Type of register
     *
     * @var string
     */
    const TYPE = '9';

    /**
     * @var Sequence
     */
    private $sequence;

    /**
     * @var Parcel
     */
    private $parcel;

    /**
     * Constructor
     * @param string $row
     */
    public function __construct($row)
    {
        $this->parcel = new Parcel();
        $this->parcel->setPrice(substr($row, 1, 11));
        $this->parcel->setQuantity(1);

        $this->sequence = new Sequence((substr($row, 144, 6)));
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
     * @return Parcel
     */
    public function getParcel()
    {
        return $this->parcel;
    }

    /**
     * @param Parcel $parcel
     */
    public function setParcel($parcel)
    {
        $this->parcel = $parcel;
    }
}
