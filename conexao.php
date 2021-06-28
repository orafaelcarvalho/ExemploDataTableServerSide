<?php

    $con = mysqli_connect("127.0.0.1", "root", "", "cesta_emergencial", "3308");

    if (!$con) {

?>

        <div class='container alert alert-danger' role='alert'>
            <strong>Erro! </strong>
            Não foi possível conectar ao banco de dados. Entre em contato com o administrador do sistema.
        </div>

<?php

        exit;
    }
    
?>