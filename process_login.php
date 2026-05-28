<?php
// SmartQueue - Login Processing

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = trim($_POST['password'] ?? '');

    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please provide a valid email format.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if (!empty($errors)) {
        echo "<h2>Login Failed</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li style='color: red;'>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo "<br><a href='../frontend/login.html'>Go back to login</a>";
        exit();
    }

    require_once 'db_connect.php';

    try {
        $stmt = $pdo->prepare("SELECT id, name, email, password, role FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            echo "<h2>Login Failed</h2>";
            echo "<p style='color: red;'>Invalid email or password.</p>";
            echo "<br><a href='../frontend/login.html'>Go back to login</a>";
            exit();
        }

        session_start();
        session_regenerate_id(true);
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit();
    } catch (PDOException $e) {
        echo "<h2>Login Failed</h2>";
        echo "<p style='color: red;'>Database Error: " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<br><a href='../frontend/login.html'>Go back to login</a>";
        exit();
    }
} else {
    echo "<h2>Error</h2>";
    echo "<p>Invalid request method. Please submit the form.</p>";
}
?>
