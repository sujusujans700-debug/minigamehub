<?php

require_once __DIR__ . "/../php/auth.php";

requireLogin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rock Paper Scissors | MiniGameHub</title>
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
        <span>✊✋✌️ ROCK PAPER SCISSORS</span>
    </div>

    <div class="rps-card">
        <div class="game-title">
            <p>FIRST TO 3 ROUNDS</p>
            <h1>Rock Paper Scissors</h1>
            <div id="rpsStatus" class="game-status">
                Choose your move to battle!
            </div>
        </div>

        <div class="game-score">
            <div>
                <span>YOU</span>
                <strong id="rpsPlayerScore">0</strong>
            </div>

            <div>
                <span>ROUND</span>
                <strong id="rpsRound" style="color:var(--accent);">1 / 5</strong>
            </div>

            <div>
                <span>AI OPPONENT</span>
                <strong id="rpsAiScore">0</strong>
            </div>
        </div>

        <div class="rps-arena">
            <div class="rps-fighter">
                <div class="rps-hand-display" id="playerHand">✊</div>
                <div style="font-weight:700; color:#fff;">YOU</div>
            </div>

            <div style="font-size: 24px; font-weight: 700; color: var(--muted); font-family: 'DM Mono', monospace;">
                VS
            </div>

            <div class="rps-fighter">
                <div class="rps-hand-display" id="aiHand">✊</div>
                <div style="font-weight:700; color:#fff;">AI BOT</div>
            </div>
        </div>

        <div class="rps-choices" id="rpsChoices">
            <button class="rps-choice-btn" data-choice="rock">
                <span>✊</span> ROCK
            </button>
            <button class="rps-choice-btn" data-choice="paper">
                <span>✋</span> PAPER
            </button>
            <button class="rps-choice-btn" data-choice="scissors">
                <span>✌️</span> SCISSORS
            </button>
        </div>

        <div id="rpsMatchResult" style="display:none; margin:25px 0;">
            <div style="font-size:55px;" id="rpsResultIcon">🏆</div>
            <h2 id="rpsResultTitle" style="font-size:28px; margin:8px 0;">Match Over!</h2>
            <p id="rpsResultSubtitle" style="color:var(--muted);">Total Earned Points</p>
            <strong id="rpsFinalPoints" style="display:block; font-size:48px; color:var(--accent); margin:10px 0;">0</strong>
            <button id="restartRpsBtn" class="game-btn" style="margin-top:10px;">
                PLAY NEW MATCH →
            </button>
        </div>

        <div style="display:flex; gap:12px; justify-content:center; margin-top:20px;">
            <a href="../leaderboard.php" class="btn secondary" style="display:inline-flex;">
                VIEW LEADERBOARD →
            </a>
        </div>
    </div>

</main>

<script src="../js/rps.js"></script>

</body>
</html>
