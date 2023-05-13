<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *, Authorization");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Credentials: true");

header('Content-type:json/application');
require ('actions.php');

$method = $_SERVER['REQUEST_METHOD'];
$customUri = $_SERVER['REQUEST_URI'];
$params = explode('/', $customUri);
$uri = $params[1];

if (isset($params[2])){
    $id = $params[2];
} else{
    $id = '';
}

$request = $_POST;
$patchRequest = file_get_contents('php://input');
$data = json_decode($patchRequest);


if($method === 'GET' && $uri === 'posts'){
    getPosts();
} elseif ($method === 'GET' && $uri === 'post'){
    getPost($id);
} elseif ($method === 'POST' && $uri === 'addpost') {
    addPost($request);
} elseif ($method === 'PATCH' && $uri === 'updatepost'){
    updatePost($data, $id);
} elseif ($method === 'DELETE' && $uri === 'deletepost'){
    deletePost($id);
}
else {
    echo json_encode('Something else');
}