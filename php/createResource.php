<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array
$response = [
    'response' => false,
    'message' => "Create resource failed.",
//    'params' => $params, // Testing output
];

if (isset($params) && isset($params['resource'])) {
    $resource_data = $params['resource'];
    $service_list = $resource_data['services'];
    $category_list = $resource_data['categories'];
    $contact_list = $resource_data['contactList'];

    if ($dbconn->error)
        $response['message'] = mysqli_connect_errno() . mysqli_connect_error();
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
$dbconn->close();



function addResource($resource, mysqli $conn){
    global $response;
    /* Retrieve resource values and escape strings to prevent SQL injection */
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
    $insurance = ($resource['insurance']) ? 1 : 0; // Does not need to be escaped since it resolves to boolean

    $sql = "CALL addResource('$name','$street', $zipcode, '$phone','$website','$email','$description','$requirements','$documents','$opHours', $insurance);";
    $getResourceIdSql = "SELECT MAX(resource_id) AS max_id FROM " . DB_DATABASE . ".resource";

    if ($conn->query($sql) && $rid_table = $conn->query($getResourceIdSql)) {
        $resource_id = mysqli_fetch_array($rid_table)['max_id'];
        $conn->query("CALL linkAdmin('{$admin_uname}','$resource_id')"); // link Admin to resource id
        if ($conn->error) $response['error'] = $conn->error;
    } 
    else {
        global $response;
        $response['error'] = $conn->error;
        $response['fail stage'] = "Adding Resource Failed";
        echo json_encode($response);
        $conn->close();
        die();
    }

    return $resource_id;
}

function linkServices($service_list, $resource_id, mysqli $conn){
    foreach($service_list as $service) {
        $service_id = $service['id'];

        $sql = "CALL linkService('$resource_id', '$service_id');";
        $conn->query($sql);
        if ($conn->error) {
            global $response;
            $response['error'] = $conn->error;
            $response['fail stage'] = "Linking Services Failed";
            echo json_encode($response);
            $conn->close();
            die();
        }
    }
}

function linkCategories($category_list, $resource_id, mysqli $conn) {
    foreach ($category_list as $category){
        $category_id = $category['id'];

        $sql = "CALL linkCategory('$resource_id', '$category_id');";
        $conn->query($sql);
        if ($conn->error) {
            global $response;
            $response['error'] = $conn->error;
            $response['fail stage'] = "Linking Categories Failed";
            echo json_encode($response);
            $conn->close();
            die();
        }
    }
}

function addContacts($contact_list, $resource_id, mysqli $conn){
    foreach ($contact_list as $contact) {
        /* Retrieve contact values and escape strings to prevent SQL injection */
        $fname = $conn->real_escape_string($contact['fname']);
        $lname = $conn->real_escape_string($contact['lname']);
        $title = $conn->real_escape_string($contact['title']);
        $phone = $conn->real_escape_string($contact['phone']);
        $email = $conn->real_escape_string($contact['email']);

        $sql = "CALL addContact($resource_id, '$fname', '$lname', '$title', '$phone', '$email');";
        $conn->query($sql);
        if ($conn->error) {
            global $response;
            $response['error'] = $conn->error;
            $response['fail stage'] = "Adding Contacts Failed";
            echo json_encode($response);
            $conn->close();
            die();
        }
    }

}
