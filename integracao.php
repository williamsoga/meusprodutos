<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de pessoas </title>
</head>
<body>
     <div class="container">

     <header> 
        <h1> Cadastro de pessoas</h1>
     </header>


     <section>

     <?php 
      require_once 'conexao.php';
      require_once  'pessoa.php';

      $mensagem = '';
      $cadastroSucesso = false;

      $database = new BancoDeDados();
      $db = $database->obterConexao();

     
     if($db === null){
        $mensagem = "Erro:não foi possivel conectar ao banco de dados ";

     } else{
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pessoa = new Pessoa ($db);
            $pessoa->nome = $_POST['nome'];
            $pessoa->idade = $_POST['idade'];

            if($pessoa->criar()){
                $mensagem = "Pessoa '{$pessoa->nome}' cadastrada com sucesso";
                $cadastroSucesso = true;
            } else{
                $mensagem=" Falha ao cadastrar a pessoa.";
            }
        }
     }
     
     
     ?>
      <form action="" method="post" id="formCadastroPessoa">
        <label for="nome"> Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="idade"> Idade:</label>
        <input type="number" id="idade" name="idade" required>
        <input type="submit" value="cadastrar">

      </form>

     </section>
     </div>
     <script> 
     
     const mensagemDoPHP = "<?php echo $mensagem;?>"
     const cadastroFoiSucesso ="<?php echo json_encode($cadastroSucesso);?>"

     if(mensagemDoPHP){
        alert(mensagemDoPHP) ;


        if(cadastroFoiSucesso){
            document.getElementById('nome').value ='';
            document.getElementById('idade').value ='';

            docuemt.getElementById('nome').focus();
        }
     }
     
     </script>
</body>
</html>