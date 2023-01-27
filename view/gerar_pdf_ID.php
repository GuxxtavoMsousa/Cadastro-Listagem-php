<?php
    include_once("../banco/conexao.php");
    $conectar = getConnection();
?>

<?php 

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
?>

<?php

    $relatorio = "SELECT p.id_produto, p.nome_produto, p.preco_custo, p.preco_venda, p.quantidade, p.data_registro FROM produto p INNER JOIN fornecedor f on p.id_fornecedor = f.id_fornecedor WHERE id_produto = '$id' LIMIT 1";

    $resultado_relatorio = $conectar->prepare ($relatorio);
    $resultado_relatorio->execute();
    $linha = $resultado_relatorio->fetch(PDO::FETCH_ASSOC);

    $pagina = 
        "<html>
            <body>
                <h4>Informações de Relatorio</h4>
                ID do Produto: ".$linha['id_produto']."<br>
                Produto: ".$linha['nome_produto']."<br>
                Preço Custo: ".$linha['preco_custo']."<br>
                Preço Venda: ".$linha['preco_venda']."<br>
                Quantidade: ".$linha['quantidade']."<br>
            </body>
        </html>
        ";

//referenciar o DomPDF com namespace
        use Dompdf\Dompdf;

        //include autloader
        require("dompdf/vendor/autoload.php");

        //Criando a Instancia
        $dompdf = new DOMPDF();

        //defini o tipo de papel e sua orientação
        $dompdf->setPaper('A4','portrait');

        //Carrega seu HTML
        $dompdf->load_html(' <h1 style="text-align: center;"> Relatorio <br>' .$pagina.' ');

        //Renderizar o html
        $dompdf->render();

        //Exibir a página
        $dompdf->stream(
            "relatorio.pdf",
            array(
                "Attachment" => false //Para Realizar o dowload somente, alterar para true.
            )
        );
     ?>