<?php

require_once __DIR__ . "/php/auth.php";

$logged = isLoggedIn();
$currentUser = $logged ? currentUser() : null;

$scores = readJson(SCORES_FILE);

// Optional game filtering
$selectedGame = trim($_GET["game"] ?? "");

if ($selectedGame !== "") {
    $scores = array_values(array_filter($scores, function ($item) use ($selectedGame) {
        $g = strtolower($item["game"] ?? "");
        $target = strtolower($selectedGame);
        return $g === $target || strpos($g, $target) !== false;
    }));
}

usort($scores, function ($a, $b) {
    return ($b["score"] ?? 0) <=> ($a["score"] ?? 0);
});

$gamesList = [
    "All",
    "Quiz",
    "Tic-Tac-Toe",
    "Memory",
    "Guess It",
    "Snake",
    "Whack-a-Mole",
    "Rock Paper Scissors",
    "Space Dodger",
    "2048",
    "Typing Speed"
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard | MiniGameHub</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .filter-tabs {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin: 30px 0 40px;
        }
        .filter-tab {
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid var(--border);
            background: var(--card);
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            transition: 0.2s ease;
        }
        .filter-tab:hover {
            border-color: var(--accent);
            color: #fff;
        }
        .filter-tab.active {
            background: var(--accent);
            color: #08090b !important;
            border-color: var(--accent);
        }
        .podium-container {
            display: grid;
            grid-template-columns: 1fr 1.15fr 1fr;
            gap: 15px;
            max-width: 750px;
            margin: 0 auto 40px;
            align-items: flex-end;
        }
        .podium-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 25px 15px;
            text-align: center;
            position: relative;
        }
        .podium-card.first {
            border-color: #ffd700;
            background: linear-gradient(180deg, rgba(255, 215, 0, 0.08) 0%, var(--card) 100%);
            padding: 35px 15px;
        }
        .podium-card.second {
            border-color: #c0c0c0;
        }
        .podium-card.third {
            border-color: #cd7f32;
        }
        .podium-medal {
            font-size: 32px;
            margin-bottom: 8px;
        }
        .podium-card.first .podium-medal {
            font-size: 44px;
        }
        .podium-name {
            font-weight: 700;
            font-size: 16px;
            color: #fff;
            margin-bottom: 4px;
        }
        .podium-game {
            font-size: 11px;
            color: var(--muted);
            font-family: "DM Mono", monospace;
        }
        .podium-score {
            font-size: 22px;
            font-weight: 700;
            color: var(--accent);
            margin-top: 10px;
        }
        @media (max-width: 650px) {
            .podium-container {
                grid-template-columns: 1fr;
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
        <a href="index.php">Home</a>
        <a href="games.php">Games</a>
        <a href="leaderboard.php" class="active" style="color:var(--accent); font-weight:700;">Leaderboard</a>

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
    <p class="badge">GLOBAL RANKING</p>
    <h1>Leader<span>board.</span></h1>
    <p>The highest scores and top players across all 10 MiniGameHub challenges.</p>

    <!-- FILTER TABS -->
    <div class="filter-tabs">
        <?php foreach ($gamesList as $g): 
            $isActive = ($g === "All" && $selectedGame === "") || (strtolower($g) === strtolower($selectedGame));
            $href = $g === "All" ? "leaderboard.php" : "leaderboard.php?game=" . urlencode($g);
        ?>
            <a href="<?= $href ?>" class="filter-tab <?= $isActive ? 'active' : '' ?>">
                <?= htmlspecialchars($g) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- TOP 3 PODIUM (if at least 3 scores exist) -->
<?php if (count($scores) >= 3): ?>
    <div class="podium-container">
        <!-- 2nd Place -->
        <div class="podium-card second">
            <div class="podium-medal">🥈</div>
            <div class="podium-name"><?= htmlspecialchars($scores[1]["username"] ?? $scores[1]["player"] ?? "Player") ?></div>
            <div class="podium-game"><?= htmlspecialchars($scores[1]["game"] ?? "Game") ?></div>
            <div class="podium-score"><?= (int)($scores[1]["score"] ?? 0) ?> pts</div>
        </div>

        <!-- 1st Place -->
        <div class="podium-card first">
            <div class="podium-medal">👑 🥇</div>
            <div class="podium-name" style="font-size: 18px;"><?= htmlspecialchars($scores[0]["username"] ?? $scores[0]["player"] ?? "Player") ?></div>
            <div class="podium-game"><?= htmlspecialchars($scores[0]["game"] ?? "Game") ?></div>
            <div class="podium-score" style="font-size: 26px;"><?= (int)($scores[0]["score"] ?? 0) ?> pts</div>
        </div>

        <!-- 3rd Place -->
        <div class="podium-card third">
            <div class="podium-medal">🥉</div>
            <div class="podium-name"><?= htmlspecialchars($scores[2]["username"] ?? $scores[2]["player"] ?? "Player") ?></div>
            <div class="podium-game"><?= htmlspecialchars($scores[2]["game"] ?? "Game") ?></div>
            <div class="podium-score"><?= (int)($scores[2]["score"] ?? 0) ?> pts</div>
        </div>
    </div>
<?php endif; ?>

<!-- LEADERBOARD TABLE -->
<div class="leaderboard">
    <div class="leader-header">
        <span>RANK</span>
        <span>PLAYER</span>
        <span>GAME</span>
        <span>SCORE</span>
    </div>

    <?php if (empty($scores)): ?>
        <div class="empty-board">
            <div>🏆</div>
            <h2>No scores recorded yet for this game.</h2>
            <p>Be the first player to reach the leaderboard!</p>
            <a href="games.php" class="btn primary" style="margin-top: 15px;">PLAY A GAME →</a>
        </div>
    <?php else: ?>
        <?php foreach ($scores as $index => $score): 
            $rank = $index + 1;
            $playerName = $score["username"] ?? $score["player"] ?? "Player";
            $isMe = $logged && ((isset($currentUser["id"]) && isset($score["user_id"]) && $currentUser["id"] === $score["user_id"]) || strtolower($playerName) === strtolower($currentUser["username"] ?? ""));
            $medal = $rank === 1 ? "🥇" : ($rank === 2 ? "🥈" : ($rank === 3 ? "🥉" : "#{$rank}"));
        ?>
            <div class="leader-row" <?= $isMe ? 'style="background: rgba(184, 255, 44, 0.05); border-left: 3px solid var(--accent);"' : '' ?>>
                <strong style="font-size: 16px;">
                    <?= $medal ?>
                </strong>
                <span style="font-weight: 600; color: #ffffff;">
                    <?= htmlspecialchars($playerName) ?>
                    <?php if ($isMe): ?>
                        <small style="color:var(--accent); font-family:'DM Mono', monospace; font-size:10px; margin-left:6px;">(YOU)</small>
                    <?php endif; ?>
                </span>
                <span style="color: var(--muted);">
                    <?= htmlspecialchars($score["game"] ?? "Game") ?>
                </span>
                <strong>
                    <?= (int)($score["score"] ?? 0) ?>
                </strong>
            </div>
        <?php endforeach; ?>
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