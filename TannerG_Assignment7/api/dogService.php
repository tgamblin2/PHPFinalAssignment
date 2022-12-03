<?php

require_once (__DIR__ . '/../db/DogAccessor.php');
require_once (__DIR__ . '/../entity/Dog.php');
require_once (__DIR__ . '/../utils/ChromePhp.php');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    doGet();
} else if ($method === "POST") {
    doPost();
} else if ($method === "DELETE") {
    doDelete();
} else if ($method === "PUT") {
    doPut();
}

function doGet() {
    // individual
    if (isset($_GET['dogid'])) { 
        // Individual gets not implemented.
        ChromePhp::log("Sorry, individual gets not allowed!");
    }
    // collection
    else {
        try {
            $da = new DogAccessor();
            $results = $da->getAllItems();
            $results = json_encode($results, JSON_NUMERIC_CHECK);
            echo $results;
        } catch (Exception $e) {
            echo "ERROR " . $e->getMessage();
        }
    }
}

function doDelete() {
    if (isset($_GET['dogid'])) { 
        $dogID = $_GET['dogid']; 
        // Only the ID of the item matters for a delete,
        // but the accessor expects an object, 
        // so we need a dummy object.
        $dogObj = new Dog($dogID, "dummyName", 1, "dummyBreed", 0);

        // delete the object from DB
        $da = new DogAccessor();
        $success = $da->deleteItem($dogObj);
        echo $success;
    } else {
        // Bulk deletes not implemented.
        ChromePhp::log("Sorry, bulk deletes not allowed!");
    }
}

// aka CREATE
function doPost() {
    if (isset($_GET['dogid'])) { 
        // The details of the item to insert will be in the request body.
        $body = file_get_contents('php://input');
        $contents = json_decode($body, true);

        // create a Dog object
        $dogObj = new Dog($contents['dogID'], $contents['dogName'], $contents['dogAge'], $contents['dogBreed'], $contents['trained']);

        // add the object to DB
        $da = new DogAccessor();
        $success = $da->addItem($dogObj);
        echo $success;
    } else {
        // Bulk inserts not implemented.
        ChromePhp::log("Sorry, bulk inserts not allowed!");
    }
}

// aka UPDATE
function doPut() {
    if (isset($_GET['dogid'])) { 
        // The details of the item to update will be in the request body.
        $body = file_get_contents('php://input');
        $contents = json_decode($body, true);

        // create a Dog object
        $dogObj = new Dog($contents['dogID'], $contents['dogName'], $contents['dogAge'], $contents['dogBreed'], $contents['trained']);

        // update the object in the  DB
        $da = new DogAccessor();
        $success = $da->updateItem($dogObj);
        echo $success;
    } else {
        // Bulk updates not implemented.
        ChromePhp::log("Sorry, bulk updates not allowed!");
    }
}
