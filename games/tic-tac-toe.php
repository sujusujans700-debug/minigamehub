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

    <title>Tic-Tac-Toe | MiniGameHub</title>

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
            ❌⭕ TIC-TAC-TOE
        </span>

    </div>


    <div class="ttt-card">


        <div class="game-title">

            <p>
                PLAYER VS COMPUTER
            </p>

            <h1>
                Tic-Tac-Toe
            </h1>

            <div
                id="gameStatus"
                class="game-status"
            >
                Your turn
            </div>

        </div>


        <div
            id="board"
            class="tic-board"
        >

            <button data-index="0"></button>
            <button data-index="1"></button>
            <button data-index="2"></button>

            <button data-index="3"></button>
            <button data-index="4"></button>
            <button data-index="5"></button>

            <button data-index="6"></button>
            <button data-index="7"></button>
            <button data-index="8"></button>

        </div>


        <div class="game-score">

            <div>

                <span>
                    YOU
                </span>

                <strong id="playerScore">
                    0
                </strong>

            </div>


            <div>

                <span>
                    DRAW
                </span>

                <strong id="drawScore">
                    0
                </strong>

            </div>


            <div>

                <span>
                    COMPUTER
                </span>

                <strong id="computerScore">
                    0
                </strong>

            </div>

        </div>


        <button
            id="restartBtn"
            class="game-btn"
        >
            NEW GAME
        </button>

    </div>

</main>


<script src="../js/tic-tac-toe.js"></script>

</body>
</html>