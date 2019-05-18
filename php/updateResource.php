<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'error' => "Resource update failed.",
//    'params' => $params, // Testing output
];

if (isset($params) && isset($params['resource'])){
    $resource_data = $params['resource'];
    $resource_id = $resource_data['id'];
    $service_list = $resource_data['services'];
    $category_list = $resource_data['categories'];
    $contact_list = $resource_data['contactList'];

    if ($error = $dbconn->connect_error or $dbconn->error)
        $response['error'] = $error;
    else{
        updateResource($resource_data, $dbconn);
        updateServices($service_list, $resource_id, $dbconn);
        updateCategories($category_list, $resource_id, $dbconn);
        updateContacts($contact_list, $resource_id, $dbconn);

        $response['response'] = true;
        unset($response['message']);
    }
}

echo json_encode($response);
$dbconn->close();




function updateResource($resource, mysqli $conn){
    global $response;
    // Get resource variables and escape strings
    $id = $resource['id'];
    $name = $conn->real_escape_string($resource['name']);
    $street = $conn->real_escape_string($resource['street']);
    $zipcode = $conn->real_escape_string($resource['zipcode']);
    $phone = $conn->real_escape_string($resource['phone']);
    $website = $conn->real_escape_string($resource['website']);
    $email = $conn->real_escape_string($resource['email']);
    $description = $conn->real_escape_string($resource['description']);
    $requirements = $conn->real_escape_string($resource['requirements']);
    $documents = $conn->real_escape_string($resource['documents']);
    $opHours = $conn->real_escape_string($resource['opHours']);
    $admin_uname = $conn->real_escape_string($resource['lastUpdate_admin']);
    $insurance = ($resource['insurance']) ? 1 : 0;

    $sql = "CALL updateResource($id,'$name','$street', $zipcode, '$phone','$website','$email','$description','$requirements','$documents','$opHours', $insurance, '$admin_uname');";
    $conn->query($sql); // Execute Query
    if ($conn->error) $response['error'] = $conn->error;
}

function updateServices($service_list, $resource_id, mysqli $conn){
    global $response;
    $list_id = array();

    foreach($service_list as $service){
        $list_id[] = $service['id'];
    }

    $comma_seperated = implode(",", $list_id);

    $sql = "DELETE FROM " . DB_DATABASE . ".provides WHERE provides.resource_id = {$resource_id}" . ((count($service_list)) ? " AND provides.service_id NOT IN({$comma_seperated})" : "");
    $conn->query($sql);
    if ($conn->error) $response['error'] = $conn->error;

    linkServices($service_list, $resource_id, $conn);
}

function linkServices($service_list, $resource_id, mysqli $conn){
    global $response;
    foreach($service_list as $service){
        $service_id = $service['id'];
        $sql = "CALL linkService('$resource_id', '$service_id');";
        $conn->query($sql);
        if ($conn->error) $response['error'] = $conn->error;
    }
}

function updateCategories($category_list, $resource_id, mysqli $conn){
    global $response;
    $list_id = array();

    foreach($category_list as $categories)
        $list_id[] = $categories['id'];

    $comma_seperated = implode(",", $list_id);
    $sql = "DELETE FROM " . DB_DATABASE . ".belongs_to WHERE belongs_to.resource_id = {$resource_id}" . ((count($category_list)) ? " AND belongs_to.category_id NOT IN({$comma_seperated})" : "");
    $conn->query($sql);
    if ($conn->error) $response['error'] = $conn->error;

    linkCategories($category_list, $resource_id, $conn);
}

function linkCategories($category_list, $resource_id, mysqli $conn){
    global $response;
    foreach($category_list as $category){
        $category_id = $category['id'];
        $sql = "CALL linkCategory({$resource_id}, {$category_id});";
        $conn->query($sql);
        if ($conn->error) $response['error'] = $conn->error;
    }
}

function updateContacts($contact_list, $resource_id, mysqli $conn){
    global $response;
    $list_id = array();

    foreach($contact_list as $contact){
        $list_id[] = $contact['id'];
    }

    $comma_seperated = implode(",", $list_id);
   
    $sql = "DELETE FROM " . DB_DATABASE . ".contact WHERE contact.resource_id = {$resource_id}" . ((count($contact_list)) ? "  AND contact.contact_id NOT IN({$comma_seperated})": "");
    $conn->query($sql);
    if ($conn->error) $response['error'] = $conn->error;

    addContacts($contact_list, $resource_id, $conn);
}

function addContacts($contact_list, $resource_id, mysqli $conn){
    global $response;
    foreach ($contact_list as $contact) {
        $fname = $contact['fname'];
        $lname = $contact['lname'];
        $title = $contact['title'];
        $phone = $contact['phone'];
        $email = $contact['email'];

        $sql = "CALL addContact($resource_id, '$fname', '$lname', '$title', '$phone', '$email');";
        $conn->query($sql);
        if ($conn->error) $response['error'] = $conn->error;
    }
   
}
