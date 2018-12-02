<?php
/**
 * Exemplo de uso
 *
 * Criação do arquivo de remessa
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
use MrPrompt\Celesc\Factory;
use MrPrompt\ShipmentCommon\Base\Cart;
use MrPrompt\ShipmentCommon\Base\Sequence;
use MrPrompt\Celesc\Shipment\File;
use MrPrompt\ShipmentCommon\Base\Dealership;

require __DIR__ . '/bootstrap.php';

/* @var $today \DateTime */
$today      = DateTime::createFromFormat('dmY', '01082016');

/* @var $cart \MrPrompt\ShipmentCommon\Base\Cart */
$cart       = new Cart();

/* @var $lista array */
$lista      = require __DIR__ . '/cart.php';

foreach ($lista as $linha) {
    /* @var $item \MrPrompt\Celesc\Gateway\Shipment\Partial\Detail */
    $item = \MrPrompt\Celesc\Factory::createDetailFromArray($linha);

    echo 'Comprador: ', $item->getPurchaser()->getName(), PHP_EOL;
    echo 'Parcelas: ', PHP_EOL;

    foreach ($item->getParcels() as $parcel) {
        echo '      # ', ($parcel->getKey() + 1), PHP_EOL;
        echo '     R$ ', number_format($parcel->getPrice(), 2, ',', '.'), PHP_EOL;
        echo '    Qtd ', $parcel->getQuantity(), PHP_EOL;
    }

    echo PHP_EOL, PHP_EOL;

    $cart->addItem($item);
}

try {
    /* @var $sequence \MrPrompt\ShipmentCommon\Base\Sequence */
    $sequence   = new Sequence('0104');

    /* @var $customer \MrPrompt\ShipmentCommon\Base\Customer */
    $customer   = Factory::createCustomerFromArray(array_shift($lista)['vendedor']);

    /* @var $dealership \MrPrompt\ShipmentCommon\Base\Dealership */
    $dealership = new Dealership();
    $dealership->setCode('0001');

    /* @var $exporter \MrPrompt\Celesc\Shipment\File */
    $exporter   = new File($customer, $dealership, $sequence, $today, __DIR__);

    $exporter->setCart($cart);

    $result = $exporter->save();

    echo sprintf('Arquivo %s gerado com sucesso no diretório %s', basename($result), dirname($result)), PHP_EOL;

    $readed = $exporter->read();

    echo sprintf('Arquivo %s lido com sucesso', basename($result)), PHP_EOL;
} catch (\InvalidArgumentException $ex) {
    echo sprintf('Erro: %s in file: %s - line: %s', $ex->getMessage(), $ex->getFile(), $ex->getLine()), PHP_EOL;
}
