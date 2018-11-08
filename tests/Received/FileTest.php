<?php
namespace MrPrompt\Celesc\Tests\Received;

use MrPrompt\Celesc\Common\Base\Cart;
use MrPrompt\Celesc\Received\Partial\Footer;
use MrPrompt\Celesc\Received\Partial\Header;
use MrPrompt\Celesc\Received\File;
use MrPrompt\Celesc\Common\Util\ChangeProtectedAttribute;
use MrPrompt\Celesc\Tests\Mock;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

/**
 * Signup test case.
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

        $file = <<<'EOF'
101000000000200928597599700EMPRESAO63                    000125072016R$    000175  NOMEDAEMPRESA                                                2000001
20000024154033000002990250720169011307O6302737924154033       006                                                                               000002
900009568579                                                                                                                                    002149

EOF;

        file_put_contents(self::$root->url() . '/rCEL1.063', $file);
    }

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->file = new File($this->sequenceMock(), self::$root->url());
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
     */
    public function readFile()
    {
        $result = $this->file->getAll();

        $this->assertTrue(is_array($result));
        $this->assertInstanceOf(Header::class, $result[0]);
        $this->assertInstanceOf(Cart::class, $result[1]);
        $this->assertInstanceOf(Footer::class, $result[2]);
    }
}
