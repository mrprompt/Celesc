<?php
/**
 * Exemplo de uso
 *
 * @author Thiago Paes <mrprompt@gmail.com>
 */
use MrPrompt\Celesc\Common\Base\Charge;
use MrPrompt\Celesc\Common\Base\Occurrence;

/* @var $vencimento \DateTime */
$vencimento = (new DateTime())->add(new DateInterval('P30D'));

/* @var $lista array */
return [
    [
        'cliente'           => '',
        'cobranca'          => Charge::ENERGY,
        'ocorrencia'        => Occurrence::INSERT,
        'identificador'     => 12345, // Identificador na Celesc
        'autorizacao'       => '123123', // não utilizado
        'vendedor'          => [
            'codigo'        => '234234242342341412412412ABCDFGEFE55', // Código na CELESC
            'nome'          => 'NOME DA EMPRESA',
            'documento'     => '74402168000160', // cnpj
            'nascimento'    => '08081974', // data de fundação - irrelevante
            'email'         => 'email@contato.com.br',
            'telefone1'     => '4811112121',
            'telefone2'     => '4822222222',
            'celular'       => '4833333333',
            'endereco'      => [
                'cidade'        => 'FLORIANOPOLIS',
                'uf'            => 'SC',
                'cep'           => '88010450',
                'logradouro'    => 'SALDANHA MARINHO',
                'numero'        => '0',
                'bairro'        => 'CENTRO',
                'complemento'   => '',
            ],
        ],
        'comprador'         => [
            'codigo'        => 1, // códido - gerado pela empresa
            'pessoa'        => 'F', // F - física / J - jurídica
            'nome'          => 'CLIENTE TESTE', // nome do cliente
            'documento'     => '73077077000133', // cpf/cnpj do cliente - opcional
            'nascimento'    => '08081974', // nascimento
            'email'         => 'email@vcliente.com.br', // email do cliente
            'telefone1'     => '4811112121',
            'telefone2'     => '4822222222',
            'celular'       => '4833333333',
            'endereco'      => [
                'cidade'        => 'FLORIANOPOLIS',
                'uf'            => 'SC',
                'cep'           => '88010450',
                'logradouro'    => 'SALDANHA MARINHO',
                'numero'        => '0',
                'bairro'        => 'CENTRO',
                'complemento'   => '',
            ],
        ],
        'parcelas'  => [
            [
                'vencimento' => '01082016',
                'valor'      => '000003645',
                'quantidade' => 1,
            ],
        ],
        'energia' => [
            'numero'        => '0000000000000', // Número da Unidade Consumidora
            'leitura'       => '02092016', // Data de leitura
            'vencimento'    => '01082016', // Data de Vencimento
            'concessionaria'=> '0001' // ID da concessionária
        ],
    ],
];