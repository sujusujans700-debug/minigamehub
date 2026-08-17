<?php

require_once __DIR__ . "/../php/auth.php";

requireLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Guess It | MiniGameHub</title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

    <link
        rel="stylesheet"
        href="../css/games.css"
    >

</head>

<body class="game-page">


<header class="navbar">

    <a href="../index.php" class="logo">
        MINI<span>GAME</span>HUB
    </a>

    <nav>

        <a href="../dashboard.php">
            Dashboard
        </a>

        <a href="../games.php">
            Games
        </a>

        <a href="../leaderboard.php">
            Leaderboard
        </a>

        <a href="../logout.php">
            Logout
        </a>

    </nav>

</header>


<main class="game-container">


    <div class="game-top">

        <a href="../games.php">
            ← BACK TO GAMES
        </a>

        <span>
            🔢 GUESS IT
        </span>

    </div>


    <div class="guess-card">


        <div class="game-title">

            <p>
                CAN YOU FIND IT?
            </p>

            <h1>
                Guess the Number
            </h1>

            <p>
                I'm thinking of a number between
                <strong>1 and 100</strong>.
            </p>

        </div>


        <div class="guess-number">

            <span>
                YOUR GUESS
            </span>

            <input
                type="number"
                id="guessInput"
                min="1"
                max="100"
                placeholder="?"
            >

            <button
                id="guessBtn"
                class="game-btn"
            >
                GUESS →
            </button>

        </div>


        <div
            id="guessMessage"
            class="guess-message"
        >
            Enter a number to begin.
        </div>


        <div class="guess-stats">

            <div>

                <span>
                    ATTEMPTS
                </span>

                <strong id="attempts">
                    0
                </strong>

            </div>


            <div>

                <span>
                    BEST
                </span>

                <strong id="bestAttempts">
                    --
                </strong>

            </div>

        </div>


        <button
            id="guessRestart"
            class="game-btn secondary-game-btn"
        >
            NEW NUMBER
        </button>


    </div>

</main>


<script src="../js/guess.js"></script>

</body>
</html>