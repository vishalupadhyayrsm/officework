<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');
include_once("dbconfig.php");
include_once("api.php");
// Retrieve the request endpoint
$uri = explode("/", $_SERVER["REQUEST_URI"]);
$apidata = $uri[3];
$endpoint = $uri[4];
// echo $endpoint;
$result = array();

// function callChatGPT($apiKey, $prompt)
// {
//     $url = 'https://api.openai.com/v1/chat/completions';

//     $data = [
//         'model' => 'gpt-4', // or 'gpt-3.5-turbo'
//         'messages' => [
//             ['role' => 'system', 'content' => 'You are a helpful assistant.'],
//             ['role' => 'user', 'content' => $prompt],
//         ],
//         'max_tokens' => 150,
//     ];

//     $headers = [
//         'Authorization: Bearer ' . $apiKey,
//         'Content-Type: application/json',
//     ];

//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, 1);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

//     $response = curl_exec($ch);

//     if (curl_errno($ch)) {
//         $error_msg = curl_error($ch);
//         curl_close($ch);
//         return 'Error: ' . $error_msg;
//     }

//     curl_close($ch);

//     $responseData = json_decode($response, true);
//     return $responseData['choices'][0]['message']['content'];
// }

switch ($endpoint) {
    case "invoice":
        $stmt = $conn->prepare("SELECT * FROM `invoice`");
        // $stmt->bindParam(':sid', $sid);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($result);
        echo json_encode($result);
        // foreach ($result as $row) {
        //     // Access fields like $row['cid'] and $row['sid']
        //     echo "CID: " . $row['cid'] . ", SID: " . $row['sid'] . "<br>";
        // }
        break;

    case 'storebilldeatils':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $extractedTextURL = $_POST['extractedTextURL'];
                $apiKey = 'sk-proj-SFfcEheRhG5M92UDPAQdT3BlbkFJHs1rPv32VdzYax3GOw09';
                $prompt = $extractedTextURL . "</br>" . "Answer all the following questions :
                What is the name of the company which created the invoice 
                What is the invoice number 
                What is the invoice date 
                What is the invoice amount 
                What is the activity for which it is an invoice 
                Is the invoice for a material or a service.
                
                Give the above answers in short with only main answere in json format";
                $response = callChatGPT($apiKey, $prompt);
                echo $response;
                // $response = ['status' => 'success', 'message' => 'Database update successful', 'data' => $prompt];
                // echo json_encode($response);
            } catch (PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Database error', 'data' => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }

        // $inputJSON = file_get_contents('php://input');
        // $input = json_decode($inputJSON, true);



        // // Check if extractedText exists in the received data
        // if (isset($input['extractedText'])) {
        //     $extractedText = $input['extractedText'];

        //     // Example prompt/question to ask GPT-4
        //     $prompt = "What is the invoice number?";

        //     // Call GPT-4 to get the answer based on the extracted text
        //     $apiKey = 'sk-proj-SFfcEheRhG5M92UDPAQdT3BlbkFJHs1rPv32VdzYax3GOw09'; // Replace with your actual GPT-4 API key

        //     echo $extractedText;

        //     // $response = callGPT4($apiKey, $prompt, $extractedText);

        //     // // Prepare response to send back to frontend
        //     // $responseData = [
        //     //     'message' => 'Received extracted text successfully',
        //     //     'answer' => $response,
        //     // ];

        //     // echo json_encode($responseData);
        // } else {
        //     // Handle case where extractedText is not received
        //     http_response_code(400);
        //     echo json_encode(['error' => 'Missing extractedText']);
        // }

        // if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //     // Check if file was uploaded successfully
        //     if (isset($_FILES['invoice']) && $_FILES['invoice']['error'] === UPLOAD_ERR_OK) {
        //         // Extract uploaded file details
        //         $fileTmpPath = $_FILES['invoice']['tmp_name'];
        //         $fileName = $_FILES['invoice']['name'];
        //         $fileSize = $_FILES['invoice']['size'];
        //         $fileType = $_FILES['invoice']['type'];

        //         // Check if file is a PDF
        //         if ($fileType !== 'application/pdf') {
        //             echo "Error: Uploaded file must be a PDF.";
        //             exit;
        //         }

        //         // Read PDF content (using a hypothetical function, actual implementation depends on your chosen PDF parsing library)
        //         $pdfContent = file_get_contents($fileTmpPath); // Get PDF content
        //         // print_r($pdfContent);
        //         // Call OpenAI GPT-4 API function for text extraction and question answering
        //         $apiKey = 'sk-proj-SFfcEheRhG5M92UDPAQdT3BlbkFJHs1rPv32VdzYax3GOw09'; // Replace with your OpenAI API key

        //         // Construct prompt for GPT-4 to extract text and answer questions
        //         // $prompt = 'Extract text from the uploaded PDF and answer questions:
        //         //     - What is the name of the company which created the invoice?
        //         //     - What is the invoice number?
        //         //     - What is the invoice date?
        //         //     - What is the invoice amount?
        //         //     - What is the activity for which it is an invoice?
        //         //     - Is the invoice for a material or a service?

        //         //     PDF Content:
        //         //     ' . $pdfContent;
        //         // echo $prompt;
        //         $prompt = "How are you";
        //         // Call GPT-4 function
        //         $response = callGPT4($apiKey, $prompt);
        //         echo $response;
        //     } else {
        //         echo "Error uploading file. Please try again.";
        //     }
        // }


        break;
    default:
        break;
}

// sk-proj-SFfcEheRhG5M92UDPAQdT3BlbkFJHs1rPv32VdzYax3GOw09