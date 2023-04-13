<?php

//recuperare contenuto todo-list.json
$database = file_get_contents(__DIR__.'/todo-list.json');

//convertire la stringa in un array associativo
$todo_list = json_decode($database, true);


//modifica header della risposta in json
header('Content-Type: application/json');

echo json_encode($todo_list);

?>