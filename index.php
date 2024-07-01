<?php
ob_start();
require('./sheep_core/config.php');
$mysqli = new mysqli("127.0.0.1", "root", "", "loja", 3306);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Online-Cursos</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <?php

    $cart = new Ler();
    $cart->Leitura('carrinho');

    ?>

    <!---Topo do Site--->
    <div class="header">
        <p class="logo">Loja de Cursos</p>
        <div class="cart">
            <i class="fa fa-shopping-cart"></i>
            <p><?= $cart->getContaLinhas() > 0 ? $cart->getContaLinhas() : 0 ?></p>
        </div>
    </div>

    <!---Fim do Site--->

    <!---Conteudo do Site--->
    <div class="container">
        <!---Linha Produto do Site--->
        <div class="linha-produtos">
            <?php
            $ler = new Ler();
            $ler->Leitura('produtos', "ORDER BY data DESC");
            if ($ler->getResultado()) {
                foreach ($ler->getResultado() as $produto) {
                    $produto = (object) $produto;
            ?>
                    <!---Inicio Produto 1--->
                    <form action="filtros/criar.php" method="post">
                        <div class="corpoProduto">
                            <div class="imagProduto">
                                <img src="<?= HOME ?>/uploads/<?= $produto->capa ?>" alt="<?= $produto->nome ?>" class="produtoMiniatura" />
                            </div>
                            <div class="titulo">
                                <p><?= $produto->nome ?></p>
                                <h2><?= $produto->valor ?></h2>
                                <input type="hidden" name="id_produto" value="<?= $produto->id ?>">
                                <input type="hidden" name="valor" value="<?= $produto->valor ?>">
                                <button type="submit" class="button" name="addcarrinho">Adicionar ao Carrinho</button>
                            </div>
                        </div>
                    </form>
                    <!---Fim Produto--->
            <?php
                }
            }
            ?>
        </div>
        <!---Fim da Linha Produtos do Site--->

        <!---Lista de Pedidos do Site--->
        <div class="listaPedidos">
            <div class="topoCarrinho">
                <p>Meus Pedidos</p>
            </div>

            <!---Inicio da Lista de Pedidos no Carro--->
            <?php
            if ($cart->getContaLinhas() > 0) {
                foreach ($cart->getResultado() as $carts) {
                    $ler = new Ler();
                    $ler->Leitura('produtos', "WHERE id = :id ORDER BY data DESC", "id={$carts['id_produto']}");
                    if ($ler->getResultado()) {
                        foreach ($ler->getResultado() as $produto) {
                            $produto = (object) $produto;
            ?>
                            <div class="item-carro">
                                <div class="linha-da-imagem">
                                    <img src="<?= HOME ?>/uploads/<?= $produto->capa ?>" alt="<?= $produto->nome ?>" class="img-carro">
                                </div>
                                <p><?= $produto->nome ?></p>
                                <h2><?= $produto->valor ?></h2>
                                <form action="filtros/excluir.php" method="post">
                                    <input type="hidden" name="id_produto" value="<?= $produto->id ?>">
                                    <button type="submit" style="border: none; background:none;"><i class="fa fa-trash-o"></i></button>
                                </form>
                            </div>
                <?php
                        }
                    }
                }
            } else {
                ?>
                <div class="item-carro-vazio">Não tem nenhum item no Pedido!</div>
            <?php
            }
            ?>

            <?php
            $totalCarrinho = new Ler();
            $totalCarrinho->LeituraCompleta("SELECT SUM(valor) as total FROM carrinho");
            if ($totalCarrinho->getResultado()) {
                $totalCompras = number_format($totalCarrinho->getResultado()[0]['total'], 2, ',', '.');
            } else {
                $totalCompras = 0;
            }
            ?>


            <div class="rodape">
                <h3>Total</h3>
                <h2>€ <?= $totalCompras ?></h2>
            </div>

            <!---Fim da Lista de Pedidos do Site--->
        </div>
    </div>
    <!---Fim Conteudo do Site--->

</body>

</html>