<?php

include('config.php');

$params = json_decode(file_get_contents('php://input'), true); // Decode JSON parameters into array

$response = [ // Original JSON Response, defaults to failed
    'response' => false,
    'message' => "Resource update failed.",
];

if (isset($params) && isset($params['resource'])){
    $resource_data = $params['resource'];
    $resource_id = $resource_data['id'];
    $service_list = $resource_data['services'];
    $category_list = $resource_data['categories'];
    $contact_list = $resource_data['contactList'];

    if (mysqli_connect_errno()) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    else{
        updateResource($resource_data, $dbconn);
        updateServices($service_list, $resource_id, $dbconn);
        updateCategories($category_list, $resource_id, $dbconn);
        updateContacts($contact_list, $resource_id, $dbconn);
    }

    $response['response'] = true;
    $response['message'] = "Resource was updated successfully.";
    
    mysqli_close($dbconn);
}


function updateResource($resource, $conn){
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
    $insurance = $resource['insurance'];

    $sql = "CALL updateResource($id,'$name','$street', $zipcode, '$phone','$website','$email','$description','$requirements','$documents','$opHours', $insurance);";
    
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully.";
        $response['response'] = true;
        $response['message'] = "Resource was updated successfully.";
    } 
    else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

function updateServices($service_list, $resource_id, $conn){
    $list_id = array(); 
    $to_delete = array();

    foreach($service_list as $service){
        $list_id[] = $service['id'];
    }
    var_dump($list_id);

    $comma_seperated = implode(",", $list_id);
   
    $sql = "SELECT provides.service_id AS to_delete FROM provides WHERE provides.resource_id = $resource_id AND provides.service_id NOT IN($comma_seperated)";
    if($result = mysqli_query($conn, $sql)) {
       while($row = mysqli_fetch_array($result)) {
            $delete = "CALL deleteService($row[to_delete])";
            if(mysqli_query($conn, $delete)){
                echo "success";
            }
            else{
                
            }
        }
    }  
    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    linkServices($service_list, $resource_id, $conn);
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

function updateCategories($category_list, $resource_id, $conn){
    $list_id = array(); 
    $to_delete = array();

    foreach($category_list as $categories){
        $list_id[] = $service['id'];
    }
    var_dump($list_id);

    $comma_seperated = implode(",", $list_id);
   
    $sql = "SELECT belongs_to.category_id AS to_delete FROM belongs_to WHERE belongs_to.resource_id = $resource_id AND belongs_to.category_id NOT IN($comma_seperated);";
    if($result = mysqli_query($conn, $sql)) {
       while($row = mysqli_fetch_array($result)) {
            $delete = "CALL deleteCategory($row[to_delete])";
            if(mysqli_query($conn, $delete)){
                echo "success";
            }
            else{
                
            }
        }
    }  
    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    linkCategories($category_list, $resource_id, $conn);
}

function linkCategories($category_list, $resource_id, $conn){
    foreach($category_list as $category){
        $category_id = $category['id'];
        $sql = "CALL linkCategory('$resource_id', '$category_id');";
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

function updateContacts($contact_list, $resource_id, $conn){
    $list_id = array(); 
    $to_delete = array();

    foreach($contact_list as $contact){
        $list_id[] = $service['id'];
    }
    var_dump($list_id);

    $comma_seperated = implode(",", $list_id);
   
    $sql = "SELECT contact.contact_id AS to_delete FROM contact WHERE contact.resource_id = $resource_id AND contact.contact_id NOT IN($comma_seperated);";
    if($result = mysqli_query($conn, $sql)) {
       while($row = mysqli_fetch_array($result)) {
            $delete = "CALL deleteService($row[to_delete])";
            if(mysqli_query($conn, $delete)){
                echo "success";
            }
            else{
                
            }
        }
    }  
    else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    addContacts($contact_list, $resource_id, $conn);
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