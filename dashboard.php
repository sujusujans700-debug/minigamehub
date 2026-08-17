<?php

require_once __DIR__ . "/php/auth.php";

requireLogin();

$user = currentUser();

if (!$user) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard | MiniGameHub</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/dashboard.css">

</head>

<body>


<!-- ================= NAVBAR ================= -->

<header class="navbar">


    <!-- LOGO -->

    <a
        href="index.php"
        class="logo"
        style="
            display:flex;
            align-items:center;
            gap:8px;
            text-decoration:none;
        "
    >

        <img
            src="assets/images/icons/logo.jpg"
            alt="MiniGameHub Logo"
            style="
                width:45px;
                height:45px;
                object-fit:contain;
                display:block;
                border-radius:8px;
            "
        >

        <span>
            MINI<span>GAME</span>HUB
        </span>

    </a>



    <!-- NAVIGATION -->

    <nav>


        <!-- DASHBOARD -->

        <a href="dashboard.php">

    🏠

            Dashboard

        </a>



        <!-- GAMES -->

        <a href="games.php">

    🎮
            Games

        </a>



        <!-- LEADERBOARD -->

        <a href="leaderboard.php">

    🏆 

            Leaderboard

        </a>



        <!-- PROFILE -->

        <a href="profile.php">

    👤

            Profile

        </a>



        <!-- SETTINGS -->

        <a href="settings.php">

    ⚙️

            Settings

        </a>



        <!-- LOGOUT -->

        <a href="logout.php">

            🚪 Logout

        </a>


    </nav>

</header>



<!-- ================= MAIN DASHBOARD ================= -->

<main class="dashboard">



    <!-- ================= WELCOME ================= -->

    <section class="welcome">

        <div>

            <p class="badge">
                PLAYER DASHBOARD
            </p>


            <h1>

                Hey,

                <span>

                    <?= htmlspecialchars(
                        $user["username"] ?? "Player"
                    ) ?>

                </span>

                👋

            </h1>


            <p>
                Ready for your next challenge?
            </p>

        </div>

    </section>



    <!-- ================= STATS ================= -->

    <section class="stats">



        <!-- GAMES PLAYED -->

        <div class="stat-card">

            <div class="stat-icon">
                🎮
            </div>

            <span>
                GAMES PLAYED
            </span>

            <strong>

                <?= htmlspecialchars(
                    $user["games_played"] ?? 0
                ) ?>

            </strong>

        </div>



        <!-- GAMES WON -->

        <div class="stat-card">

            <div class="stat-icon">
                🏆
            </div>

            <span>
                GAMES WON
            </span>

            <strong>

                <?= htmlspecialchars(
                    $user["games_won"] ?? 0
                ) ?>

            </strong>

        </div>



        <!-- BEST SCORE -->

        <div class="stat-card">

            <div class="stat-icon">
                ⭐
            </div>

            <span>
                BEST SCORE
            </span>

            <strong>

                <?= htmlspecialchars(
                    $user["best_score"] ?? 0
                ) ?>

            </strong>

        </div>


    </section>



    <!-- ================= GAME LIBRARY ================= -->

    <section class="dashboard-games">


        <div class="dashboard-heading">

            <div>

                <p>
                    GAME LIBRARY
                </p>

                <h2>
                    Choose your challenge.
                </h2>

            </div>


            <a href="games.php">
                View All →
            </a>

        </div>



        <!-- GAME GRID -->

        <div class="game-grid">



            <!-- ================= QUIZ ================= -->

            <a
                href="games/quiz.php"
                class="game-card"
            >

                <span class="game-icon">

                    <img
                        src="assets/images/quiz.jpg"
                        alt="Quick Quiz"
                        style="
                            width:100%;
                            height:180px;
                            object-fit:cover;
                            display:block;
                            border-radius:15px;
                            margin-bottom:20px;
                        "
                    >

                </span>


                <small>
                    01
                </small>


                <h3>
                    Quick Quiz
                </h3>


                <p>
                    Test your knowledge
                    against the clock.
                </p>


                <strong>
                    PLAY →
                </strong>

            </a>



            <!-- ================= TIC TAC TOE ================= -->

            <a
                href="games/tic-tac-toe.php"
                class="game-card"
            >

                <span class="game-icon">

                    <img
                        src="assets/images/tic-tac-toe.jpg"
                        alt="Tic Tac Toe"
                        style="
                            width:100%;
                            height:180px;
                            object-fit:cover;
                            display:block;
                            border-radius:15px;
                            margin-bottom:20px;
                        "
                    >

                </span>


                <small>
                    02
                </small>


                <h3>
                    Tic-Tac-Toe
                </h3>


                <p>
                    Outsmart your opponent
                    and get three in a row.
                </p>


                <strong>
                    PLAY →
                </strong>

            </a>



            <!-- ================= MEMORY ================= -->

            <a
                href="games/memory.php"
                class="game-card"
            >

                <span class="game-icon">

                    <img
                        src="assets/images/memory.jpg"
                        alt="Memory Game"
                        style="
                            width:100%;
                            height:180px;
                            object-fit:cover;
                            display:block;
                            border-radius:15px;
                            margin-bottom:20px;
                        "
                    >

                </span>


                <small>
                    03
                </small>


                <h3>
                    Memory
                </h3>


                <p>
                    Match the cards using
                    as few moves as possible.
                </p>


                <strong>
                    PLAY →
                </strong>

            </a>



            <!-- ================= GUESS IT ================= -->

            <a
                href="games/guess.php"
                class="game-card"
            >

                <span class="game-icon">

                    <img
                        src="assets/images/guess.jpg"
                        alt="Guess It"
                        style="
                            width:100%;
                            height:180px;
                            object-fit:cover;
                            display:block;
                            border-radius:15px;
                            margin-bottom:20px;
                        "
                    >

                </span>


                <small>
                    04
                </small>


                <h3>
                    Guess It
                </h3>


                <p>
                    Find the hidden number
                    with helpful hints.
                </p>


                <strong>
                    PLAY →
                </strong>

            </a>


        </div>

    </section>


</main>


</body>

</html>