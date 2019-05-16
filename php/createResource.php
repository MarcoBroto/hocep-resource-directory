<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array
$response = [ 'response' => false,'message' => "Create resource failed."];
//$response['params'] = $params;

if (isset($params) && isset($params['resource'])) {
    $resource_data = $params['resource'];
    $service_list = $resource_data['services'];
    $category_list = $resource_data['categories'];
    $contact_list = $resource_data['contactList'];

    if (mysqli_connect_errno()) {
        $response['message'] = mysqli_connect_error();
    }
    else{
        $resource_id = addResource($resource_data, $dbconn);
        if (isset($resource_id)) {
            linkServices($service_list, $resource_id, $dbconn);
            linkCategories($category_list, $resource_id, $dbconn);
            addContacts($contact_list, $resource_id, $dbconn);
            $response['response'] = true;
            $response['new_id'] = $resource_id;
            unset($response['message']);
        }
        else {
            $response['response'] = false;
            $response['message'] = 'Resource links failed.';
        }
    }
}

echo json_encode($response);
mysqli_close($dbconn);



function addResource($resource, $conn){
    $name = $resource['name'];
    $street = $resource['street'];
    $zipcode = $resource['zipcode'];
    $phone = $resource['phone'];
    $website = $resource['website'];
    $email = $resource['email'];
    $description = $resource['description'];
    $requirements = $resource['requirements'];
    $documents = $resource['documents'];
    $opHours = $resource['opHours'];
    $insurance = ($resource['insurance']) ? 1 : 0;

    $sql = "CALL addResource('$name','$street', $zipcode, '$phone','$website','$email','$description','$requirements','$documents','$opHours', $insurance);";
    $maxResourceId = "SELECT MAX(resource_id) AS max_id FROM " . DB_DATABASE . ".resource";
    
    if (mysqli_query($conn, $sql) && $max = mysqli_query($conn, $maxResourceId)) {

    } 
    else {
        global $response;
        echo json_encode($response);
        $conn->close();
        die();
    }

    $row = mysqli_fetch_array($max);
    $resource_id = $row['max_id'];

    return $resource_id;
}

function linkServices($service_list, $resource_id, $conn){
    foreach($service_list as $service) {
        $service_id = $service['id'];
        $sql = "CALL linkService('$resource_id', '$service_id');";
        if (mysqli_query($conn, $sql)) {

        } else {
            global $response;
            echo json_encode($response);
            $conn->close();
            die();
        }
    }
}

function linkCategories($category_list, $resource_id, $conn) {
    foreach ($category_list as $category){
        $category_id = $category['id'];
        $sql = "CALL linkCategory('$resource_id', '$category_id');";
        if (mysqli_query($conn, $sql)) {

        } 
        else {
            global $response;
            echo json_encode($response);
            $conn->close();
            die();
        }
    }
}

function addContacts($contact_list, $resource_id, $conn){
    foreach ($contact_list as $contact) {
        $fname = $contact['fname'];
        $lname = $contact['lname'];
        $title = $contact['title'];
        $phone = $contact['phone'];
        $email = $contact['email'];

        $sql = "CALL addContact($resource_id, '$fname', '$lname', '$title', '$phone', '$email');";
        if (mysqli_query($conn, $sql)) {

        } 
        else {
            global $response;
            echo json_encode($response);
            $conn->close();
            die();
        }
    }

}

?>