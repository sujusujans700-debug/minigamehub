<?php
session_start();

$isLoggedIn = isset($_SESSION["user"]);
$userName = $isLoggedIn ? $_SESSION["user"]["name"] : "";
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

    <a href="index.php" class="logo">
        MINI<span>GAME</span>HUB
    </a>

    <nav>
        <a href="index.php">Home</a>
        <a href="games.php">Games</a>
        <a href="leaderboard.php">Leaderboard</a>

        <?php if ($isLoggedIn): ?>

            <a href="dashboard.php">Dashboard</a>
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
            Challenge yourself with fun mini games,
            climb the leaderboard and become
            the ultimate champion.
        </p>

        <div class="hero-buttons">

            <?php if ($isLoggedIn): ?>

                <a href="games.php" class="btn primary">
                    PLAY NOW →
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
            <span class="online">● ONLINE</span>
        </div>

        <div class="game-symbol">
            🧠
        </div>

        <h2>Quick Quiz</h2>

        <p>
            Test your knowledge.
            Beat the timer.
            Get the highest score.
        </p>

        <a href="games.php" class="play-link">
            PLAY GAME →
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

            <div class="feature-icon">
                🎯
            </div>

            <h3>Challenge Yourself</h3>

            <p>
                Test your skills with
                different mini games.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">
                🏆
            </div>

            <h3>Climb The Rankings</h3>

            <p>
                Earn high scores and
                compete with other players.
            </p>

        </div>


        <div class="feature-card">

            <div class="feature-icon">
                ⚡
            </div>

            <h3>Fast & Simple</h3>

            <p>
                Quick games designed
                for instant fun.
            </p>

        </div>

    </div>

</section>


<section class="cta">

    <p>READY FOR YOUR NEXT CHALLENGE?</p>

    <h2>
        Let the games begin.
    </h2>

    <a href="games.php" class="btn primary">
        EXPLORE GAMES →
    </a>

</section>

</main>


<footer>

    <div class="logo">
        MINI<span>GAME</span>HUB
    </div>

    <p>
        Play. Compete. Win.
    </p>

    <p>
        © 2026 MiniGameHub
    </p>

</footer>


<script src="js/main.js"></script>

</body>
</html>