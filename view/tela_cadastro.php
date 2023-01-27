<?php
    include_once '../banco/conexao.php';
    $conectar = getConnection();
?>

<!DOCTYPE html>
<html>
<head>
	<title> Cadastro </title>
	<meta charset="utf-8"> 

  <!-- CSS only -->
  <link href="teste.css" rel="stylesheet">
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

<h1> Cadastro de Produtos </h1> <br>

<form action="../model/cadastro.php" method="POST" enctype="multipart/form-data">

	<div class="caixa1">
    <div class="caixa2">
	 <div class="caixa3">

		<div class="centralizar">

			<label for="description" class="">Nome: </label>

			<div class="centralizar">
			<input type="text" name="nome_produto" class="input"> <br>
			</div>
		</div>
<!--
		<div class="form-group row">
			<label for="description" class="">Idade: </label>

			<div class="col-sm-7">
			<input type="number" name="idade" min="18" max="60" placeholder="Apartir de 18 anos" class="input"> <br>
			</div>
		</div>
-->
		<div class="centralizar">
			<label for="description" class="">Preço Custo: </label>

			<div class="">
			<input type="number" name="preco_custo" class="input"> <br>
			</div>
		</div>

		<div class="centralzar">
			<label for="description" class="">Preço Venda: </label>

			<div class="col-sm-7">
			<input type="number" name="preco_venda" class="input"> <br>
			</div>
		</div>

		<div class="centralizar">
			<label for="description" class="">Quantidade: </label>

			<div class="col-sm-7">
			<input type="number" name="quantidade" class="input"> <br>
			</div>
		</div>

			<div class="centralizar">
			<label for="description" class="">Fornecedor: </label>

			<div class="col-sm-7">
			<select name="id_fornecedor" class="input" required>
		        <option value="">Selecione um Fornecedor</option>

                <?php
                $sql = $conectar->query("SELECT * FROM fornecedor ORDER BY nome ASC");
                $listagem = $sql->fetchAll(PDO::FETCH_ASSOC);

                foreach($listagem as $exibir){
                ?>

                <option value="<?php echo $exibir['id_fornecedor']?>">
                    <?php
                        echo $exibir ['nome'];
                        //echo utf8_encode($exibir['curso']);
                    ?>

                </option>

                <?php
                } // Fecha o FOREACH.
                ?>

		        
		    </select>

			</div>
		</div>
	
	<div class="centralizar">
			<label for="description" class=""> Nota Fiscal: </label>
			<input class="form-control" type="file" id="formFileMultiple" name="arquivo">
				</div>
	</div>
			
	
			

	</div>

	<br>    
	<div class="botao">   
		<input type="submit" name="cadastrar" value="Cadastrar" class="input"> <!-- Botão CADASTRAR -->   
		<input type="reset" name="limpar" value="Limpar" class="input"> <!-- Botão LIMPAR -->   
	</div>
</div>




</form>


</center>




</body>






</html>
