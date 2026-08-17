<?php
require_once __DIR__ . "/php/auth.php";

$logged = isLoggedIn();
$games = readJson(GAMES_FILE);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games Library | MiniGameHub</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/games.css">
</head>

<body>

<header class="navbar">
    <a href="index.php" class="logo" style="display:flex; align-items:center; gap:10px;">
        <img src="assets/images/icons/logo.jpg" alt="Logo" style="width:36px; height:36px; border-radius:8px; object-fit:cover;">
        <span>MINI<span>GAME</span>HUB</span>
    </a>

    <nav>
        <a href="index.php">Home</a>
        <a href="games.php" class="active" style="color:var(--accent); font-weight:700;">Games</a>
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

<main class="page">

<div class="page-heading">
    <p class="badge">GAME LIBRARY (<?= count($games) ?> GAMES)</p>
    <h1>Pick your <span>challenge.</span></h1>
    <p>Choose a game, beat your high score, and climb to the top of the global leaderboard.</p>
</div>

<div class="games-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:25px;">
    <?php foreach ($games as $idx => $g): 
        $gameNum = str_pad($idx + 1, 2, "0", STR_PAD_LEFT);
    ?>
        <div class="game-card big" style="background:var(--card); border:1px solid var(--border); border-radius:20px; padding:30px; display:flex; flex-direction:column; position:relative; overflow:hidden;">
            <div style="width:100%; height:160px; border-radius:14px; overflow:hidden; margin-bottom:20px; background:radial-gradient(circle, rgba(184, 255, 44, 0.1) 0%, #12151c 100%); display:flex; align-items:center; justify-content:center; font-size:60px;">
                <span><?= $g["icon"] ?></span>
            </div>
            <span class="game-number" style="font-family:'DM Mono', monospace; font-size:11px; color:var(--muted);"><?= $gameNum ?> / <?= strtoupper(htmlspecialchars($g["category"])) ?></span>
            <h2 style="font-size:24px; margin:8px 0;"><?= htmlspecialchars($g["name"]) ?></h2>
            <p style="color:var(--muted); line-height:1.6; font-size:14px; margin-bottom:25px; flex-grow:1;">
                <?= htmlspecialchars($g["description"]) ?>
            </p>
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; font-family:'DM Mono', monospace; font-size:11px; color:var(--muted);">
                <span>DIFFICULTY: <strong style="color:var(--accent);"><?= htmlspecialchars($g["difficulty"]) ?></strong></span>
                <span><?= htmlspecialchars($g["players"]) ?></span>
            </div>
            <a href="<?= htmlspecialchars($g["url"]) ?>" class="btn primary" style="width:100%; text-align:center;">
                PLAY NOW →
            </a>
        </div>
    <?php endforeach; ?>
</div>

</main>

<footer>
    <div class="logo">
        MINI<span>GAME</span>HUB
    </div>
    <p>Play. Compete. Win.</p>
    <p>© <?= date("Y") ?> MiniGameHub</p>
</footer>

</body>
</html>