<?
    fetchOptions();

    function fetchOptions() {
        $response = ['response' => 'failed'];
        if (isset($_GET['options'])) {
            $response = [
                'response' => $_GET['options']
            ];
            echo json_encode($response);
        }
        else {
            echo json_encode($response);
        }
    }
?>