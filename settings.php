<?php

require_once __DIR__ . "/php/auth.php";

requireLogin();

$user = currentUser();

$profileMsg = "";
$profileSuccess = false;
$passwordMsg = "";
$passwordSuccess = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    if ($action === "update_profile") {
        $username = trim($_POST["username"] ?? "");
        $email = trim($_POST["email"] ?? "");

        $res = updateUserProfile($user["id"], $username, $email);
        $profileMsg = $res["message"];
        $profileSuccess = $res["success"];

        if ($profileSuccess) {
            $user = currentUser();
        }
    } elseif ($action === "update_password") {
        $currentPass = $_POST["current_password"] ?? "";
        $newPass = $_POST["new_password"] ?? "";
        $confirmPass = $_POST["confirm_password"] ?? "";

        if ($newPass !== $confirmPass) {
            $passwordMsg = "New passwords do not match.";
            $passwordSuccess = false;
        } else {
            $res = updateUserPassword($user["id"], $currentPass, $newPass);
            $passwordMsg = $res["message"];
            $passwordSuccess = $res["success"];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | MiniGameHub</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .settings-container {
            max-width: 800px;
            margin: 40px auto 80px;
            padding: 0 20px;
        }
        .settings-card {
            background: var(--card);
            border: 1px solid var(--border);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        .settings-card h2 {
            font-size: 22px;
            margin-bottom: 8px;
        }
        .settings-card p.subtitle {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-family: "DM Mono", monospace;
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .form-group input {
            width: 100%;
            padding: 14px 18px;
            background: var(--card-light);
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s ease;
        }
        .form-group input:focus {
            border-color: var(--accent);
        }
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .alert.success {
            background: rgba(184, 255, 44, 0.12);
            border: 1px solid rgba(184, 255, 44, 0.3);
            color: var(--accent);
        }
        .alert.error {
            background: rgba(255, 77, 103, 0.12);
            border: 1px solid rgba(255, 77, 103, 0.3);
            color: var(--danger);
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
        <a href="profile.php">Profile</a>
        <a href="settings.php" class="active" style="color:var(--accent); font-weight:700;">Settings</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </nav>
</header>

<main class="settings-container">
    <div class="page-heading" style="margin-bottom: 40px; text-align: left;">
        <p class="badge">ACCOUNT PREFERENCES</p>
        <h1 style="font-size: clamp(32px, 5vw, 48px);">Player <span>Settings.</span></h1>
        <p style="color: var(--muted); margin-top: 8px;">Manage your player identity and security settings.</p>
    </div>

    <!-- PROFILE SETTINGS -->
    <div class="settings-card">
        <h2>Profile Details</h2>
        <p class="subtitle">Update your gaming display name and linked email address.</p>

        <?php if ($profileMsg): ?>
            <div class="alert <?= $profileSuccess ? 'success' : 'error' ?>">
                <?= htmlspecialchars($profileMsg) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="settings.php">
            <input type="hidden" name="action" value="update_profile">

            <div class="form-group">
                <label>DISPLAY / USERNAME</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user["username"] ?? "") ?>" required>
            </div>

            <div class="form-group">
                <label>EMAIL ADDRESS</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user["email"] ?? "") ?>" required>
            </div>

            <button type="submit" class="btn primary">
                SAVE PROFILE CHANGES
            </button>
        </form>
    </div>

    <!-- PASSWORD SETTINGS -->
    <div class="settings-card">
        <h2>Security & Password</h2>
        <p class="subtitle">Change your password to keep your account secure.</p>

        <?php if ($passwordMsg): ?>
            <div class="alert <?= $passwordSuccess ? 'success' : 'error' ?>">
                <?= htmlspecialchars($passwordMsg) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="settings.php">
            <input type="hidden" name="action" value="update_password">

            <div class="form-group">
                <label>CURRENT PASSWORD</label>
                <input type="password" name="current_password" placeholder="Enter current password" required>
            </div>

            <div class="form-group">
                <label>NEW PASSWORD (MIN 6 CHARACTERS)</label>
                <input type="password" name="new_password" placeholder="Enter new password" required>
            </div>

            <div class="form-group">
                <label>CONFIRM NEW PASSWORD</label>
                <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            </div>

            <button type="submit" class="btn primary">
                UPDATE PASSWORD
            </button>
        </form>
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
