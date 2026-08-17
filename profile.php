<?php

require_once __DIR__ . "/php/auth.php";

requireLogin();

$user = currentUser();

$userData = getUserById(
    $user["id"]
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

    <title>Profile | MiniGameHub</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>


<header class="navbar">

    <a href="index.php" class="logo">
        MINI<span>GAME</span>HUB
    </a>

    <nav>

        <a href="dashboard.php">
            Dashboard
        </a>

        <a href="games.php">
            Games
        </a>

        <a href="leaderboard.php">
            Leaderboard
        </a>

        <a href="logout.php">
            Logout
        </a>

    </nav>

</header>


<main class="page profile-page">


<div class="profile-card">


    <div class="avatar">

        <?= strtoupper(
            substr(
                $userData["name"],
                0,
                1
            )
        ) ?>

    </div>


    <p class="badge">
        PLAYER PROFILE
    </p>


    <h1>
        <?= htmlspecialchars(
            $userData["name"]
        ) ?>
    </h1>


    <p class="email">
        <?= htmlspecialchars(
            $userData["email"]
        ) ?>
    </p>


    <div class="profile-stats">


        <div>

            <span>
                🎮
            </span>

            <small>
                GAMES PLAYED
            </small>

            <strong>
                <?= $userData["games_played"] ?? 0 ?>
            </strong>

        </div>


        <div>

            <span>
                🏆
            </span>

            <small>
                GAMES WON
            </small>

            <strong>
                <?= $userData["games_won"] ?? 0 ?>
            </strong>

        </div>


        <div>

            <span>
                ⭐
            </span>

            <small>
                BEST SCORE
            </small>

            <strong>
                <?= $userData["best_score"] ?? 0 ?>
            </strong>

        </div>


    </div>


    <a
        href="games.php"
        class="btn primary"
    >
        PLAY A GAME →
    </a>

</div>

</main>

</body>
</html>