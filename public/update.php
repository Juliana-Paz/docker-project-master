<?php
require_once "config.php";
 
$nome = $descricao = $preco = "";
$nome_err = $descricao_err = $preco_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
    $input_nome = trim($_POST["nome"]);
    if(empty($input_nome)){
        $nome_err = "Please enter a nome.";
    } elseif(!filter_var($input_nome, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nome_err = "Please enter a valid nome.";
    } else{
        $nome = $input_nome;
    }
    
    $input_descricao = trim($_POST["descricao"]);
    if(empty($input_descricao)){
        $descricao_err = "Please enter an descricao.";     
    } else{
        $descricao = $input_descricao;
    }
    
    $input_preco = trim($_POST["preco"]);
    if(empty($input_preco)){
        $preco_err = "Please enter the preco amount.";     
    } elseif(!ctype_digit($input_preco)){
        $preco_err = "Please enter a positive integer value.";
    } else{
        $preco = $input_preco;
    }

    if(empty($nome_err) && empty($descricao_err) && empty($preco_err)){
        // Prepare an update statement
        $sql = "UPDATE produto SET nome=?, descricao=?, preco=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssi", $param_nome, $param_descricao, $param_preco, $param_id);
            
            $param_nome = $nome;
            $param_descricao = $descricao;
            $param_preco = $preco;
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else{
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);
        
        $sql = "SELECT * FROM produto WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            $param_id = $id;
            
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    $nome = $row["nome"];
                    $descricao = $row["descricao"];
                    $preco = $row["preco"];
                } else{
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
        
        mysqli_stmt_close($stmt);
        
        mysqli_close($link);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
            color: #5034C4; 
        }
        .btn-primary {
            background-color: #5034C4; 
            border-color: #5034C4; 
        }
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary:active:hover {
            background-color: #2C1D72; 
            border-color: #2C1D72;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Atualizar Produto</h2>
                    </div>
                    <p>Por favor, insira as novas informações do produto.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nome_err)) ? 'has-error' : ''; ?>">
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo $nome; ?>">
                            <span class="help-block"><?php echo $nome_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descricao_err)) ? 'has-error' : ''; ?>">
                            <label>Descrição</label>
                            <textarea name="descricao" class="form-control"><?php echo $descricao; ?></textarea>
                            <span class="help-block"><?php echo $descricao_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($preco_err)) ? 'has-error' : ''; ?>">
                            <label>Preço</label>
                            <input type="text" name="preco" class="form-control" value="<?php echo $preco; ?>">
                            <span class="help-block"><?php echo $preco_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

