<?php

function createConnection(){
    $connect = mysqli_connect('localhost', 'root', '', 'testForREST');
    return $connect;
}

function getPosts(){

    $posts = mysqli_query(createConnection(), 'SELECT * FROM posts;' );

    $foundPosts = [];
    foreach($posts as $post){
        $foundPosts[] = $post;
    }

    echo json_encode($foundPosts);
}

function getPost($id){

$posts = mysqli_query(createConnection(), "SELECT * FROM posts WHERE id='$id';");
$postToReturn = [];
foreach ($posts as $item){
    $postToReturn[] = $item;
}

    if(empty($postToReturn)){
        http_response_code(404);
        $response = [
            'status' => false,
            'message' => 'The post with this ID doesn\'t exist'
        ];
        echo json_encode($response);
    } else {
        echo json_encode($postToReturn);
    }
}

function addPost($request) {

    $title = $request['title'];
    $description = $request['description'];

    mysqli_query(createConnection(), "INSERT INTO `posts`(`title`, `description`) VALUES ('$title', '$description')");

    http_response_code(201);
    $response = [
        'status' => true,
        'message' => 'The post is created'
    ];

    echo json_encode($response);
}

function updatePost($data, $id){
    $title = $data->title;
    $description = $data->description;

    $posts = mysqli_query(createConnection(), "SELECT * FROM posts WHERE id='$id';");
    $postToReturn = [];
    foreach ($posts as $item){
        $postToReturn[] = $item;
    }

    if(empty($id) || empty($postToReturn)){
        http_response_code(404);
        $response = [
            'status' => false,
            'message' => 'Current ID doesn\'t exists'
        ];
        echo json_encode($response);
    }else{
        mysqli_query(createConnection(), "UPDATE posts SET title='$title', description='$description' WHERE id='$id';");
        $response = [
            'status' => true,
            'message' => 'Post is successfully updated'
        ];
        echo json_encode($response);
    }
}

function deletePost($id){

    $posts = mysqli_query(createConnection(), "SELECT * FROM posts WHERE id='$id';");
    $postToReturn = [];
    foreach ($posts as $item){
        $postToReturn[] = $item;
    }

    if(empty($postToReturn) || empty($id)){
        http_response_code(404);
        $response = [
            'status' => false,
            'message' => 'The post with this ID doesn\'t exist'
        ];
        echo json_encode($response);
    } else{
        mysqli_query(createConnection(), "DELETE FROM posts WHERE id='$id';");

        $response = [
            'status' => true,
            'message' => 'Post is successfully deleted'
        ];
        echo json_encode($response);
    }
}