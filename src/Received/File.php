<?php
namespace MrPrompt\Celesc\Received;

use MrPrompt\ShipmentCommon\Base\Sequence;
use MrPrompt\ShipmentCommon\Base\Cart;
use MrPrompt\Celesc\Received\Partial\Detail;
use MrPrompt\Celesc\Received\Partial\Footer;
use MrPrompt\Celesc\Received\Partial\Header;

/**
 * Received file class
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class File
{
    /**
     * File name template
     *
     * @var string
     */
    const TEMPLATE_GENERATED = 'r{CLIENT}{SEQUENCE}.{SUBTYPE}';

    /**
     * @var Header
     */
    private $header;

    /**
     * @var ArrayObject
     */
    private $cart;

    /**
     * @var Footer
     */
    private $footer;

    /**
     * @var array
     */
    private $rows = [];

    /**
     * @var Sequence
     */
    private $sequence;

    /**
     * @param Sequence $sequence
     * @param string $storageDir
     */
    public function __construct(Sequence $sequence, $storageDir = null)
    {
        $this->sequence = $sequence;

        $file           = $storageDir . DIRECTORY_SEPARATOR . $this->createFilename();
        $content        = file_get_contents($file);

        $this->rows     = explode(PHP_EOL, $content);

        $this->getHeader();
        $this->getFooter();
        $this->getCart();
    }

    /**
     * Create the file name
     *
     * @return string
     */
    private function createFilename()
    {
        $type = self::TEMPLATE_GENERATED;

        $search = [
            '{CLIENT}',
            '{SEQUENCE}',
            '{SUBTYPE}'
        ];

        $replace = [
            'CEL',
            $this->sequence->getValue(),
            '063',
        ];

        return str_replace($search, $replace, $type);
    }

    /**
     * @return Header
     */
    public function getHeader()
    {
        $headerLine     = array_shift($this->rows);
        $this->header   = new Header($headerLine);

        return $this->header;
    }

    /**
     * @return Footer
     */
    public function getFooter()
    {
        $footerLine     = array_pop($this->rows);

        if (null === $footerLine || "" === $footerLine) {
            $footerLine = array_pop($this->rows);
        }

        $this->footer   = new Footer($footerLine);

        return $this->footer;
    }

    /**
     * @return \ArrayObject
     */
    public function getCart()
    {
        $this->cart     = new Cart();

        /* @var $detail \MrPrompt\Celesc\Received\Partial\Detail */
        foreach ($this->rows as $row) {
            $detail = new Detail($row);

            $this->cart->addItem($detail);
        }

        return $this->cart;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return [
            $this->header,
            $this->cart,
            $this->footer
        ];
    }
}
