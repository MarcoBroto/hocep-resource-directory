<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array
$response = [ 'response' => false,'message' => "Create resource failed."];

if (isset($params) && isset($params['resource'])) {
    $resource_data = $params['resource'];
    $service_list = $resource_data['services'];
    $category_list = $resource_data['categories'];
    $contact_list = $resource_data['contactList'];

    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    else{
        $resource_id = addResource($resource_data, $db);
        linkServices($service_list, $resource_id, $db);
        linkCategories($category_list, $resource_id, $db);
        addContacts($contact_list, $resource_id, $db);
    }
    
    mysqli_close($db);
}

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
    $insurance = $resource['needInsurance'];

    $sql = "CALL addResource('$name','$street', $zipcode, '$phone','$website','$email','$description','$requirements','$documents','$opHours', $insurance);";
    $maxResourceId = "SELECT MAX(resource_id) AS max_id FROM resource;";
    
    if (mysqli_query($conn, $sql) && $max = mysqli_query($conn, $maxResourceId)) {
        echo "New record created successfully.";
        $response['response'] = true;
        $response['message'] = "Resource was created successfully.";
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $row = mysqli_fetch_array($max);
    $resource_id = $row['max_id'];

    return $resource_id;
}

function linkServices($service_list, $resource_id, $conn){
    foreach($service_list as $service){
        $service_id = $service['id'];
        $sql = "CALL linkService('$resource_id', '$service_id');";
        if (mysqli_query($conn, $sql)) {
            echo "linked service successfully.";
            $response['response'] = true;
            $response['message'] = "Resource was created successfully.";
        } 
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
}

function linkCategories($category_list, $resource_id, $conn){
    foreach ($category_list as $category){
        $category_id = $category['id'];
        $sql = "CALL linkCategory('$resource_id', '$category_id');";
        if (mysqli_query($conn, $sql)) {
            echo "linked category successfully.";
            $response['response'] = true;
            $response['message'] = "Resource was created successfully.";
        } 
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
            echo "added contact successfully.";
            $response['response'] = true;
            $response['message'] = "Resource was created successfully.";
        } 
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

}

echo json_encode($response); // Send JSON response

?>