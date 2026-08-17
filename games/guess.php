<?php

require_once __DIR__ . "/../php/auth.php";

requireLogin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess It | MiniGameHub</title>
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
        <span>🔢 GUESS IT</span>
    </div>

    <div class="guess-card" style="max-width:600px; margin:0 auto; background:var(--card); border:1px solid var(--border); border-radius:24px; padding:40px; text-align:center;">
        <div class="game-title">
            <p>NUMBER PUZZLE</p>
            <h1>Guess the Number</h1>
            <p style="color:var(--muted); margin-top:8px;">
                I'm thinking of a number between <strong style="color:var(--accent);">1 and 100</strong>.
            </p>
        </div>

        <div class="guess-number" style="display:flex; gap:10px; max-width:320px; margin:25px auto;">
            <input
                type="number"
                id="guessInput"
                min="1"
                max="100"
                placeholder="?"
                style="width:120px; text-align:center; font-size:24px; font-weight:700; background:var(--card-light); border:1px solid var(--border); border-radius:12px; color:var(--text); padding:12px;"
            >
            <button id="guessBtn" class="game-btn" style="flex-grow:1;">
                GUESS →
            </button>
        </div>

        <div id="guessMessage" class="guess-message" style="margin:20px 0; font-size:15px; font-weight:600; min-height:24px;">
            Enter a number to begin.
        </div>

        <div class="guess-stats" style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:25px;">
            <div style="padding:15px; background:var(--card-light); border:1px solid var(--border); border-radius:12px;">
                <span style="display:block; color:var(--muted); font-size:10px; font-family:'DM Mono', monospace;">CURRENT ATTEMPTS</span>
                <strong id="attempts" style="font-size:22px; display:block; margin-top:4px;">0</strong>
            </div>

            <div style="padding:15px; background:var(--card-light); border:1px solid var(--border); border-radius:12px;">
                <span style="display:block; color:var(--muted); font-size:10px; font-family:'DM Mono', monospace;">BEST ATTEMPTS</span>
                <strong id="bestAttempts" style="font-size:22px; display:block; margin-top:4px; color:var(--accent);">--</strong>
            </div>
        </div>

        <div style="display:flex; gap:12px; justify-content:center;">
            <button id="guessRestart" class="game-btn secondary-game-btn">
                NEW NUMBER
            </button>
            <a href="../leaderboard.php" class="btn secondary" style="display:inline-flex;">
                LEADERBOARD →
            </a>
        </div>
    </div>

</main>

<script src="../js/guess.js"></script>

</body>
</html>