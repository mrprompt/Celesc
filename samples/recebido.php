<?php
/**
 * Exemplo de uso
 *
 * Leitura do arquivo de Retorno
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
use MrPrompt\Celesc\Received\File;
use MrPrompt\ShipmentCommon\Base\Sequence;

require __DIR__ . '/bootstrap.php';

/* @var $lista array */
$lista      = require __DIR__ . '/cart.php';

try {
    /* @var $importer \MrPrompt\ShipmentCommon\Base\Sequence */
    $sequence   = new Sequence('063');

    /* @var $importer \MrPrompt\Celesc\Received\File */
    $importer   = new File($sequence, __DIR__);
    $cart       = $importer->getCart();

    /* @var $item \MrPrompt\Celesc\Received\Partial\Detail */
    foreach ($cart as $item) {
        echo 'Unidade  : ', $item->getConsumerUnity()->getNumber(), PHP_EOL;
        echo 'Parcela  : ', PHP_EOL;
        echo '         # ', ($item->getParcel()->getKey() + 1), PHP_EOL;
        echo '        R$ ', number_format($item->getParcel()->getPrice(), 2, ',', '.'), PHP_EOL;
        echo 'Vencimento ', $item->getParcel()->getMaturity()->format('d/m/Y'), PHP_EOL;
        echo PHP_EOL, PHP_EOL;
    }
} catch (\InvalidArgumentException $ex) {
    echo sprintf('Erro: %s in file: %s - line: %s', $ex->getMessage(), $ex->getFile(), $ex->getLine()), PHP_EOL;
}
