<?php
require_once __DIR__ . "/php/auth.php";

$logged = isLoggedIn();
$user = $logged ? currentUser() : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiniGameHub | Play. Compete. Win.</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="navbar">
    <a href="index.php" class="logo" style="display:flex; align-items:center; gap:10px;">
        <img src="assets/images/icons/logo.jpg" alt="Logo" style="width:36px; height:36px; border-radius:8px; object-fit:cover;">
        <span>MINI<span>GAME</span>HUB</span>
    </a>

    <nav>
        <a href="index.php" class="active" style="color:var(--accent); font-weight:700;">Home</a>
        <a href="games.php">Games</a>
        <a href="leaderboard.php">Leaderboard</a>

        <?php if ($logged): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php" class="nav-button">Join Now</a>
        <?php endif; ?>
    </nav>
</header>

<main>

<section class="hero">
    <div class="hero-content">
        <div class="badge">
            🎮 ONLINE MINI GAME HUB
        </div>

        <h1>
            PLAY.
            <span>COMPETE.</span>
            WIN.
        </h1>

        <p>
            Challenge yourself with lightning-fast mini games, climb the global rankings, and set legendary scores in Quiz, Tic-Tac-Toe, Memory, and Guess It.
        </p>

        <div class="hero-buttons">
            <?php if ($logged): ?>
                <a href="dashboard.php" class="btn primary">
                    GO TO DASHBOARD →
                </a>
                <a href="games.php" class="btn secondary">
                    PLAY GAMES 🎮
                </a>
            <?php else: ?>
                <a href="register.php" class="btn primary">
                    START PLAYING →
                </a>
                <a href="login.php" class="btn secondary">
                    LOGIN
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="hero-game-card">
        <div class="card-header">
            <span>FEATURED GAME</span>
            <span class="online">● LIVE CHALLENGE</span>
        </div>

        <div class="game-symbol">
            🧠
        </div>

        <h2>Quick Quiz</h2>

        <p>
            Test your knowledge across trivia and programming under 15 seconds. Beat the clock and set high scores!
        </p>

        <a href="games/quiz.php" class="play-link">
            PLAY QUICK QUIZ →
        </a>
    </div>
</section>

<section class="features">
    <div class="section-title">
        <span>WHY PLAY?</span>
        <h2>
            Small games.
            <br>
            Big challenges.
        </h2>
    </div>

    <div class="feature-grid">
        <div class="feature-card">
            <div class="feature-icon">🎯</div>
            <h3>Challenge Yourself</h3>
            <p>Test your speed, strategy, and memory with 4 handcrafted mini games designed for instant fun.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🏆</div>
            <h3>Climb The Rankings</h3>
            <p>Earn high scores, beat your personal records, and compete with other players on the global leaderboard.</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <h3>Fast & Simple</h3>
            <p>Zero downloads required. Play immediately in your browser on desktop or mobile devices.</p>
        </div>
    </div>
</section>

<section class="cta">
    <p>READY FOR YOUR NEXT CHALLENGE?</p>
    <h2>Let the games begin.</h2>
    <a href="games.php" class="btn primary">
        EXPLORE ALL GAMES →
    </a>
</section>

</main>

<footer>
    <div class="logo">
        MINI<span>GAME</span>HUB
    </div>
    <p>Play. Compete. Win.</p>
    <p>© <?= date("Y") ?> MiniGameHub</p>
</footer>

<script src="js/main.js"></script>

</body>
</html>