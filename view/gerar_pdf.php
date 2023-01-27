<?php
	  include_once '../banco/conexao.php';
  	$conectar = getConnection();
?>


<?php
  $contarAluno = $conectar->prepare("SELECT * FROM produto");
  $contarAluno->execute();

  $contagem = $contarAluno->fetchAll(); // Pega todos os registros de uma vez.
?>


<?php

$sql = $conectar->query ("SELECT p.id_produto, p.nome_produto, p.preco_custo, p.preco_venda, p.quantidade, p.data_registro FROM produto p INNER JOIN fornecedor f on p.id_fornecedor = f.id_fornecedor ORDER BY id_produto ASC");

$html = '<h1> Relatorio dos Produtos</h1>';  
$html .= "<table border=1 width=80%>";
$html .= "<thead>";
$html .= "<tr>";
$html .= "<th width='5%'><center> ID </center></th>";
$html .= "<th width='18%'><center> Produto </center></th>";
$html .= "<th width='5%'><center> Preço Custo </center></th>"; 
//$html = "<th width='1%'><center> Data de Nascimento </center></th>"; 
$html .= "<th width='5%'><center> Preço Venda </center></th>"; 
$html .= "<th width='12%'><center> Quantidade </center></th>";  
$html = "<th width='1%'><center> Data de Registro </center></th>";    
$html .= "</tr>";
$html .= "</thead>";


while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
   $html .= "<tbody>";
   $html .= "<tr><td> <center>" . $linha['id_produto'] . "</center></td>";
   $html .= "<td> <center>" . $linha['nome_produto'] . "</center></td>";
   $html .= "<td> <center>" . $linha['preco_custo'] . "</center></td>";
   $html .= "<td> <center>" . $linha['preco_venda'] . "</center></td>";
   $html .= "<td> <center>" . $linha['quantidade'] . "</center></td></tr>";
   $html .= '</tbody>';
}
$html .='</table>';

use Dompdf\Dompdf;

//include autloader
require("dompdf/vendor/autoload.php");

//Criando a Instancia
$dompdf = new DOMPDF();

//Carrega seu HTML
$dompdf->loadHtml($html);

$dompdf->setPaper('A4','portrait');

$dompdf->render();


$dompdf->stream(
    "relatorio.pdf",
    array(
        "Attachment" => false //Para Realizar o dowload somente, alterar para true.
    )
);
 ?>