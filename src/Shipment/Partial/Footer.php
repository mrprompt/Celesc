<?php
namespace MrPrompt\Celesc\Shipment\Partial;

use MrPrompt\Celesc\Common\Base\Sequence;
use MrPrompt\Celesc\Common\Type\Alphanumeric;
use MrPrompt\Celesc\Common\Type\Number;

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
        $result .= str_pad(str_replace('.',  '', $this->sum), 11, Number::FILL, Number::ALIGN);

        // whitespace
        $result .= str_pad(' ', 132, Alphanumeric::FILL, Alphanumeric::ALIGN);

        // sequence line
        $result .= str_pad($this->sequence->getValue(), 6, Number::FILL, Number::ALIGN);

        // resulting...
        return $result;
    }
}
