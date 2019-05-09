<?

include('config.php');
error_reporting(E_ERROR); // Use to remove error echoing

fetchOptions();

function fetchOptions() {
    $response = ['response' => 'false']; // Initial Response

    //TODO: establish connection and query

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
            0 => [
                'name' => 'Homeless Shelter of El Paso',
                'id' => 0
            ],
            1 => [
                'name' => 'Shelter Place of El Paso',
                'id' => 1
            ],
            2 => [
                'name' => 'El Paso Dispensary',
                'id' => 2
            ],
            3 => [
                'name' => 'Opportunity Organization',
                'id' => 3
            ]
        ],
        'categories' => [
            0 => [
                'name' => 'Mental Health',
                'id' => 0
            ],
            1 => [
                'name' => 'Health',
                'id' => 1
            ],
            2 => [
                'name' => 'Housing',
                'id' => 2
            ],
            3 => [
                'name' => 'Military',
                'id' => 3
            ]
        ],
        'services' => [
            0 => [
                'name' => 'Cleaning',
                'id' => 1
            ],
            1 => [
                'name' => 'Job Placement',
                'id' => 2
            ],
            2 => [
                'name' => 'Community Service',
                'id' => 3
            ],
            3 => [
                'name' => 'Environmental Service',
                'id' => 4
            ],
        ],
        'zipcodes' => [
            79932,
            85643,
            29019,
            79989
        ]
    ];

    echo json_encode($response);
    //$conn->close();
}