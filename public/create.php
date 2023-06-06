<?php
// Including config file
require_once "config.php";
 
// Defining and initializing variables
$nome = $descricao = $preco = "";
$nome_err = $descricao_err = $preco_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate nome
    $input_nome = trim($_POST["nome"]);
    if(empty($input_nome)){
        $nome_err = "Por favor, insira o nome.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_err = "Por favor, insira um nome válido.";
    } else{
        $nome = $input_nome;
    }
    
    // Validate descricao
    $input_descricao = trim($_POST["descricao"]);
    if(empty($input_descricao)){
        $descricao_err = "Por favor, insira uma descrição.";     
    } else{
        $descricao = $input_descricao;
    }
    
    // Validate preco
    $input_preco = trim($_POST["preco"]);
    if(empty($input_preco)){
        $preco_err = "Por favor, insira o preço.";     
    } elseif(!ctype_digit($input_preco)){
        $preco_err = "Por favor, insira um preço válido.";
    } else{
        $preco = $input_preco;
    }
    
    // Check input errors before inserting in database
    if(empty($nome_err) && empty($descricao_err) && empty($preco_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO produto (nome, descricao, preco) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_nome, $param_descricao, $param_preco);
            
            // Set parameters
            $param_nome = $nome;
            $param_descricao = $descricao;
            $param_preco = $preco;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
            color: #5034C4; /* Cor base */
        }
        .btn-primary {
            background-color: #5034C4; /* Cor base */
            border-color: #5034C4; /* Cor base */
        }
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary:active:hover {
            background-color: #2C1D72; /* Cor mais escura */
            border-color: #2C1D72; /* Cor mais escura */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Por favor, preencha o formulário com as informações do produto</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nome_err)) ? 'has-error' : ''; ?>">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>">
                            <span class="help-block"><?php echo $nome_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descricao_err)) ? 'has-error' : ''; ?>">
                            <label>Descriçao</label>
                            <textarea name="descricao" class="form-control"><?php echo $descricao; ?></textarea>
                            <span class="help-block"><?php echo $descricao_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($preco_err)) ? 'has-error' : ''; ?>">
                            <label>Preço</label>
                            <input type="text" name="preco" class="form-control" value="<?php echo $preco; ?>">
                            <span class="help-block"><?php echo $preco_err;?></span>
                        </div>
                        <button type="submit" class="btn btn-primary" value="Enviar">Enviar</button>
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

