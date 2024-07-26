<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
error_reporting(0);

include "connection.php";

$response = [
    'message' => [],
    'data' => [],
    'status' => '',
    'error_file'=>''
];

$errorLogFile = 'error_log.txt';
file_put_contents($errorLogFile, '');

try {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $uploadDir = 'uploads_csv/';
    
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    
        $uploadFile = $uploadDir . basename($_FILES['csv_file']['name']);
        
        if (move_uploaded_file($_FILES['csv_file']['tmp_name'], $uploadFile)) {
            $data = [];
            if (($handle = fopen($uploadFile, "r")) !== FALSE) {
                $header = fgetcsv($handle, 1000, ',');
    
                // Read the data rows
                while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $data[] = array_combine($header, $row);
                }
                fclose($handle);
               
                // Save data to tables here
               
                $result = saveData($data, $conn);
               
                if ($result) {
                    setResponse(["CSV File Uploaded Successfully!"], $result, "success");
                } else {
                    setResponse(["Something went wrong, Please try again!"], [], "error");
                }
                // sendResponse();
            } else {
                setResponse(["Unable to open the file."], [], "error");
                // sendResponse();
            }
        } else {
            setResponse(["File upload failed."], [], "error");
            // sendResponse();
        }
    } else {
        setResponse(["No file uploaded or upload error."], [], "error");
        // sendResponse();
    }
} catch (\Throwable $th) {
    setResponse([$th->getMessage()], [], "error");
    // sendResponse();
}

function saveData($data, $conn) {
    $status = true;
    if (!empty($data) && count($data) > 0) {
        foreach ($data as $employee) {
           
            $saveAgencyId = saveAgencyDetails($employee, $conn);
            $saveEmployeeId = saveEmployeeDetails($employee, $conn);
            $saveAllData = saveAllData($employee, $saveAgencyId, $saveEmployeeId, $conn);
            
            if (!$saveAllData) {
                $status = false;
            }
        }
    }
    return $status;
}

function saveAgencyDetails($data, $conn) {
    if ($data) {
        $AgencyName = $data['AgencyName']?trim($data['AgencyName']) :"";
        $AgencyTask = $data['AgencyTask']?trim($data['AgencyTask']): "";
        if(!$AgencyName || !$AgencyTask){
            setResponse(["Invalid agency details AgencyName and AgencyTask is required"], [], "error");
            // sendResponse();
            
        }else{

            $AgencyLocation = $data['AgencyLocation'] ?? "";
            $sql = "INSERT INTO agency_details SET agency_name='$AgencyName', agency_task='$AgencyTask', agency_location='$AgencyLocation'";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                return mysqli_insert_id($conn);
            } else {
                setResponse(["Error from save agency details"], [], "error");
                // sendResponse();
                
            }

        }
    }
}

function saveEmployeeDetails($data, $conn) {
    if ($data) {
        $EmployeeID = $data['EmployeeID']?trim($data['EmployeeID']): "";
        $EmployeeName = $data['EmployeeName']?trim($data['EmployeeName']): "";
        if(!$EmployeeID || !$EmployeeName){

            setResponse(["Invalid employee details EmployeeID and EmployeeName is required"], [], "error");
        }else{

            $sql = "INSERT INTO employee_details SET employee_id='$EmployeeID', employee_name='$EmployeeName'";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                return mysqli_insert_id($conn);
            } else {
                setResponse(["Error from save employee details"], [], "error");
                // sendResponse();
                return false;
            }

        }
    }
}

function saveAllData($data, $saveAgencyId, $saveEmployeeId, $conn) {
    if ($data && $saveAgencyId && $saveEmployeeId) {

        $ProductionDate = dateFormat(trim($data['ProductionDate'])) ?? NULL;
        $PatientName = $data['PatientName'] ? escape_string($conn, trim($data['PatientName'])) : NULL;
        $MRN = $data['MRN'] ? escape_string($conn, trim($data['MRN'])) : "";
        $AssessmentType = ($data['AssessmentType'] != "NA") ? trim($data['AssessmentType']) : NULL;

        $VisitDate = NULL;
        if (isset($data['VisitDate']) && $data['VisitDate'] != "NA") {
            $VisitDate = dateFormat(trim($data['VisitDate'])) ?? NULL;
        }

        $InsuranceName = $data['InsuranceName'] ? escape_string($conn, trim($data['InsuranceName'])) : "";
        $InformationSource = $data['InformationSource'] ? escape_string($conn, trim($data['InformationSource'])) : "";

        $sql = "INSERT INTO upload_data SET employee_id='$saveEmployeeId', agency_id='$saveAgencyId', patient_name='$PatientName', mrn='$MRN', assessment_type='$AssessmentType', insurance_name='$InsuranceName', information_source='$InformationSource', production_date='$ProductionDate', visit_date='$VisitDate'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            return mysqli_insert_id($conn);
        } else {
            setResponse(["Error from save all data"], [], "error");
            // sendResponse();
            return false;
        }
    }else{
        setResponse(["Error from save all data"], [], "error");
    }
}

function dateFormat($date) {
    if ($date) {
        return date('Y-m-d', strtotime($date));
    }
}

function validateDate($test_date) {
    DateTime::createFromFormat('m/d/Y', $test_date);
    $date_errors = DateTime::getLastErrors();
    $errors = "";
    if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) {
        $errors = 'Date format is wrong. System accepts this format: m/d/Y';
    }
    if ($errors) {
        setResponse([$errors], [], "error");
        // sendResponse();
        return $errors;
    } else {
        return false;
    }
}

function setResponse($message = [], $data = [], $status = "") {
    global $response;
    $response['message'] = array_merge($response['message'],$message);
    logErrors($message);
    $response['data'] = $data;
    $response['status'] = $status;
    
}

function logErrors($errors) {
    global $errorLogFile;
    $errorLog = fopen($errorLogFile, 'a');
    foreach ($errors as $error) {
        fwrite($errorLog, $error . PHP_EOL);
    }
    fclose($errorLog);
}

function sendResponse() {
    // global $response;   
    // echo json_encode($response);
    exit();
}

function escape_string($conn, $string) {
    return mysqli_real_escape_string($conn, $string);
}

$response['error_file']=$errorLogFile;
echo json_encode($response);
exit();
?>
