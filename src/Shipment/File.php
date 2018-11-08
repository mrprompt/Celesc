<?php
namespace MrPrompt\Celesc\Shipment;

use MrPrompt\Celesc\Common\Base\Dealership;
use MrPrompt\Celesc\Common\Base\Authorization;
use MrPrompt\Celesc\Common\Base\Cart;
use MrPrompt\Celesc\Common\Base\ConsumerUnity;
use MrPrompt\Celesc\Common\Base\Customer;
use MrPrompt\Celesc\Common\Base\Parcel;
use MrPrompt\Celesc\Common\Base\Parcels;
use MrPrompt\Celesc\Common\Base\Purchaser;
use MrPrompt\Celesc\Common\Base\Seller;
use MrPrompt\Celesc\Common\Base\Sequence;
use MrPrompt\Celesc\Shipment\Partial\Detail;
use MrPrompt\Celesc\Shipment\Partial\Footer;
use MrPrompt\Celesc\Shipment\Partial\Header;
use DateTime;

/**
 * Shipment file class
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
    const TEMPLATE_GENERATED = 'e{CLIENT}{SEQUENCE}.{SUBTYPE}';

    /**
     * @var DateTime
     */
    private $now;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Header
     */
    private $header;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var Footer
     */
    private $footer;

    /**
     * @var Sequence
     */
    private $sequence;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Dealership
     */
    private $dealership;

    /**
     * @var string
     */
    private $storage;

    /**
     * @var string
     */
    private $template;

    /**
     * @param Customer $customer
     * @param Dealership $dealership
     * @param Sequence $sequence
     * @param DateTime $today
     * @param string   $storageDir
     */
    public function __construct(
        Customer $customer,
        Dealership $dealership,
        Sequence $sequence,
        DateTime $today,
        $storageDir = null
    ) {
        $this->customer     = $customer;
        $this->dealership   = $dealership;
        $this->now          = $today;
        $this->sequence     = $sequence;
        $this->storage      = $storageDir;
        $this->content      = null;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return Footer
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * @param Footer $footer
     */
    public function setFooter(Footer $footer)
    {
        $this->footer = $footer;
    }

    /**
     * @return Header
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param Header $header
     */
    public function setHeader(Header $header)
    {
        $this->header = $header;
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
     * @param $parcels
     * @return int
     */
    private function getTotalPrice($parcels)
    {
        $price = 0;

        foreach ($parcels as $parcel) {
            $price += $parcel->getPrice();
        }

        return $price;
    }

    /**
     * @return string
     */
    private function generateContent()
    {
        $totalPrice     = 0;
        $counter        = 2;

        $this->header = new Header($this->customer, $this->dealership, $this->sequence, $this->now);
        $this->content  = $this->header->render() . PHP_EOL;

        /* @var $detail \MrPrompt\Celesc\Shipment\Partial\Detail */
        foreach ($this->cart as $detail) {
            $detail->getSequence()->setValue($counter);

            $this->content .= $detail->render() . PHP_EOL;

            $totalPrice += $this->getTotalPrice( $detail->getParcels() );
            $counter++;
        }

        $sequence = clone $this->sequence;
        $sequence->setValue($counter);

        $this->footer = new Footer(($counter - 1), preg_replace('/[^0-9]+/', '', $totalPrice), $sequence);

        $this->content .= $this->footer->render();

        return $this->content;
    }

    /**
     * @return string
     */
    public function save()
    {
        if (null === $this->content) {
            $this->content = $this->generateContent();
        }

        $this->template = self::TEMPLATE_GENERATED;

        $this->header->setSequence($this->sequence);

        $filename   = $this->createFilename($this->template);
        $outputFile = $this->storage . DIRECTORY_SEPARATOR . $filename;

        file_put_contents($outputFile, $this->content . PHP_EOL);

        return $outputFile;
    }

    /**
     * @return string
     */
    public function read()
    {
        $this->template = self::TEMPLATE_GENERATED;

        $file = $this->storage . DIRECTORY_SEPARATOR . $this->createFilename($this->template);

        $this->content  = file_get_contents($file);

        $details        = explode(PHP_EOL, $this->content);
        $headerLine     = array_shift($details);
        $footerLine     = array_pop($details);

        if (null == $footerLine) {
            $footerLine = array_pop($details);
        }

        $this->header   = new Header(
            $this->customer,
            $this->dealership,
            new Sequence(substr($headerLine, 144, 6)),
            $this->now
        );

        $this->footer   = new Footer(
            substr($footerLine, 1, 6),
            substr($footerLine, 7, 10),
            (new Sequence(substr($footerLine, 144, 6)))
        );

        $this->cart = new Cart();

        /* @var $detail \MrPrompt\Celesc\Shipment\Partial\Detail */
        foreach ($details as $row) {
            $unity          = new ConsumerUnity();
            $unity->setNumber(substr($row, 1, 13));

            $seller         = new Seller();

            $parcels        = $this->createParcels($row);
            $authorization  = $this->createAuthorization($row);
            $sequence       = new Sequence(substr($row, 144, 6));

            // extracting object from line
            $unity->setNumber(substr($row, 0, 1));
            $unity->setMaturity(DateTime::createFromFormat('dmY', substr($row, 23, 8)));

            $purchaser = $this->createPurchaser($row);

            $detail = new Detail(
                $seller,
                $purchaser,
                $parcels,
                $authorization,
                $unity,
                $sequence
            );

            $this->cart->append($detail);
        }

        return [
            $this->header,
            $this->cart,
            $this->footer
        ];
    }

    /**
     * @param string $row
     * @return Purchaser
     */
    private function createPurchaser($row)
    {
        $purchaser = new Purchaser();

        return $purchaser;
    }

    /**
     * @param $row
     * @return Parcels
     */
    private function createParcels($row)
    {
        $parcel = new Parcel();
        $parcel->setMaturity(DateTime::createFromFormat('dmY', substr($row, 23, 8)));
        $parcel->setPrice(substr($row, 14, 9));
        $parcel->setQuantity(1);
        $parcel->setKey(0);

        $parcels = new Parcels(4);
        $parcels->addParcel($parcel);

        return $parcels;
    }

    /**
     * @param $row
     * @return Authorization
     */
    private function createAuthorization($row)
    {
        $authorization  = new Authorization();
        // $authorization->setNumber(substr($row, 773, 10));

        return $authorization;
    }
}
