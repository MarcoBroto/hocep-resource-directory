<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Resource update failed.",
//    'params' => $params,
];

if (isset($params) && isset($params['resource'])){
    $resource_data = $params['resource'];
    $resource_id = $resource_data['id'];
    $service_list = $resource_data['services'];
    $category_list = $resource_data['categories'];
    $contact_list = $resource_data['contactList'];

    if (mysqli_connect_errno()) {
        $response['message'] = mysqli_connect_errno();
        echo json_encode($response);
        $dbconn->close();
        die();
    }
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




function updateResource($resource, $conn){
    global $response;
    $id = $resource['id'];
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
    $admin_uname = $resource['admin_username'];

    $sql = "CALL updateResource($id,'$name','$street', $zipcode, '$phone','$website','$email','$description','$requirements','$documents','$opHours', $insurance);";
    
    if (mysqli_query($conn, $sql)) {
        $sql = "SELECT admin_id FROM " . DB_DATABASE . ".admin WHERE username='{$admin_uname}'";
        if ($admin_id = mysqli_query($conn, $sql)->fetch_array()['admin_id']) {
            $sql = "UPDATE " . DB_DATABASE . ".updates ('Date', admin_id) VALUES (DATE(NOW()), {$admin_id}) WHERE updates.resource_id={$id}";
            $response['sql'] = $sql;
            if (mysqli_query($conn, $sql)) {

            }
            else {
                $response['message'] = mysqli_connect_error();
            }
        }
        else {
            $response['message'] = mysqli_connect_error();
        }
    }
    else {
        $response['message'] = mysqli_connect_error();
    }

}

function updateServices($service_list, $resource_id, $conn){
    global $response;
    $list_id = array();
    $to_delete = array();

    foreach($service_list as $service){
        $list_id[] = $service['id'];
    }

    $comma_seperated = implode(",", $list_id);

    $sql = "DELETE FROM " . DB_DATABASE . ".provides WHERE provides.resource_id = {$resource_id}" . ((count($service_list)) ? " AND provides.service_id NOT IN({$comma_seperated})" : "");
    if($result = mysqli_query($conn, $sql)) {

    }  
    else{
        $response['message'] = mysqli_connect_error();
    }
    linkServices($service_list, $resource_id, $conn);
}

function linkServices($service_list, $resource_id, $conn){
    global $response;
    foreach($service_list as $service){
        $service_id = $service['id'];
        $sql = "CALL linkService('$resource_id', '$service_id');";
        if (mysqli_query($conn, $sql)) {

        } 
        else {
            $response['message'] = mysqli_connect_error();
        }
    }
}

function updateCategories($category_list, $resource_id, $conn){
    global $response;
    $list_id = array(); 
//    $to_delete = array();

    foreach($category_list as $categories){
        $list_id[] = $categories['id'];
    }

    $comma_seperated = implode(",", $list_id);
   
    $sql = "DELETE FROM " . DB_DATABASE . ".belongs_to WHERE belongs_to.resource_id = {$resource_id}" . ((count($category_list)) ? " AND belongs_to.category_id NOT IN({$comma_seperated})" : "");
    if($result = mysqli_query($conn, $sql)) {

    }  
    else{
        $response['message'] = mysqli_connect_error();
    }
    linkCategories($category_list, $resource_id, $conn);
}

function linkCategories($category_list, $resource_id, $conn){
    global $response;
    foreach($category_list as $category){
        $category_id = $category['id'];
        $sql = "CALL linkCategory({$resource_id}, {$category_id});";
        if (mysqli_query($conn, $sql)) {

        } 
        else {
            $response['message'] = mysqli_connect_error();
        }
    }
}

function updateContacts($contact_list, $resource_id, $conn){
    global $response;
    $list_id = array(); 
    $to_delete = array();

    foreach($contact_list as $contact){
        $list_id[] = $contact['id'];
    }

    $comma_seperated = implode(",", $list_id);
   
    $sql = "DELETE FROM " . DB_DATABASE . ".contact WHERE contact.resource_id = {$resource_id}" . ((count($contact_list)) ? "  AND contact.contact_id NOT IN({$comma_seperated})": "");
    if($result = mysqli_query($conn, $sql)) {

    }  
    else{
        $response['message'] = mysqli_connect_error();
    }
    addContacts($contact_list, $resource_id, $conn);
}

function addContacts($contact_list, $resource_id, $conn){
    global $response;
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
            $response['message'] = mysqli_connect_error();
        }
    }
   
}
?>