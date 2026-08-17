<?php

session_start();

$isLoggedIn = isset($_SESSION["user"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Games | MiniGameHub</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/games.css">

</head>

<body>


<header class="navbar">

    <a href="index.php" class="logo">
        MINI<span>GAME</span>HUB
    </a>

    <nav>

        <a href="index.php">
            Home
        </a>

        <a href="games.php">
            Games
        </a>

        <a href="leaderboard.php">
            Leaderboard
        </a>

        <?php if ($isLoggedIn): ?>

            <a href="dashboard.php">
                Dashboard
            </a>

            <a href="logout.php">
                Logout
            </a>

        <?php else: ?>

            <a href="login.php">
                Login
            </a>

        <?php endif; ?>

    </nav>

</header>


<main class="games-page">


<div class="games-heading">

    <p class="badge">
        GAME LIBRARY
    </p>

    <h1>
        Pick your
        <span>challenge.</span>
    </h1>

    <p>
        Choose a game, beat the score
        and climb the leaderboard.
    </p>

</div>


<div class="games-grid">


    <div class="game-card big">

        <div class="game-icon">
            🧠
        </div>

        <span class="game-number">
            01
        </span>

        <h2>
            Quick Quiz
        </h2>

        <p>
            Answer questions before
            the timer runs out.
        </p>

        <a href="games/quiz.php">
            PLAY NOW →
        </a>

    </div>


    <div class="game-card big">

        <div class="game-icon">
            ❌⭕
        </div>

        <span class="game-number">
            02
        </span>

        <h2>
            Tic-Tac-Toe
        </h2>

        <p>
            Challenge the computer
            and get three in a row.
        </p>

        <a href="games/tic-tac-toe.php">
            PLAY NOW →
        </a>

    </div>


    <div class="game-card big">

        <div class="game-icon">
            🃏
        </div>

        <span class="game-number">
            03
        </span>

        <h2>
            Memory
        </h2>

        <p>
            Find matching pairs and
            beat your previous time.
        </p>

        <a href="games/memory.php">
            PLAY NOW →
        </a>

    </div>


    <div class="game-card big">

        <div class="game-icon">
            🔢
        </div>

        <span class="game-number">
            04
        </span>

        <h2>
            Guess It
        </h2>

        <p>
            Guess the hidden number
            with fewer attempts.
        </p>

        <a href="games/guess.php">
            PLAY NOW →
        </a>

    </div>


</div>

</main>

</body>
</html>