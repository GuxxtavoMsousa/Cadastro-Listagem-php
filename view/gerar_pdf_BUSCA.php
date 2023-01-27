<?php
   include_once("../banco/conexao.php");
   $conectar = getConnection();
?>

<?php
	// pega o ID da URL
	$nome = isset($_GET['nomeProduto']) ? (string) $_GET['nomeProduto']."%" : null;
?>

<?php	
	
		$relatorio = "SELECT p.id_produto, p.nome_produto, p.preco_custo, p.preco_venda, p.quantidade,f.nome, p.data_registro FROM produto p INNER JOIN fornecedor f on p.id_fornecedor = f.id_fornecedor WHERE nome_produto LIKE '$nome' ";

	$resultado_relatorio = $conectar->prepare ($relatorio);
  	$resultado_relatorio->execute();
		
	$html = '<table border=1 width=80%>';
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= '<td width="5%"><center> ID </center></td>';
	$html .= '<td width="15%"><center> Produto </center></td>';
	$html .= '<td width="12%"><center> Preço Custo </center></td>';
	$html .= '<td width="12%"><center> Preço Venda </center></td>';
	$html .= '<td width="10%"><center> Fornecedor </center></td>';
	$html .= '<td width="15%"><center> Data de Registro </center></td>';
	$html .= '</tr>';
	$html .= '</thead>';

while ($linha = $resultado_relatorio->fetch(PDO::FETCH_ASSOC)) {
	$html .='<tbody>';
	$html .= '<tr><td> <center>'.$linha['id_produto'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['nome_produto'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['preco_custo'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['preco_venda'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['nome'] .'  </center></td>';
	$html .= '<td>  <center>'.$linha['data_registro'] .'  </center></td>';
	$html .='</tbody>';	
}
	$html .='</table>';

//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require("dompdf/vendor/autoload.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();
	
	// Defini o tipo de Papel e sua Orientacao
	$dompdf->setPaper('A4','portrait');

	// Carrega seu HTML
	$dompdf->load_html(' <h1 style="text-align: center;"> Relatório da Pesquisa <br>' . $html .'	');


	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"relatorio.pdf", 
		array(
			"Attachment" => false //Para realizar o download somente, alterar para true.
		)
	);


?>