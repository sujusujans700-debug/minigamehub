<?php

require_once __DIR__ . "/php/auth.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");

    $email = trim($_POST["email"] ?? "");

    $password = $_POST["password"] ?? "";

    $confirm = $_POST["confirm"] ?? "";


    if (
        $name === "" ||
        $email === "" ||
        $password === "" ||
        $confirm === ""
    ) {

        $error = "Please fill in all fields.";

    } elseif (
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {

        $error = "Please enter a valid email address.";

    } elseif (strlen($password) < 6) {

        $error =
            "Password must contain at least 6 characters.";

    } elseif ($password !== $confirm) {

        $error = "Passwords do not match.";

    } else {

        $result = registerUser(
            $name,
            $email,
            $password
        );


        if ($result["success"]) {

            header("Location: login.php");
            exit;

        } else {

            $error = $result["message"];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register | MiniGameHub</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/auth.css">

</head>

<body class="auth-page">


<div class="auth-wrapper">


    <div class="auth-info">

        <a href="index.php" class="logo">
            MINI<span>GAME</span>HUB
        </a>

        <div class="auth-emoji">
            🏆
        </div>

        <h1>
            Become a
            <span>player.</span>
        </h1>

        <p>
            Create your account, play games
            and start climbing the leaderboard.
        </p>

    </div>


    <div class="auth-card">

        <div class="auth-top">

            <span class="status-dot"></span>

            NEW PLAYER

        </div>

        <h2>
            Join the hub.
        </h2>

        <p class="auth-description">
            Create your free gaming account.
        </p>


        <?php if ($error): ?>

            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <form method="POST">


            <label>
                PLAYER NAME

                <input
                    type="text"
                    name="name"
                    placeholder="Your name"
                    required
                >

            </label>


            <label>
                EMAIL

                <input
                    type="email"
                    name="email"
                    placeholder="you@example.com"
                    required
                >

            </label>


            <label>
                PASSWORD

                <input
                    type="password"
                    name="password"
                    placeholder="Minimum 6 characters"
                    required
                >

            </label>


            <label>
                CONFIRM PASSWORD

                <input
                    type="password"
                    name="confirm"
                    placeholder="Repeat your password"
                    required
                >

            </label>


            <button
                type="submit"
                class="auth-submit"
            >
                CREATE ACCOUNT
                <span>→</span>
            </button>

        </form>


        <div class="auth-divider">
            ALREADY A PLAYER?
        </div>


        <a
            href="login.php"
            class="create-account"
        >
            LOGIN TO YOUR ACCOUNT →
        </a>


        <a
            href="index.php"
            class="back-home"
        >
            ← Back to Home
        </a>

    </div>

</div>

</body>
</html>