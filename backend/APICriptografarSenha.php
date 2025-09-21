<?php

    require_once('dbConnect.php');
    mysqli_set_charset($conn, $charset);

    $result = mysqli_query($conn, 'SELECT id, senha FROM usuarios');

    while($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $senha = $row['senha'];
    

        if(strpos($senha, '$2y$') !== 0) {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE usuarios SET senha = '$hash' WHERE id = $id");
            echo "Senha do usuário ID $id criptografada.<br>";
        } else {
            echo "Usuário ID $id já está com a senha criptografada.\n";
        }
    }

    echo "Processo concluído!";
