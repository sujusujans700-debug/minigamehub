<?php

require_once __DIR__ . "/../php/auth.php";

requireLogin();

$user = currentUser();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick Quiz | MiniGameHub</title>
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
        <span>🧠 QUICK QUIZ</span>
    </div>

    <div class="quiz-card">
        <div class="quiz-header">
            <div>
                <small>QUESTION</small>
                <strong id="questionNumber">1 / 5</strong>
            </div>

            <div class="quiz-score">
                <small>SCORE</small>
                <strong id="score">0</strong>
            </div>

            <div class="quiz-timer">
                <small>TIME</small>
                <strong id="timer">15</strong>
            </div>
        </div>

        <div class="progress">
            <div id="progressBar" class="progress-bar"></div>
        </div>

        <div class="question-area">
            <p id="category">GENERAL KNOWLEDGE</p>
            <h1 id="question">Loading question...</h1>
        </div>

        <div id="answers" class="answers"></div>

        <button id="nextBtn" class="game-btn" onclick="nextQuestion()" style="display:none;">
            NEXT QUESTION →
        </button>

        <div id="result" class="quiz-result" style="display:none;">
            <div class="result-icon">🏆</div>
            <h2>Quiz Complete!</h2>
            <p>Your final score</p>
            <strong id="finalScore">0</strong>
            <div style="display:flex; gap:12px; justify-content:center; margin-top:20px;">
                <button onclick="location.reload()" class="game-btn">
                    PLAY AGAIN
                </button>
                <a href="../leaderboard.php" class="btn secondary" style="display:inline-flex;">
                    VIEW LEADERBOARD →
                </a>
            </div>
        </div>
    </div>

</main>

<script src="../js/quiz.js"></script>

</body>
</html>