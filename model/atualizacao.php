<?php	
    include_once '../banco/conexao.php';
  	$conectar = getConnection();
?>

<?php

	if(isset($_POST['editar'])){

    $id_produto = $_POST['idProduto'];     
    $id_fornecedor = $_POST['fornecedor'];

    
    $nome_arquivo=$_FILES['arquivo']['name'];
    //$nome_arquivo = isset($_FILES['arquivo']['name']) ?  $_FILES['arquivo']['name'] : null;
    $tmp_arquivo=$_FILES['arquivo']['tmp_name'];
    //$tmp_arquivo = isset($_FILES['arquivo']['tmp_name']) ?  $_FILES['arquivo']['tmp_name'] : null;


    
    /* Lista ARQUIVOS */
    $pesquisa = "SELECT arquivo FROM produto WHERE id_produto=:id";
    $resultado = $conectar->prepare($pesquisa);
    $resultado->bindParam(':id', $id_produto, PDO::PARAM_INT);
    $resultado->execute();

    // Verificar se encontrou o registro no banco de dados
    if (($resultado) and ($resultado->rowCount() != 0)) {
        $mostrar = $resultado->fetch(PDO::FETCH_ASSOC);
    }

    
    //Diretório onde o arquivo vai ser salvo
   $diretorio = '../uploads/';
   $pasta = $diretorio . $nome_arquivo;



    // Verificando os campos se estao preenchidos
    if( empty($id_produto) || empty($id_fornecedor) || empty($nome_arquivo)  || empty($tmp_arquivo) ) {
            echo "<font color='red'>Campo Obrigatorio.</font><br/>";
    } else {
                //atualizado dados na tabela
        $sql = "UPDATE produto SET id_fornecedor = :id_fornecedor,arquivo = :arquivo WHERE id_produto = :id";

        $consulta = $conectar->prepare($sql);

        $consulta->bindparam(':id', $id_produto);
        $consulta->bindparam(':id_fornecedor', $id_fornecedor);
        $consulta->bindparam(':arquivo', $pasta);



        if ($consulta->execute()) {

            if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $diretorio . $nome_arquivo)){ 
            $arquivo_anterior = "../uploads/". $mostrar['arquivo'];
            
            if(file_exists($arquivo_anterior)){
                unlink($arquivo_anterior);
            }
    
            header("Location: ../view/tela_listagem.php");
                   
            }else{
                echo "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            }
    
    
            //header("Location: ../view/tela_listagem.php");
        }  // IF execute()     
    
    
    
    
    
    } /* FECHA else ANTES do UPDATE */
    } // FECHA 1º IF
    
    ?>