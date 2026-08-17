<?php

require_once __DIR__ . "/php/auth.php";

requireLogin();

$user = currentUser();

if (!$user) {
    header("Location: login.php");
    exit;
}

$initial = strtoupper(substr($user["username"] ?? "P", 0, 1));

// Calculate player tier based on games won
$gamesWon = (int)($user["games_won"] ?? 0);
if ($gamesWon >= 20) {
    $tier = "LEGENDARY GAMER 🌟";
} elseif ($gamesWon >= 10) {
    $tier = "PRO PLAYER 💎";
} elseif ($gamesWon >= 3) {
    $tier = "RISING STAR ⚡";
} else {
    $tier = "NOVICE ROOKIE 🎮";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | MiniGameHub</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .profile-wrapper {
            max-width: 850px;
            margin: 40px auto 80px;
            padding: 0 20px;
        }
        .profile-header-card {
            background: var(--card);
            border: 1px solid var(--border);
            backdrop-filter: blur(16px);
            border-radius: 24px;
            padding: 45px 35px;
            text-align: center;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
        }
        .profile-header-card::before {
            content: "";
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(184, 255, 44, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }
        .avatar-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--accent);
            color: #08090b;
            font-size: 42px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px rgba(184, 255, 44, 0.25);
        }
        .tier-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 50px;
            background: rgba(184, 255, 44, 0.1);
            border: 1px solid rgba(184, 255, 44, 0.3);
            color: var(--accent);
            font-family: "DM Mono", monospace;
            font-size: 11px;
            margin-bottom: 12px;
        }
        .profile-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 35px 0 25px;
        }
        .profile-stat-box {
            background: var(--card-light);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px 10px;
            text-align: center;
        }
        .profile-stat-box span {
            font-size: 24px;
            display: block;
            margin-bottom: 6px;
        }
        .profile-stat-box small {
            display: block;
            color: var(--muted);
            font-family: "DM Mono", monospace;
            font-size: 9px;
            letter-spacing: 0.5px;
        }
        .profile-stat-box strong {
            display: block;
            color: #ffffff;
            font-size: 24px;
            margin-top: 4px;
        }
        .profile-history-card {
            background: var(--card);
            border: 1px solid var(--border);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        .history-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }
        .history-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: var(--card-light);
            border: 1px solid var(--border);
            border-radius: 12px;
        }
        @media (max-width: 768px) {
            .profile-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<header class="navbar">
    <a href="index.php" class="logo" style="display:flex; align-items:center; gap:10px;">
        <img src="assets/images/icons/logo.jpg" alt="Logo" style="width:36px; height:36px; border-radius:8px; object-fit:cover;">
        <span>MINI<span>GAME</span>HUB</span>
    </a>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="games.php">Games</a>
        <a href="leaderboard.php">Leaderboard</a>
        <a href="profile.php" class="active" style="color:var(--accent); font-weight:700;">Profile</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<main class="profile-wrapper">
    <div class="profile-header-card">
        <div class="avatar-large">
            <?= htmlspecialchars($initial) ?>
        </div>

        <div class="tier-badge">
            <?= htmlspecialchars($tier) ?>
        </div>

        <h1 style="font-size: 36px; margin-bottom: 4px;">
            <?= htmlspecialchars($user["username"] ?? "Player") ?>
        </h1>

        <p style="color: var(--muted); font-size: 14px;">
            <?= htmlspecialchars($user["email"] ?? "") ?>
        </p>

        <!-- STATS -->
        <div class="profile-stats-grid">
            <div class="profile-stat-box">
                <span>🎮</span>
                <small>GAMES PLAYED</small>
                <strong><?= (int)($user["games_played"] ?? 0) ?></strong>
            </div>

            <div class="profile-stat-box">
                <span>🏆</span>
                <small>GAMES WON</small>
                <strong><?= (int)($user["games_won"] ?? 0) ?></strong>
            </div>

            <div class="profile-stat-box">
                <span>⭐</span>
                <small>BEST SCORE</small>
                <strong><?= (int)($user["best_score"] ?? 0) ?></strong>
            </div>

            <div class="profile-stat-box">
                <span>⚡</span>
                <small>WIN RATE</small>
                <strong><?= (int)($user["win_rate"] ?? 0) ?>%</strong>
            </div>
        </div>

        <div style="display: flex; gap: 12px; justify-content: center; margin-top: 10px;">
            <a href="games.php" class="btn primary">
                PLAY A GAME →
            </a>
            <a href="settings.php" class="btn secondary">
                EDIT PROFILE ⚙️
            </a>
        </div>
    </div>

    <!-- RECENT MATCHES -->
    <div class="profile-history-card">
        <h2 style="font-size: 20px;">📜 Recent Match Activity</h2>
        <p style="color: var(--muted); font-size: 13px; margin-top: 4px;">Your latest completed challenge scores.</p>

        <?php if (empty($user["recent_scores"])): ?>
            <div style="text-align: center; padding: 35px 10px; color: var(--muted);">
                <p>No matches recorded yet. Jump into games to build your stats!</p>
            </div>
        <?php else: ?>
            <div class="history-list">
                <?php foreach ($user["recent_scores"] as $match): ?>
                    <div class="history-row">
                        <div>
                            <div style="font-weight: 600; font-size: 15px; color: #ffffff;">
                                <?= htmlspecialchars($match["game"] ?? "Game") ?>
                            </div>
                            <div style="font-size: 12px; color: var(--muted); font-family: 'DM Mono', monospace; margin-top: 2px;">
                                <?= htmlspecialchars(date("M j, Y • g:i a", strtotime($match["created_at"] ?? "now"))) ?>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="color: var(--accent); font-weight: 700; font-size: 18px;">
                                +<?= (int)($match["score"] ?? 0) ?> pts
                            </div>
                            <small style="color: var(--muted); font-family: 'DM Mono', monospace; font-size: 10px;">FINAL SCORE</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer>
    <div class="logo">
        MINI<span>GAME</span>HUB
    </div>
    <p>Play. Compete. Win.</p>
    <p>© <?= date("Y") ?> MiniGameHub</p>
</footer>

</body>
</html>