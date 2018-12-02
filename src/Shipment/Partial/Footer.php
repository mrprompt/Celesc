<?php
namespace MrPrompt\Celesc\Shipment\Partial;

use MrPrompt\ShipmentCommon\Base\Sequence;
use MrPrompt\ShipmentCommon\Type\Alphanumeric;
use MrPrompt\ShipmentCommon\Type\Numeric;

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
    const TYPE = 9;

    /**
     * Sequence number
     *
     * @var Sequence
     */
    private $sequence;

    /**
     * Total of new charges
     *
     * @var int
     */
    private $total;

    /**
     * Sum of new charges
     *
     * @var int
     */
    private $sum;

    /**
     * @param int $totalCharges
     * @param int $sumCharges
     * @param Sequence $sequence
     */
    public function __construct($totalCharges = 0, $sumCharges = 0, Sequence $sequence)
    {
        $this->total    = $totalCharges;
        $this->sum      = $sumCharges;
        $this->sequence = $sequence;
    }

    /**
     * Render footer line
     *
     * @return string
     */
    public function render()
    {
        // register code
        $result = self::TYPE;

        // sum of charges values
        $result .= str_pad(str_replace('.',  '', $this->sum), 11, Numeric::FILL, Numeric::ALIGN);

        // whitespace
        $result .= str_pad(' ', 132, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // sequence line
        $result .= str_pad($this->sequence->getValue(), 6, Numeric::FILL, Numeric::ALIGN);

        // resulting...
        return $result;
    }
}
