<?
    error_reporting(E_ERROR); // Use to remove error echoing
    fetchOptions();

    function fetchOptions() {
        $response = ['response' => 'failed'];

        $uname = 'mrsoto3';
        $pass = '*utep2019!';
        $dbname = 'team11_db';
        $conn = new mysqli('mrsoto3@ilinkserver.cs.utep.edu', $uname, $pass, $dbname);

//        if ($conn->connect_errno || !isset($_GET['options'])) {
//            echo json_encode($response);
//            die();
//        }

        //$query = 'SELECT * from category_list;';
        //$conn->query($query);

        $response = [
            'response' => $_GET['options']
        ];

        echo json_encode($response);
        $conn->close();
    }
?>