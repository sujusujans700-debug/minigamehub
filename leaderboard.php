<?php

require_once __DIR__ . "/php/auth.php";

$scores = readJson(SCORES_FILE);

usort(
    $scores,
    function ($a, $b) {

        return
            ($b["score"] ?? 0)
            <=>
            ($a["score"] ?? 0);
    }
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Leaderboard | MiniGameHub</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>


<header class="navbar">

    <a href="index.php" class="logo">
        MINI<span>GAME</span>HUB
    </a>

    <nav>

        <a href="index.php">
            Home
        </a>

        <a href="games.php">
            Games
        </a>

        <a href="leaderboard.php">
            Leaderboard
        </a>

        <a href="login.php">
            Login
        </a>

    </nav>

</header>


<main class="page">


<div class="page-heading">

    <p class="badge">
        GLOBAL RANKING
    </p>

    <h1>
        Leader<span>board.</span>
    </h1>

    <p>
        The highest scores in MiniGameHub.
    </p>

</div>


<div class="leaderboard">


    <div class="leader-header">

        <span>
            RANK
        </span>

        <span>
            PLAYER
        </span>

        <span>
            GAME
        </span>

        <span>
            SCORE
        </span>

    </div>


    <?php if (empty($scores)): ?>

        <div class="empty-board">

            🏆

            <h2>
                No scores yet.
            </h2>

            <p>
                Be the first player
                to reach the leaderboard!
            </p>

        </div>

    <?php else: ?>


        <?php foreach (
            $scores as $index => $score
        ): ?>

            <div class="leader-row">

                <strong>
                    #<?= $index + 1 ?>
                </strong>

                <span>
                    <?= htmlspecialchars(
                        $score["player"] ?? "Player"
                    ) ?>
                </span>

                <span>
                    <?= htmlspecialchars(
                        $score["game"] ?? "Game"
                    ) ?>
                </span>

                <strong>
                    <?= (int)(
                        $score["score"] ?? 0
                    ) ?>
                </strong>

            </div>

        <?php endforeach; ?>


    <?php endif; ?>


</div>

</main>

</body>
</html>