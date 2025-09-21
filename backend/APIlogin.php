<?php

    header("Content-Type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $api_token = $_POST['api_token'];

        $token_correto = 'LoginUser';

        if($token_correto !== 'LoginUser') {
            echo json_encode(['auth_token' => false]);
            exit;
        }
        
        $usuario = $_POST['api_usuario'];
        $senha = $_POST['api_senha'];

        require_once('dbConnect.php');

        mysqli_set_charset($conn, $charset);

        $query = 'SELECT senha FROM usuarios WHERE nome = "' . $usuario . '" OR id = "' . $usuario . '"';

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        mysqli_stmt_bind_result($stmt, $hash);

        $response = array();

        if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_fetch($stmt);
        if (password_verify($senha, $hash)) {
            $response['logou'] = true;
        } else {
            $response['logou'] = false;
        }
    } else {
        $response['logou'] = false;
    }

    echo json_encode($response);

} else {
    $response['auth_token'] = false;
    echo json_encode($response);
}
