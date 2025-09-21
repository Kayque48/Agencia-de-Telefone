<?php

    header('Content-Type: application/json');

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $api_token = $_POST['api_token'];

        $token_correto = 'ListaUser';

        if($api_token !== $token_correto) {
            echo json_encode(['auth_token'=> false]);
            exit;
        }

        require_once 'dbConnect.php';

        mysqli_set_charset($conn, $charset);

        $query = 'SELECT id, nome, telefone, email FROM usuarios';

        $stmt = mysqli_prepare($conn, $query);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        mysqli_stmt_bind_result($stmt, $id, $nome, $telefone, $email);

        $response = array();

        if (mysqli_stmt_num_rows($stmt) > 0) {
            while (mysqli_stmt_fetch($stmt)) {
                array_push($response, array("id" => $id, "nome" => $nome, "telefone" => $telefone, "email" => $email));
            }
        }

        echo json_encode($response);
    }