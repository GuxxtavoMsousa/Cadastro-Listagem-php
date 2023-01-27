<?php
    include '../banco/conexao.php';
    $conectar = getConnection();
?>

<?php

    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (empty($id))
    {
        echo "ID não informado";
        exit;
    }

    $sql = "SELECT arquivo FROM produto WHERE id_produto=:id_produto";
    $busca_arquivo = $conectar->prepare($sql);
    $busca_arquivo->bindParam(':id_produto', $id);
    $busca_arquivo->execute();

    $num_linhas=$busca_arquivo->rowCount();

if ($num_linhas != 0) {
  $sql = "DELETE FROM produto WHERE id_produto = :id_produto";
  $consulta = $conectar->prepare($sql);
  $consulta->bindParam(':id_produto', $id, PDO::PARAM_INT);
  
  if ($consulta->execute()){
        $dados_aluno = $busca_arquivo->fetch(PDO::FETCH_ASSOC);

        if(!empty($dados_aluno['arquivo'])){
            $pdf = $dados_aluno['arquivo'];
            $arquivo = "../uploads/".$pdf;
            
        if (file_exists($arquivo)){
            unlink($arquivo);
        }
        
  }

}

        header('Location: ../view/tela_listagem.php');
} else{
    
        echo "Erro ao remover";
        print_r($consulta->erroInfo());
    }

?>




<!--

$sql = "DELETE FROM aluno WHERE id_aluno = :id";
    $consulta = $conectar->prepare($sql);
    $consulta->bindParam(':id' , $id, PDO::PARAM_INT);

    if($consulta->execute())
    {

    -->