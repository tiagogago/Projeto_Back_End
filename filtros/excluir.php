<?php
ob_start();
require('../sheep_core/config.php'); // Fechar parêntese

$del = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT); // Corrigir FILTER_VALIDADE_INT para FILTER_VALIDATE_INT

if (isset($del)) {
    $excluir = new Excluir;
    $excluir->Remover('carrinho', "WHERE id_produto = :id", "id={$del}"); // Adicionar aspas duplas em torno da chave "id"
    if ($excluir->getResultado()) {
        header("Location: " . HOME . "/index.php?sucesso=true");
    } else {
        header("Location: " . HOME . "/index.php?erro=true");
    }
}
