
<?php
  include '../banco/conexao.php';
  $conectar = getConnection();
?>

<?php
function data($data){
    return date("d/m/Y",strtotime($data));
    // Y = Ano inteiro (ex: 2020)
    // y = Ano pelo metade (ex: 20) 
}

if ($_POST['cadastrar']) {
    

    $sql = 'INSERT INTO produto (nome_produto, preco_custo, preco_venda, quantidade, data_registro,id_fornecedor, arquivo) 
            VALUES (:nome_produto, :preco_custo, :preco_venda, :quantidade, :data_registro,:id_fornecedor,:arquivo)';

    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, "pt_BR");
            
    $agora = getdate();

    $a = $agora["year"];
    $m = $agora["mon"];//utf8_encode(strftime("%B"));
    $d = $agora["mday"];
 
    

    $nome = $_POST["nome_produto"];
   // $idade = $_POST["idade"];
    $preco_custo = $_POST["preco_custo"];
    $preco_venda = $_POST["preco_venda"];
    $quantidade = $_POST["quantidade"];
    $data_registro = $d . "/" . $m . "/" . $a;
    $id_fornecedor = $_POST["id_fornecedor"];
/*
    //Calculo da idade
    $dn = substr($data_nascimento,0,2);
    $mn = substr($data_nascimento,3,2);
    $an = substr($data_nascimento,6,4);

    $idade = ($d >= $dn && $m >= $mn) ? ($x = $a-$an) : $x = ($a-$an)-1;
    //Fecha calculo da idade
*/

    // Recebendo os dados do arquivo
    $nome_arquivo = $_FILES['arquivo']['name'];
    $tmp_arquivo = $_FILES['arquivo']['tmp_name'];

/*
    $_FILES['arquivo']['size']; //Armazena o tamanho do arquivo
    $_FILES['arquivo']['type']; //Armazena o tipo do arquivo
*/

    //Diretório onde o arquivo vai ser salvo
    $diretorio = empty($_FILES['arquivo']['name']) ? null : '../uploads/';
    $pasta = $diretorio . $nome_arquivo;

    
if(!filter_var($idade,FILTER_VALIDATE_INT)){
    $erro[] = "Idade inválida.";
}

//Tratamento de erros das validações
if (!empty($erros)) {
    foreach ($erros as $erro) {
        echo "<i>".$erro."</i>";
    }
} 

 
    $inserir = $conectar->prepare($sql);
    $inserir->bindParam(':nome_produto', $nome);
    $inserir->bindParam(':preco_custo', $preco_custo);
    $inserir->bindParam(':preco_venda', $preco_venda);
    $inserir->bindParam(':quantidade', $quantidade);
    $inserir->bindParam(':data_registro', $data_registro);
    $inserir->bindParam(':id_fornecedor', $id_fornecedor);
    $inserir->bindParam(':arquivo', $pasta);
   


    if($inserir->execute()){
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta)) {
            header("location: ../view/tela_cadastro.php");
        } else {
            header("location: ../view/tela_cadastro.php");
        }
        //echo 'Salvo com sucesso!';        
       // header("location:../view/tela_cadastro.php");
    }else{
        header("location: ../view/tela_cadastro.php");
        //echo ' Erro ao salvar!';
        //die($stmt->execute());
    }




} else {
    header("Location: ../view/tela_listagem.php");
}

    

?>
