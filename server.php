<?php

require_once(__DIR__.'/functions.php');

//controllo utente se registrato
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action === 'login') {
        $foundUser = login($_POST['username'], $_POST['password']);
        if ($foundUser === null) {
            header('Content-Type: application/json');
            $result = json_encode(['error' => 'Utente non trovato']);
            echo $result;
            return;
        }

        header('Content-Type: application/json');
        unset($foundUser['password']);
        $result = json_encode($foundUser);
        echo $result;
        return;
    }
}

//recuperare contenuto todo-list.json
$database = file_get_contents(__DIR__.'/todo-list.json');

//convertire la stringa in un array associativo
$todo_list = json_decode($database, true);

//recupera username e password da header
$headers = getallheaders();
$username = $headers['Username'] ?? $headers['username'];

//AGGIUNTA TODO
if(isset($_POST['add'])){
    // print_r($_POST);
    // die();
    $todo_list = addTodo($todo_list, $_POST);
}


//RIMOZIONE TODO
if(isset($_POST['delete'])){
    
    $todo_list = deleteTodo($todo_list, $_POST['delete']);
}


//MODIFICA TODO
if(isset($_POST['edit'])){
    
    $todo_list = editTodo($todo_list, $_POST);
}

//filtra i todo in base all'utente che ha effettuato l accesso - $todo è il singolo todo nel array passato al filtro
$filteredTodoList = array_filter($todo_list, function ($todo) use ($username) {
    return $todo['username'] === $username;
});
$todo_list = $filteredTodoList;

//modifica header della risposta in json
header('Content-Type: application/json');

echo json_encode($todo_list);

?>