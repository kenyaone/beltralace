<?php

namespace App\Controllers;

use \PDO;
use \PDOException;
use App\Models\Datatable;
use App\Helpers\HelperFunctions;

class EnquiryFileController
{
    public $enquiry = null;
    public $datatable = null;
    public $data = null;



    public static function create($enquiry_id, $file_name)
    {
        $connection =  DatabaseController::connect();
        try {
            $query = $connection->prepare("INSERT INTO enquiry_files(enquiry_id, enquiry_id) VALUES(?, ?, ?, ?)");
            $query->execute(array($enquiry_id, $file_name));
            DatabaseController::disconnect();
            return (object) array(
                'status' => 1,
                'message' => 'Enquiry file created',
            );

        } catch (PDOException $e) {
            error_log($e->getMessage() .": ".$e->getTraceAsString());
            echo json_encode(array(
                'status' => 0,
                'message' => $e->getMessage() .": ".$e->getTraceAsString()
            ));
        }
    }
}
