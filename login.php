<?php

require_once __DIR__ . "/php/auth.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } elseif (loginUser($email, $password)) {

        header("Location: dashboard.php");
        exit;

    } else {

        $error = "Invalid email or password.";
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

    <title>Login | MiniGameHub</title>

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
            🎮
        </div>

        <h1>
            Welcome
            <span>back.</span>
        </h1>

        <p>
            Your next challenge is waiting.
            Sign in and continue playing.
        </p>

    </div>


    <div class="auth-card">

        <div class="auth-top">

            <span class="status-dot"></span>

            PLAYER LOGIN

        </div>

        <h2>
            Let's play.
        </h2>

        <p class="auth-description">
            Sign in to your MiniGameHub account.
        </p>


        <?php if ($error): ?>

            <div class="error-message">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>


        <form method="POST">


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

                <div class="password-box">

                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Enter password"
                        required
                    >

                    <button
                        type="button"
                        onclick="togglePassword()"
                    >
                        SHOW
                    </button>

                </div>

            </label>


            <button
                type="submit"
                class="auth-submit"
            >
                LOGIN
                <span>→</span>
            </button>

        </form>


        <div class="auth-divider">
            NEW PLAYER?
        </div>


        <a
            href="register.php"
            class="create-account"
        >
            CREATE AN ACCOUNT →
        </a>


        <a
            href="index.php"
            class="back-home"
        >
            ← Back to Home
        </a>

    </div>

</div>


<script>

function togglePassword() {

    const password =
        document.getElementById("password");

    const button =
        event.target;

    if (password.type === "password") {

        password.type = "text";

        button.textContent = "HIDE";

    } else {

        password.type = "password";

        button.textContent = "SHOW";
    }
}

</script>

</body>
</html>