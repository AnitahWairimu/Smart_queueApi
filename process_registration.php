<?php
// SmartQueue - Dynamic User Input Handling

// Check if the request is a POST request (e.g., form submission)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Retrieve & Sanitize Input dynamically
    // filter_input helps prevent XSS and handles variables safely
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = $_POST['password'] ?? '';
    
    $errors = [];

    // 2. Validate the dynamic input on the server side
    if (empty($name) || strlen(trim($name)) < 3) {
        $errors[] = "Name is invalid or too short.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password cannot be empty.";
    }
    
    if (!in_array($role, ['admin', 'staff'])) {
        $errors[] = "Invalid role selected.";
    }

    // 3. Process and Output the dynamic result
    if (empty($errors)) {
        require_once 'db_connect.php';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Insert into the users table using prepared statements to prevent SQL injection
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);

            // Styling for the success message to match the frontend
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Success - SmartQueue</title>
                <style>
                    body {
                        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
                        background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
                        min-height: 100vh;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        margin: 0;
                    }
                    .container {
                        background: #ffffff;
                        padding: 40px;
                        border-radius: 16px;
                        box-shadow: 0 10px 30px rgba(0, 86, 179, 0.1);
                        text-align: center;
                        max-width: 400px;
                    }
                    .success-icon {
                        color: #38a169;
                        font-size: 48px;
                        margin-bottom: 20px;
                    }
                    h2 { color: #0056b3; }
                    p { color: #4a5568; line-height: 1.6; margin-bottom: 15px; }
                    a {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #0056b3;
                        color: white;
                        text-decoration: none;
                        border-radius: 8px;
                        margin-top: 20px;
                    }
                    a:hover { background-color: #004494; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='success-icon'>✓</div>
                    <h2>Registration Successful!</h2>
                    <p>Welcome to SmartQueue, <strong>" . htmlspecialchars($name) . "</strong> (" . ucfirst(htmlspecialchars($role)) . ")!</p>
                    <p>Your account has been securely saved to the database. We will send updates to <strong>" . htmlspecialchars($email) . "</strong>.</p>
                    <a href='../frontend/index.html'>Register Another User</a>
                </div>
            </body>
            </html>";
        } catch (PDOException $e) {
            // Handle duplicate email or other database errors
            if ($e->getCode() == 23000) {
                echo "<h2>Registration Failed</h2>";
                echo "<p style='color: red;'>An account with this email already exists.</p>";
                echo "<br><a href='../frontend/index.html'>Go back to the form</a>";
            } else {
                echo "<h2>Registration Failed</h2>";
                echo "<p style='color: red;'>Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                echo "<br><a href='../frontend/index.html'>Go back to the form</a>";
            }
        }
    } else {
        echo "<h2>Registration Failed</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li style='color: red;'>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo "<br><a href='../frontend/index.html'>Go back to the form</a>";
    }

} else {
    // If someone accesses this file directly without submitting the form
    echo "<h2>Error</h2>";
    echo "<p>Invalid request method. Please submit the form.</p>";
}
?>