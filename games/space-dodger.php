<?php

require_once __DIR__ . "/../php/auth.php";

requireLogin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Space Dodger | MiniGameHub</title>
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
        <span>🚀 SPACE DODGER</span>
    </div>

    <div class="space-card">
        <div class="game-title">
            <p>SURVIVE THE ASTEROID BELT</p>
            <h1>Space Dodger</h1>
        </div>

        <div class="game-score">
            <div>
                <span>DISTANCE</span>
                <strong id="spaceScore">0</strong>
            </div>

            <div>
                <span>STARS COLLECTED</span>
                <strong id="spaceStars" style="color:#ffd700;">0</strong>
            </div>

            <div>
                <span>BEST SCORE</span>
                <strong id="spaceBest">0</strong>
            </div>
        </div>

        <div class="space-arena">
            <canvas id="spaceCanvas" width="400" height="480"></canvas>

            <div id="spaceOverlay" class="snake-overlay">
                <div style="font-size: 50px; margin-bottom: 10px;" id="spaceOverlayIcon">🚀</div>
                <h2 id="spaceOverlayTitle" style="font-size: 26px; margin-bottom: 6px;">Launch Mission</h2>
                <p id="spaceOverlaySubtitle" style="color: var(--muted); font-size: 13px; margin-bottom: 20px;">Use Left/Right arrow keys, A/D or mouse to steer</p>
                <button id="startSpaceBtn" class="game-btn">
                    LAUNCH SHIP →
                </button>
            </div>
        </div>

        <div style="display:flex; gap:12px; justify-content:center; margin-top:20px;">
            <a href="../leaderboard.php" class="btn secondary" style="display:inline-flex;">
                VIEW LEADERBOARD →
            </a>
        </div>
    </div>

</main>

<script src="../js/space-dodger.js"></script>

</body>
</html>
