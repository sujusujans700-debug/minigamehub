<?php

require_once __DIR__ . "/../php/auth.php";

requireLogin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Snake Arcade | MiniGameHub</title>
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
        <span>🐍 SNAKE ARCADE</span>
    </div>

    <div class="snake-card">
        <div class="game-title">
            <p>CLASSIC RETRO ARCADE</p>
            <h1>Snake Arcade</h1>
        </div>

        <div class="game-score">
            <div>
                <span>SCORE</span>
                <strong id="snakeScore">0</strong>
            </div>

            <div>
                <span>LENGTH</span>
                <strong id="snakeLength">1</strong>
            </div>

            <div>
                <span>BEST RECORD</span>
                <strong id="snakeBest">0</strong>
            </div>
        </div>

        <div class="snake-arena-wrapper">
            <canvas id="snakeCanvas" width="400" height="400"></canvas>

            <div id="snakeOverlay" class="snake-overlay">
                <div style="font-size: 50px; margin-bottom: 10px;" id="overlayIcon">🐍</div>
                <h2 id="overlayTitle" style="font-size: 26px; margin-bottom: 6px;">Ready to Play?</h2>
                <p id="overlaySubtitle" style="color: var(--muted); font-size: 13px; margin-bottom: 20px;">Use Arrow Keys or WASD to navigate</p>
                <button id="startSnakeBtn" class="game-btn">
                    START GAME →
                </button>
            </div>
        </div>

        <!-- Touch / On-screen controls for mobile -->
        <div class="snake-dpad">
            <div></div>
            <button class="dpad-btn" id="dpadUp">▲</button>
            <div></div>
            <button class="dpad-btn" id="dpadLeft">◀</button>
            <button class="dpad-btn" id="dpadDown">▼</button>
            <button class="dpad-btn" id="dpadRight">▶</button>
        </div>

        <div style="display:flex; gap:12px; justify-content:center; margin-top:25px;">
            <a href="../leaderboard.php" class="btn secondary" style="display:inline-flex;">
                VIEW LEADERBOARD →
            </a>
        </div>
    </div>

</main>

<script src="../js/snake.js"></script>

</body>
</html>
