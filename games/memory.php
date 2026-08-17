<?php

require_once __DIR__ . "/../php/auth.php";

requireLogin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game | MiniGameHub</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/games.css">
</head>

<body class="game-page">

<header class="navbar">
    <a href="../index.php" class="logo" style="display:flex; align-items:center; gap:10px;">
        <img src="../assets/images/icons/logo.jpg" alt="Logo" style="width:36px; height:36px; border-radius:8px; object-fit:cover;">
        <span>MINI<span>GAME</span>HUB</span>
    </a>

    <nav>
        <a href="../dashboard.php">Dashboard</a>
        <a href="../games.php" class="active" style="color:var(--accent); font-weight:700;">Games</a>
        <a href="../leaderboard.php">Leaderboard</a>
        <a href="../profile.php">Profile</a>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<main class="game-container">

    <div class="game-top">
        <a href="../games.php">← BACK TO GAMES</a>
        <span>🃏 MEMORY</span>
    </div>

    <div class="memory-card">
        <div class="game-title">
            <p>MATCH THE PAIRS</p>
            <h1>Memory Match</h1>
        </div>

        <div class="memory-stats">
            <div>
                <span>MOVES</span>
                <strong id="moves">0</strong>
            </div>

            <div>
                <span>SECONDS</span>
                <strong id="memoryTimer">0</strong>
            </div>

            <div>
                <span>PAIRS</span>
                <strong id="pairs">0 / 8</strong>
            </div>
        </div>

        <div id="memoryBoard" class="memory-board"></div>

        <div id="memoryResult" class="memory-result" style="display:none;">
            <div style="font-size: 55px;">🏆</div>
            <h2>Victory!</h2>
            <p>You matched all the hidden card pairs.</p>
            <strong id="memoryFinalScore">0</strong>
            <div style="display:flex; gap:12px; justify-content:center; margin-top:20px;">
                <button onclick="startMemoryGame()" class="game-btn">
                    PLAY AGAIN
                </button>
                <a href="../leaderboard.php" class="btn secondary" style="display:inline-flex;">
                    LEADERBOARD →
                </a>
            </div>
        </div>
    </div>

</main>

<script src="../js/memory.js"></script>

</body>
</html>