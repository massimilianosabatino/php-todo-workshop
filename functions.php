<?php

//funzione per aggiungere un todo
function addTodo($todo_list, $params){

    $todo_list_bak = $todo_list;

    $todo = [
        'text' => $params['todo'],
        'done' => false,
        'username' => $params['username'],
    ];

    $todo_list[] = $todo;

    //salva nel file json in formato json
    saveFile('todo-list.json', json_encode($todo_list_bak), json_encode($todo_list));

    return $todo_list;
};

//funzione per cancellare un todo
function deleteTodo($todo_list, $index){
    
    $todo_list_bak = $todo_list;

    unset($todo_list[$index]);

    //salva nel file json in formato json
    saveFile('todo-list.json', json_encode($todo_list_bak), json_encode($todo_list));

    return $todo_list;
};

//funzione per modificare un todo
function editTodo($todo_list, $params){

    $todo_list_bak = $todo_list;

    $index = $params['edit'];

    $todo_list[$index] = array(
        'text' => $params['text'],
        'done' => false,
);

    //salva nel file json in formato json
    saveFile('todo-list.json', json_encode($todo_list_bak), json_encode($todo_list));

    return $todo_list;
};

//funzione salvataggio todo in file
function saveFile($file, $old_data = null, $new_data = null){

    //effettua backup
    if($old_data !== null){

        if(!is_dir(__DIR__.'/bk')){
            mkdir(__DIR__.'/bk');
        }

        $fileName = __DIR__.'/bk/'.date("YmdHis").'-'.$file;
        file_put_contents($fileName, $old_data);
    }

    if($new_data !== null){
        $fileName = __DIR__.'/'.$file;
        file_put_contents($fileName, $new_data);
    }
};

//funzione login utente
function login($username, $password) {
    $usersFile = file_get_contents(__DIR__ . '/users.json');
    $users = json_decode($usersFile, true);

    $foundUser = null;
    for ($i = 0; $i < count($users); $i++) {
        $user = $users[$i];
        if ($user['username'] === $username && $user['password'] === $password) {
            $foundUser = $user;
            break;
        }
    }

    return $foundUser;
}

?>