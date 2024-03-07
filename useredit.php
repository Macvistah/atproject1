<?php

// Load JSON data from file
$jsonData = file_get_contents("survey_data.json");
$data = json_decode($jsonData, true);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST["username"];
    $question = $_POST["question"];

    // Check if user already exists
    $userExists = false;
    foreach ($data["survey_platform"]["users"] as $user) {
        if ($user["username"] == $username) {
            $userExists = true;
            break;
        }
    }

    // If user doesn't exist, create a new user
    if (!$userExists) {
        $data["survey_platform"]["users"][] = array("username" => $username, "questions" => array());
    }

    // Add question to user's list of questions
    foreach ($data["survey_platform"]["users"] as &$user) {
        if ($user["username"] == $username) {
            $user["questions"][] = $question;
            break;
        }
    }

    // Save updated JSON data to file
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents("survey_data.json", $jsonData);

    echo "Question submitted successfully!";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Survey Question Input</title>
</head>
<body>
    <h2>Input Your Question</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="question">Your Question:</label><br>
        <textarea id="question" name="question" required></textarea><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
