
<?php
	  include_once '../banco/conexao.php';
  	$conectar = getConnection();
?>

<?php
  $contarproduto = $conectar->prepare("SELECT * FROM produto");
  $contarproduto->execute();

  $contagem = $contarproduto->fetchAll(); // Pega todos os registros de uma vez.
?>


<!DOCTYPE html>
<html> 
 	<head>
 		<title> LISTAGEM </title>  
 	    <meta charset="utf-8"> 
    <!--  <meta http-equiv="refresh" content="3">  Atualiza a página à cada nº segundos -->

  <!-- CSS only -->
  <link href="teste1.css" rel="stylesheet">
    
	</head>
  <style>
#btn-menu{
    color: white; 
    background-color: black;
    /*border: 1px solid yellow;*/
    font-family: arial;
    height: 30px;
    /*margin-left: -5px;*/
    padding-top: 0px;
	margin: 0
  }

  #btn-menu:hover{
      color: black;
      background-color: white;
      border: 0px;
    }

</style>


<body> 

<div style="background-color: black; padding-left: 30px; padding-bottom: -10px; height: 30px;">
    <a href="tela_cadastro.php"> 
    <button id="btn-menu"> Cadastrar Aluno </button> </a> 
    <a href="tela_listagem.php">
    <button id="btn-menu"> Listagem 1 </button></a>
    <a href="tela_listagem2.php">
    <button id="btn-menu"> Listagem 2 </button></a>
    <a href="contato.php">
    <button id="btn-menu"> Contate-nos </button></a>
  </div>



<br><br><br>

<center>

<h1> LISTAGEM </h1> 

  <?php
    // A variável recebe o nome do produto, que foi inserido no campo de pesquisa.
    $nomeproduto = isset($_GET['nomeProduto']) ? $_GET['nomeProduto'] : null;
    /* $nomeproduto = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    */

    date_default_timezone_set('America/Sao_Paulo');
      $today = date('d/m/y')." | ".date('H:i:s');; // Data formatada
    echo $today;
  ?>

</center>

<br>
<!-- CAMPO DE PESQUISA -->
<form action="tela_listagem.php" method="GET"> <!-- GET, pega o valor através da url. -->
        <center><p> 
        <div class="input-group"> 

          <input type="text" name="nomeProduto" placeholder="Nome do produto" class="form-control" id="campoPesquisa">
          <input type="submit" value="Pesquisar" class="btn btn-primary">

        </div>
        </p>
      </form>

<br><br>

<center>
<!-- <h2>Inner Join</h2> <br> -->

<?php
    
      //$pesquisa =  $nomeproduto['nomeproduto'] . "%";
      $pesquisa =  $nomeproduto . "%";

        //SQL para selecionar os registros
       $sql = "SELECT p.id_produto, p.nome_produto, p.preco_custo, p.preco_venda, p.quantidade, p.data_registro,p.arquivo, f.nome FROM produto p INNER JOIN fornecedor f on p.id_fornecedor = f.id_fornecedor WHERE nome_produto LIKE :produto ORDER BY id_produto ASC";

       /*
        $sql = "SELECT a.id_produto, a.nome_produto, a.idade, a.data_nascimento, a.matricula, c.curso, a.data_registro FROM produto a INNER JOIN curso c on a.id_curso = c.id_curso ORDER BY id_produto ASC WHERE nome_produto LIKE :produto";
       */

       $consulta = $conectar->prepare($sql);

       $consulta->bindParam(':produto',$pesquisa, PDO::PARAM_STR);

       $consulta->execute();
       if (!$consulta) {
         die("Erro no Banco!");
       }
       
       
  /*     echo' 
                 <a href="gerar_pdf_BUSCA.php?nome=<?php echo $nomeproduto["nome_produto"]?>" >
                     <img src="../imagens/ID.png">
                 </a>'
          ; 
  */
       echo '<div class="tabela">';  
       echo '<table class="tabelas">';
       echo "<thead>";
       echo "<tr>";
       echo "<th width='1%'><center> ID </center></th>";
       echo "<th width='1%'><center> Produto </center></th>";
       echo "<th width='1%'><center> Preço Custo </center></th>"; 
       //echo "<th width='1%'><center> Data de Nascimento </center></th>"; 
       echo "<th width='1%'><center> Preço Venda </center></th>"; 
       echo "<th width='3%'><center> Quantidade </center></th>"; 
       echo "<th width='1%'> Fornecedor </th>"; 
       echo "<th width='1%'><center> Data de Registro </center></th>";
       echo "<th width='1%'> NF </th>"; 
       echo "<th width='5%'><center> Ação </center></th>";             
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";

       while ($exibir = $consulta->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr>";
          echo "<th><center>" . $exibir['id_produto'] . "</center></th>";
          echo "<td><center>" . $exibir['nome_produto'] . "</center></td>";
          echo "<td><center>" . $exibir['preco_custo'] . "</center></td>";
          //echo "<td><center>" . $exibir['data_nascimento'] . "</center></td>";
          echo "<td><center>" . $exibir['preco_venda'] . "</center></td>";
          //echo "<td><center>" . utf8_encode($exibir['curso']) . "</center></td>";
          echo "<td><center>" . $exibir['quantidade'] . "</center></td>";
          echo "<td><center>" . $exibir['nome'] . "</center></td>";
          echo "<td><center>" . $exibir['data_registro'] . "</center></td>";

          $ext = pathinfo($exibir['arquivo'],PATHINFO_EXTENSION); // Pega a extensão do meu arquivo
          if ($ext == 'pdf') {
            echo "<td><center> <a href='../uploads/" . $exibir["arquivo"] . "'> <img src='../imagens/pdf.png' id='btn-certidao'> </a> </center></td>";
          } else if (($ext == 'jpg') || ($ext == 'jpeg') || ($ext == 'png') ) {
            echo "<td><center> <img src='../uploads/".$exibir['arquivo']."'style='width:80px;'> </center></td>";
        }else if ($ext != 'pdf') {
            echo "<td><center> <i>Arquivo não enviado</i></center></td>";
          }
        ?>
        <td>
          <center>
            <a href="tela_atualizacao.php?id=<?php echo $exibir["id_produto"]?>">
            <img src="../imagens/atualização.png"  id="btn-acao">                 
            </a>

            <a href="../model/deletar.php?id=<?php echo $exibir["id_produto"]?>">
            <img src="../imagens/excluir.png" id="btn-acao">
            </a>


            <!-- Gera Relatório do produto -->  
        <a href="gerar_pdf_ID.php?id=<?php echo $exibir["id_produto"]?>" name="relatorio">
              <img src="../imagens/ID.png">
        </a>

          </center>
        </td>

    <?php
          echo "</tr>";
        }
        
        echo "</tbody>";        
        echo "</table>";
        echo "</div>";
        
    ?>

      <br><br>

        <!-- Botão Relatório -->  
        <a class="centraliazar" href="gerar_pdf.php" name="relatorio">
            <img src="../imagens/relatorio.png">
        </a>


        <!-- Botão Imprimir -->
        <a type="button" onclick="window.print()" name="btn_imprimir">
            <img src="../imagens/imprimir.png">
        </a>

        <?php
          //$nome = isset($_GET['nomeproduto']) ? (string) $_GET['nomeproduto'] : null;
          //echo "$nome";
        ?>

      <a class="Relatorio" href="gerar_pdf_BUSCA.php?nomeProduto=<?php echo $nomeproduto; ?>" name="busca_produtos">
        <img src="../imagens/pessoas.png">
      </a>

</center>



</body>

</html>
