<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Method: GET,POST,PUT,DELETE,OPTIONS');
header('Content-type: application/json');
header('Access-Control-Allow-Header: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];
$inputData = json_decode(file_get_contents("php://input"), true);

if($requestMethod == "GET" || $requestMethod == null){

    if(isset($_GET['id'])){

        $photo = getPhoto($_GET);
        echo $photo;
    }else{
        $customerList = getPhotosList();
        echo $customerList;
    }
}
elseif($requestMethod == "POST") {

    if(empty($inputData)){

        $storePhoto = storePhoto($_POST);
    }
    else {

        $storePhoto = storePhoto($inputData);
    }

    echo $storePhoto;
}
elseif($requestMethod == "PUT"){

    if(empty($inputData)){
        $updateCustomer = updatePhoto($_POST, $_GET);
    }
    else{
        $updateCustomer = updatePhoto($inputData, $_GET);
    }

    echo $updateCustomer;
}
elseif ($requestMethod == "DELETE"){

    $deletePhoto = deletePhoto($_GET);
    echo $deletePhoto;
}
else
    {
        $customerList = getPhotosList();
        echo $customerList;
    }
?>