<?php

require 'inc/dbcon.php';


function updatePhoto($photoInput, $photoParams){

    global $conn;

    if(!isset($photoParams['id'])){

        return "Photo id not found in URL";
    }elseif($photoParams['id'] == null){

        return "Enter your name";
    }

    $photoId = mysqli_real_escape_string($conn, $photoParams['id']);

    $title = mysqli_real_escape_string($conn, $photoInput['title']);
    $url = mysqli_real_escape_string($conn, $photoInput['url']);

    if(empty(trim($title))){
        return 'Enter the title';
    }elseif(empty(trim($url))){
        return 'Enter the url';
    }
    else{
        $query = "UPDATE data SET title='$title', url='$url' WHERE id='$photoId' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if($result){
            header("HTTP/1.0 201 Updated");
            return "Photo updated successfully";
        }
    }
}

function storePhoto($photoInput) {
    global $conn;

    $title = mysqli_real_escape_string($conn, $photoInput['title']);
    $url = mysqli_real_escape_string($conn, $photoInput['url']);

    if(empty(trim($title))){
        return 'Enter the title';
    }elseif(empty(trim($url))){
        return 'Enter the url';
    }
    else{
        $query = "INSERT INTO data (albumId, title, url, thumbnailUrl) VALUES (1, '$title', '$url', 'placeholder')";
        $result = mysqli_query($conn, $query);

        if($result){
            header("HTTP/1.0 201 Created");
            return "Photo created";
        }
    }
}

function getPhotosList(){

    global $conn;
    $query = "SELECT * FROM data";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

        if(mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            return json_encode($res, JSON_PRETTY_PRINT);

        }else{
            return "No photos found";
        }
    }
}

function getPhoto($photoParams){
    global $conn;

    if($photoParams['id'] == null){
        return 'Enter your photo id';
    }

    $photoId = mysqli_real_escape_string($conn, $photoParams['id']);
    $query = "SELECT * FROM data WHERE id='$photoId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){
        if(mysqli_num_rows($result) == 1){
            $res = mysqli_fetch_assoc($result);
            return json_encode($res);
        }
        else
        {
            return "No photo found";
        }
    }
}

function deletePhoto($photoParams){

    global $conn;

    if(!isset($photoParams['id'])){

        return "Photo id not found in URL";
    }elseif($photoParams['id'] == null){

        return "Enter your name";
    }

    $photoId = mysqli_real_escape_string($conn, $photoParams['id']);

    $query = "DELETE FROM data WHERE id='$photoId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){
        return "Photo Deleted Successfully";
    }else{
        return "Photo not found";
    }
}
?>