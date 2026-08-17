<?php

require_once __DIR__ . "/../php/auth.php";

requireLogin();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whack-a-Mole | MiniGameHub</title>
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
        <span>🔨 WHACK-A-MOLE</span>
    </div>

    <div class="wam-card">
        <div class="game-title">
            <p>FAST REFLEX CHALLENGE</p>
            <h1>Whack-a-Mole</h1>
        </div>

        <div class="game-score">
            <div>
                <span>SCORE</span>
                <strong id="wamScore">0</strong>
            </div>

            <div>
                <span>TIME LEFT</span>
                <strong id="wamTimer" style="color:var(--accent);">30s</strong>
            </div>

            <div>
                <span>COMBO</span>
                <strong id="wamCombo" style="color:#ffd700;">x1</strong>
            </div>
        </div>

        <div class="mole-grid" id="moleGrid">
            <div class="mole-hole" data-index="0"><div class="mole">🐹</div></div>
            <div class="mole-hole" data-index="1"><div class="mole">🐹</div></div>
            <div class="mole-hole" data-index="2"><div class="mole">🐹</div></div>
            <div class="mole-hole" data-index="3"><div class="mole">🐹</div></div>
            <div class="mole-hole" data-index="4"><div class="mole">🐹</div></div>
            <div class="mole-hole" data-index="5"><div class="mole">🐹</div></div>
            <div class="mole-hole" data-index="6"><div class="mole">🐹</div></div>
            <div class="mole-hole" data-index="7"><div class="mole">🐹</div></div>
            <div class="mole-hole" data-index="8"><div class="mole">🐹</div></div>
        </div>

        <div id="wamResult" style="display:none; margin:20px 0;">
            <div style="font-size: 55px;">🏆</div>
            <h2 style="font-size: 28px; margin: 8px 0;">Time's Up!</h2>
            <p style="color: var(--muted);">Final Reflex Score</p>
            <strong id="wamFinalScore" style="display:block; font-size:48px; color:var(--accent); margin:10px 0;">0</strong>
        </div>

        <div style="display:flex; gap:12px; justify-content:center; margin-top:20px;">
            <button id="startWamBtn" class="game-btn">
                START GAME (30s) →
            </button>
            <a href="../leaderboard.php" class="btn secondary" style="display:inline-flex;">
                LEADERBOARD →
            </a>
        </div>
    </div>

</main>

<script src="../js/whack-a-mole.js"></script>

</body>
</html>
