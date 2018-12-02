<?php
namespace MrPrompt\Celesc\Tests\Shipment;

use MrPrompt\ShipmentCommon\Base\Cart;
use MrPrompt\Celesc\Shipment\File;
use MrPrompt\Celesc\Tests\ChangeProtectedAttribute;
use MrPrompt\Celesc\Shipment\Partial\Footer;
use MrPrompt\Celesc\Shipment\Partial\Header;
use MrPrompt\ShipmentCommon\Base\Sequence;
use MrPrompt\Celesc\Tests\Mock;
use DateTime;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

/**
 * file test case.
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
class FileTest extends TestCase
{
    use ChangeProtectedAttribute;
    use Mock;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    private static $root;

    /**
     * @var File
     */
    private $file;

    /**
     * Boostrap
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$root = vfsStream::setup();
    }

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->file = new File(
            $this->customerMock(),
            $this->dealershipMock(),
            $this->sequenceMock(),
            new DateTime,
            self::$root->url()
        );
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->file = null;

        parent::tearDown();
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\File::__construct()
     * @covers \MrPrompt\Celesc\Shipment\File::getCart()
     */
    public function getCartMustBeReturnCartAttribute()
    {
        $cart = new Cart();

        $this->modifyAttribute($this->file, 'cart', $cart);

        $this->assertSame($cart, $this->file->getCart());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\File::__construct()
     * @covers \MrPrompt\Celesc\Shipment\File::setCart()
     */
    public function setCartMustBeReturnCartAttribute()
    {
        $cart   = new Cart;
        $result = $this->file->setCart($cart);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\File::__construct()
     * @covers \MrPrompt\Celesc\Shipment\File::getFooter()
     */
    public function getFooterMustBeReturnFooterAttribute()
    {
        $sequence   = new Sequence();
        $footer     = new Footer(0, 0, $sequence);

        $this->modifyAttribute($this->file, 'footer', $footer);

        $this->assertSame($footer, $this->file->getFooter());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\File::__construct()
     * @covers \MrPrompt\Celesc\Shipment\File::setFooter()
     */
    public function setFooterMustBeReturnFooterAttribute()
    {
        $sequence   = new Sequence();

        $footer     = new Footer(0, 0, $sequence);

        $result     = $this->file->setFooter($footer);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\File::__construct()
     * @covers \MrPrompt\Celesc\Shipment\File::getHeader()
     */
    public function getHeaderMustBeReturnHeaderAttribute()
    {
        $header     = new Header(
            $this->customerMock(),
            $this->dealershipMock(),
            $this->sequenceMock(),
            new DateTime()
        );

        $this->modifyAttribute($this->file, 'header', $header);

        $this->assertSame($header, $this->file->getHeader());
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\File::__construct()
     * @covers \MrPrompt\Celesc\Shipment\File::setHeader()
     */
    public function setHeaderMustBeReturnHeaderAttribute()
    {
        $header     = new Header(
            $this->customerMock(),
            $this->dealershipMock(),
            $this->sequenceMock(),
            new DateTime()
        );

        $result     = $this->file->setHeader($header);

        $this->assertNull($result);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\File::__construct()
     * @covers \MrPrompt\Celesc\Shipment\File::save()
     */
    public function saveMustBeCreateFile()
    {
        $this->modifyAttribute($this->file, 'cart', new \ArrayObject());
        
        $output = $this->file->save();

        $this->assertFileExists($output);
    }

    /**
     * @test
     * @covers \MrPrompt\Celesc\Shipment\File::__construct()
     * @covers \MrPrompt\Celesc\Shipment\File::read()
     */
    public function readMustBeCreateArrayOfObjects()
    {
        $result = $this->file->read();

        $this->assertTrue(is_array($result));
        $this->assertInstanceOf(Header::class, $result[0]);
        $this->assertInstanceOf(Cart::class, $result[1]);
        $this->assertInstanceOf(Footer::class, $result[2]);
    }
}
