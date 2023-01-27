<?php
    include_once '../banco/conexao.php';
    $conectar = getConnection();
?>



<?php       
    $id = isset($_GET['id']) ? (int) $_GET['id'] : null; // pega o ID da URL

    /* Selecione o "curso" da  "tabela curso" juntando com a "tabela aluno" onde a coluna "id_curso" da duas tabelas
    são iguais e o "id_aluno" é igual ao id passado pelo "GET". */

    $consulta = "SELECT f.nome from fornecedor f INNER JOIN produto p on f.id_fornecedor = p.id_fornecedor WHERE p.id_produto = :id";
   
    $conexao_atualizar = $conectar->prepare($consulta);
    $conexao_atualizar->execute(array(':id' => $id));

    $linha = $conexao_atualizar->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html> 
    <head>
        <title> Atualização </title>  
        <meta charset="utf-8">

        <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <style>
    body {
      background-image: url('fundo_login.jpg');
      background-repeat: no-repeat;
      background-attachment: fixed;  
      background-size: cover;     
    }

    .caixalogin{
        background-color: white;
        opacity: 80%;
        width: 300px;
        height: 250px
    }
    #caixalogin{
        
        border-radius: 25px;
    }

    .form-control{
        width: 300px;
    }

    .col-sm-7{
        width: 100%;
        float:left;
    }
    </style>
    
    </head>

<body>

<br><br><br>

<center>

<div class="caixalogin" id="caixalogin">
<br><br>

<h1> Atualizar </h1> <br>

<form action="../model/atualizacao.php" method="POST" enctype="multipart/form-data">
    <div class="col-sm-7">

    <labe  for="description" class="col-sm-5 col-form-label"> Escolha um Novo Fornecedor: </label>
        <select name="fornecedor" id="form-curso" class="form-control form-control-sm" required>
            <option value="">
                <?php echo $linha['nome'];?>
            </option>

            <?php
                $sql = $conectar->query("SELECT * FROM fornecedor ORDER BY nome ASC");

                $listagem = $sql->fetchAll(PDO::FETCH_ASSOC);

                foreach($listagem as $exibir) {
                    ?>
                    
                    <option value="<?php echo $exibir['id_fornecedor']?>">
                        <?php echo $exibir['nome']; 
                        ?>
                        </option>

                        <?php   
                            }
                        ?>

                        </select>

                        <div class="form-group row">
                            <label for="description" class="col-sm-5 col-form-label">NF: </label>
                            <input class="form-control" type="file" id="formFileMultiple" name="arquivo">
                        </div>

                        <input type="hidden" name="idProduto" value="<?php echo $_GET['id'];?>">
                        </div>

                    <br>
                    <p><input type="submit" name="editar" value="ATUALIZAR"></p>
                    
                        </form>
</div>

<br><br><br>
<a href="tela_listagem.php"> 
   <img src="../imagens/voltar.png">
</a>

</center>


</body>

</html>