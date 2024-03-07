<?php

// Load survey questions from JSON file
$surveyData = json_decode(file_get_contents('survey_data.json'), true);
$questions = $surveyData['questions'];

// Get user input from USSD request
$userInput = isset($_GET['user_input']) ? $_GET['user_input'] : '';

// Determine the current question index
$currentQuestionIndex = isset($_GET['question_index']) ? intval($_GET['question_index']) : 0;

// Initialize response message
$response = '';

// Check if there are more questions to ask
if ($currentQuestionIndex < count($questions)) {
    $currentQuestion = $questions[$currentQuestionIndex];

    // Construct USSD menu based on the question type
    $response .= $currentQuestion['question_text'] . "\n";
    if (isset($currentQuestion['options'])) {
        foreach ($currentQuestion['options'] as $index => $option) {
            $response .= ($index + 1) . ". $option\n";
        }
    } elseif (isset($currentQuestion['scale_min']) && isset($currentQuestion['scale_max'])) {
        $response .= "Reply with a number between {$currentQuestion['scale_min']} and {$currentQuestion['scale_max']}\n";
    }

    // Update USSD session with next question index
    $nextQuestionIndex = $currentQuestionIndex + 1;
    $response .= "CON Please select an option or provide your answer:";
    $response .= "&question_index=$nextQuestionIndex";
} else {
    // All questions asked, end USSD session
    $response .= "END Thank you for completing the survey!";
}

// Output response to USSD gateway
header('Content-type: text/plain');
echo $response;

?>
