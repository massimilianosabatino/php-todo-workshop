<?php

require_once(__DIR__.'/functions.php');

//recuperare contenuto todo-list.json
$database = file_get_contents(__DIR__.'/todo-list.json');

//convertire la stringa in un array associativo
$todo_list = json_decode($database, true);


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

//modifica header della risposta in json
header('Content-Type: application/json');

echo json_encode($todo_list);

?>