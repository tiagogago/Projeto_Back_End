<?php

//PASTA GERAL DE IMAGENS E ARQUIVOS CAMINHO DO PAINEL A MODELOS######################
define('SHEEP_IMG', './../sheep_temas/sheep-imagens/');

define('SHEEP_IMG_LOGO', '../../../sheep_temas/sheep-imagens-logo/');

//IMAGENS PARA O LAYUT EXTERNO GERAL DE IMAGENS E ARQUIVOS CAMINHO DO PAINEL A MODELOS######################
define('SHEEP_IMG_PAINEL', './sheep_temas/sheep-imagens/');

//PASTA GERAL DE vídeos CAMINHO DO PAINEL A MODELOS######################
define('SHEEP_AUDIO', '../../../sheep_temas/sheep-midias/');

//AQUI IREI ADICIONAR VERSÃO E MODELO######################
define('SHEEP_VERSAO', 'Versão: [ 1.0.0 ] - <b>Atualizado dia: 01/10/2021</b>');

//AQUI TEXTO DA VERSÃO VERSÃO E MODELO######################
define('sheep', '<center><h2>Atenção!</h2></center><br>'
    . 'Este código de fonte é registrado e todos os direitos são reservados a empresa:<br> '
    . '<b>Maykon Silveira</b><br>'
    . '<p>Framework maykonsilveira.com.br e o código de fonte são patenteados. </p>');

function sheep_classes($sheepClasses)
{

    $sheepDiretorio = ['diretor', 'funcionarios',  'gerentes_operacionais', 'gerentes'];
    $sheepFiscaliza = null;

    foreach ($sheepDiretorio as $sheepNomeDiretorio) :
        if (!$sheepFiscaliza && file_exists(__DIR__ . '/' . "{$sheepNomeDiretorio}" . '/' . "{$sheepClasses}.php") && !is_dir(__DIR__  . '/' . "{$sheepNomeDiretorio}" . '/' . "{$sheepClasses}.php")) :
            include_once(__DIR__  . '/' . "{$sheepNomeDiretorio}" . '/' . "{$sheepClasses}.php");
            $sheepFiscaliza = true;
        endif;
    endforeach;

    if (!$sheepFiscaliza) :
        echo "Não foi possível incluir {$sheepClasses}.php";
        exit();
    endif;
}

spl_autoload_register("sheep_classes");

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
    //if( isset(filter_input(INPUT_SERVER, 'HTTPS', FILTER_SANITIZE_STRIPPED)) && filter_input(INPUT_SERVER, 'HTTPS', FILTER_SANITIZE_STRIPPED) == 'on' ) {
    $https = 'https://';
} else {
    $https = 'http://';
}

// DEFINE A URL DO SITE
define('HOME', $https . SHEEP_URL);
define('PASTA_DO_PAINEL', '/sheep_painel/');
define('URL_CAMINHO_PAINEL', HOME . '/' . PASTA_DO_PAINEL);
define('SHEEP_LAYOUT', 'site');


// PASTA DO MODELO E CHAMADAS;
//INCLUDE_PATCH = CAMINHO_TEMAS;
//REQUIRE_PATH = SOLICITAR_TEMAS;
define('CAMINHO_TEMAS', HOME . '/' . 'sheep_temas' . '/' . SHEEP_LAYOUT);
define('SOLICITAR_TEMAS', 'sheep_temas' . '/' . SHEEP_LAYOUT);
define('MODELO', 'sheep_temas' . '/' . SHEEP_LAYOUT);

$ipsheep = filter_input(INPUT_SERVER, 'SERVER_ADDR', FILTER_SANITIZE_STRIPPED);
if ($ipsheep == '::1' || $ipsheep == '127.0.0.1') {
    null;
} else {

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF8' . "\r\n";
    $Mensagem = "DOMINIO: {$_SERVER['SERVER_NAME']} <br> IP SERVIDOR: {$_SERVER['SERVER_ADDR']}";
    mail($DestinoEmail, $Assunto, $Mensagem, $headers);
}
