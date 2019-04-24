<?
    error_reporting(E_ERROR); // Use to remove error echoing
    fetchOptions();

    function fetchOptions() {
        $response = ['response' => 'false']; // Initial Response

        $host = 'ilinkserver.cs.utep.edu';
        $user = 'mrsoto3';
        $pass = '*utep2019!';
        $dbname = 'team11_db';
        $conn = new mysqli($host, $user, $pass, $dbname);

        /* Production Code Block, Send queries through here and parse

        if ($conn->connect_errno || !isset($_GET['options'])) {
            echo json_encode($response);
            die();
        }

        $query = 'SELECT * from category_list;';
        $query = 'SELECT * from service_list;';
        $query = 'SELECT * from resource_list;';
        $query = 'SELECT * from zipcode_list;';
        $conn->query($query);

        $response = [
            'response' => $_GET['options']
        ];

        */


        //  Dummy Response
        $response = [
            'response' => true,
            'options' => $_GET['options'],
            'resources' => [
                0 => 'Homeless Shelter of El Paso',
                1 => 'Shelter Place of El Paso',
                2 => 'El Paso Dispensary',
                3 => 'Opportunity Organization'
            ],
            'categories' => [
                0 => 'Mental Health',
                1 => 'Health',
                2 => 'Housing',
                3 => 'Military'
            ],
            'services' => [
                0 => 'Cleaning',
                1 => 'Job Placement',
                2 => 'Community Cleaning',
                3 => 'Trash Handling'
            ],
            'zipcodes' => [
                79932,
                85643,
                29019,
                79989
            ]
        ];

        echo json_encode($response);
        $conn->close();
    }