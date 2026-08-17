<?php

require_once __DIR__ . "/php/auth.php";

requireLogin();

$user = currentUser();

if (!$user) {
    header("Location: login.php");
    exit;
}

// Fetch all games from data/games.json
$games = readJson(GAMES_FILE);

// Fetch global leaderboard top 5
$allScores = readJson(SCORES_FILE);
usort($allScores, function ($a, $b) {
    return ($b["score"] ?? 0) <=> ($a["score"] ?? 0);
});
$topScores = array_slice($allScores, 0, 5);

// Game icon mapper helper
function getGameIcon($gameName) {
    $map = [
        "Quiz" => "🧠",
        "Quick Quiz" => "🧠",
        "Tic-Tac-Toe" => "❌⭕",
        "Tic Tac Toe" => "❌⭕",
        "Memory" => "🃏",
        "Memory Match" => "🃏",
        "Guess It" => "🔢",
        "Guess the Number" => "🔢",
        "Snake" => "🐍",
        "Snake Arcade" => "🐍",
        "Whack-a-Mole" => "🔨",
        "Rock Paper Scissors" => "✊✋✌️",
        "RPS" => "✊✋✌️",
        "Space Dodger" => "🚀",
        "2048" => "🔢",
        "2048 Puzzle" => "🔢",
        "Typing Speed" => "⌨️",
        "Typing Speed Test" => "⌨️"
    ];
    return $map[$gameName] ?? "🎮";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | MiniGameHub</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

<!-- ================= NAVBAR ================= -->
<header class="navbar">
    <a href="index.php" class="logo" style="display:flex; align-items:center; gap:10px;">
        <img src="assets/images/icons/logo.jpg" alt="Logo" style="width:36px; height:36px; border-radius:8px; object-fit:cover;">
        <span>MINI<span>GAME</span>HUB</span>
    </a>

    <nav>
        <a href="dashboard.php" class="active" style="color:var(--accent); font-weight:700;">Dashboard</a>
        <a href="games.php">Games</a>
        <a href="leaderboard.php">Leaderboard</a>
        <a href="profile.php">Profile</a>
        <a href="settings.php">Settings</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<!-- ================= MAIN DASHBOARD ================= -->
<main class="dashboard">

    <!-- ================= WELCOME BANNER ================= -->
    <section class="welcome">
        <div class="welcome-info">
            <div class="welcome-badge">
                <span class="dot"></span>
                PLAYER DASHBOARD
            </div>
            <h1>
                Hey, <span><?= htmlspecialchars($user["username"] ?? "Player") ?></span> 👋
            </h1>
            <p>
                Ready for your next challenge? Choose from 10 exciting games, test your reflexes, and claim the #1 spot on the leaderboard.
            </p>
        </div>
        <div class="welcome-actions">
            <a href="games.php" class="btn primary">
                BROWSE ALL 10 GAMES →
            </a>
        </div>
    </section>

    <!-- ================= LIVE STATS ================= -->
    <section class="stats">
        <!-- GAMES PLAYED -->
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">🎮</div>
                <span class="stat-pill">MATCHES</span>
            </div>
            <div>
                <span class="stat-label">GAMES PLAYED</span>
                <strong><?= (int)($user["games_played"] ?? 0) ?></strong>
            </div>
        </div>

        <!-- GAMES WON -->
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">🏆</div>
                <span class="stat-pill">VICTORIES</span>
            </div>
            <div>
                <span class="stat-label">GAMES WON</span>
                <strong><?= (int)($user["games_won"] ?? 0) ?></strong>
            </div>
        </div>

        <!-- BEST SCORE -->
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">⭐</div>
                <span class="stat-pill">RECORD</span>
            </div>
            <div>
                <span class="stat-label">BEST SCORE</span>
                <strong><?= (int)($user["best_score"] ?? 0) ?></strong>
            </div>
        </div>

        <!-- WIN RATE -->
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">⚡</div>
                <span class="stat-pill">ACCURACY</span>
            </div>
            <div>
                <span class="stat-label">WIN RATE</span>
                <strong><?= (int)($user["win_rate"] ?? 0) ?>%</strong>
            </div>
        </div>
    </section>

    <!-- ================= GAME LIBRARY ================= -->
    <section class="dashboard-section">
        <div class="dashboard-heading">
            <div>
                <p>COMPLETE GAME LIBRARY (<?= count($games) ?> GAMES)</p>
                <h2>Choose your challenge.</h2>
            </div>
            <a href="games.php">View All Games →</a>
        </div>

        <div class="game-grid">
            <?php foreach ($games as $idx => $g): 
                $gameNum = str_pad($idx + 1, 2, "0", STR_PAD_LEFT);
            ?>
                <a href="<?= htmlspecialchars($g["url"]) ?>" class="game-card">
                    <div class="game-img-wrapper" style="display:flex; align-items:center; justify-content:center; font-size:48px; background: radial-gradient(circle, rgba(184, 255, 44, 0.08) 0%, #101217 100%);">
                        <span><?= $g["icon"] ?></span>
                        <span class="game-tag"><?= strtoupper(htmlspecialchars($g["category"])) ?></span>
                    </div>
                    <div class="game-card-meta">
                        <small>GAME <?= $gameNum ?></small>
                        <small><?= htmlspecialchars($g["difficulty"]) ?></small>
                    </div>
                    <h3><?= htmlspecialchars($g["name"]) ?></h3>
                    <p><?= htmlspecialchars($g["description"]) ?></p>
                    <div class="game-card-footer">
                        <span><?= htmlspecialchars($g["players"]) ?></span>
                        <strong>PLAY NOW →</strong>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ================= RECENT ACTIVITY & MINI LEADERBOARD ================= -->
    <section class="dashboard-split">
        <!-- MATCH HISTORY -->
        <div class="dashboard-panel">
            <div class="panel-header">
                <h3>📜 Your Recent Activity</h3>
                <a href="profile.php">Full Profile →</a>
            </div>

            <?php if (empty($user["recent_scores"])): ?>
                <div class="empty-state">
                    <div>🎮</div>
                    <p>No games played yet. Pick a game above and record your first score!</p>
                    <a href="games.php" class="btn primary" style="font-size:11px; padding:8px 16px;">PLAY A GAME</a>
                </div>
            <?php else: ?>
                <div class="activity-list">
                    <?php foreach ($user["recent_scores"] as $activity): ?>
                        <div class="activity-item">
                            <div class="activity-left">
                                <div class="activity-game-icon">
                                    <?= getGameIcon($activity["game"] ?? "") ?>
                                </div>
                                <div>
                                    <div class="activity-game-name">
                                        <?= htmlspecialchars($activity["game"] ?? "Mini Game") ?>
                                    </div>
                                    <div class="activity-date">
                                        <?= htmlspecialchars(date("M j, Y • g:i a", strtotime($activity["created_at"] ?? "now"))) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="activity-score">
                                <strong>+<?= (int)($activity["score"] ?? 0) ?> pts</strong>
                                <small>SCORE</small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- GLOBAL TOP 5 LEADERBOARD -->
        <div class="dashboard-panel">
            <div class="panel-header">
                <h3>🏆 Top Rankings</h3>
                <a href="leaderboard.php">Full Board →</a>
            </div>

            <?php if (empty($topScores)): ?>
                <div class="empty-state">
                    <div>🏆</div>
                    <p>No scores on the leaderboard yet. Be the first to make history!</p>
                </div>
            <?php else: ?>
                <div class="mini-leader-list">
                    <?php foreach ($topScores as $idx => $ts): 
                        $rank = $idx + 1;
                        $rankClass = $rank === 1 ? "top-1" : ($rank === 2 ? "top-2" : ($rank === 3 ? "top-3" : ""));
                        $rankDisplay = $rank === 1 ? "🥇" : ($rank === 2 ? "🥈" : ($rank === 3 ? "🥉" : "#{$rank}"));
                        $playerName = $ts["username"] ?? $ts["player"] ?? "Player";
                        $isMe = (isset($user["id"]) && isset($ts["user_id"]) && $user["id"] === $ts["user_id"]) || strtolower($playerName) === strtolower($user["username"] ?? "");
                    ?>
                        <div class="mini-leader-item" <?= $isMe ? 'style="border-color:rgba(184, 255, 44, 0.4); background:rgba(184, 255, 44, 0.04);"' : '' ?>>
                            <div class="mini-leader-rank <?= $rankClass ?>">
                                <?= $rankDisplay ?>
                            </div>
                            <div class="mini-leader-info">
                                <div class="mini-leader-name">
                                    <?= htmlspecialchars($playerName) ?> <?= $isMe ? '<span style="color:var(--accent); font-size:10px; font-family:monospace;">(YOU)</span>' : '' ?>
                                </div>
                                <div class="mini-leader-game">
                                    <?= htmlspecialchars($ts["game"] ?? "Game") ?>
                                </div>
                            </div>
                            <div class="mini-leader-score">
                                <?= (int)($ts["score"] ?? 0) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<!-- ================= FOOTER ================= -->
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