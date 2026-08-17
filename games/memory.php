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

    <title>Memory Game | MiniGameHub</title>

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
            🃏 MEMORY
        </span>

    </div>


    <div class="memory-card">


        <div class="game-title">

            <p>
                MATCH THE PAIRS
            </p>

            <h1>
                Memory
            </h1>

        </div>


        <div class="memory-stats">

            <div>

                <span>
                    MOVES
                </span>

                <strong id="moves">
                    0
                </strong>

            </div>


            <div>

                <span>
                    TIME
                </span>

                <strong id="memoryTimer">
                    0
                </strong>

            </div>


            <div>

                <span>
                    PAIRS
                </span>

                <strong id="pairs">
                    0 / 8
                </strong>

            </div>

        </div>


        <div
            id="memoryBoard"
            class="memory-board"
        ></div>


        <div
            id="memoryResult"
            class="memory-result"
            style="display:none;"
        >

            <div>
                🏆
            </div>

            <h2>
                You Won!
            </h2>

            <p>
                You matched all the cards.
            </p>

            <strong id="memoryFinalScore">
                0
            </strong>

            <button
                onclick="startMemoryGame()"
                class="game-btn"
            >
                PLAY AGAIN
            </button>

        </div>

    </div>

</main>


<script src="../js/memory.js"></script>

</body>
</html>