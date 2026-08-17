<?php

require_once __DIR__ . "/config.php";

/*
|--------------------------------------------------------------------------
| Get users
|--------------------------------------------------------------------------
*/

function getUsers()
{
    return readJson(USERS_FILE);
}

/*
|--------------------------------------------------------------------------
| Save users
|--------------------------------------------------------------------------
*/

function saveUsers($users)
{
    return writeJson(
        USERS_FILE,
        $users
    );
}

/*
|--------------------------------------------------------------------------
| Find user by email
|--------------------------------------------------------------------------
*/

function findUserByEmail($email)
{
    $users = getUsers();

    foreach ($users as $user) {
        if (
            isset($user["email"]) &&
            strtolower($user["email"]) === strtolower(trim($email))
        ) {
            return $user;
        }
    }

    return null;
}

/*
|--------------------------------------------------------------------------
| Find user by ID
|--------------------------------------------------------------------------
*/

function findUserById($id)
{
    $users = getUsers();

    foreach ($users as $user) {
        if (
            isset($user["id"]) &&
            $user["id"] === $id
        ) {
            return $user;
        }
    }

    return null;
}

/*
|--------------------------------------------------------------------------
| Register user
|--------------------------------------------------------------------------
*/

function registerUser(
    $username,
    $email,
    $password
) {
    $username = trim($username);
    $email = trim($email);

    if (
        $username === "" ||
        $email === "" ||
        $password === ""
    ) {
        return [
            "success" => false,
            "message" => "All fields are required."
        ];
    }

    if (!filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )) {
        return [
            "success" => false,
            "message" => "Please enter a valid email."
        ];
    }

    if (strlen($password) < 6) {
        return [
            "success" => false,
            "message" => "Password must contain at least 6 characters."
        ];
    }

    if (findUserByEmail($email)) {
        return [
            "success" => false,
            "message" => "An account with this email already exists."
        ];
    }

    $users = getUsers();

    $newUser = [
        "id" => uniqid("user_", true),
        "username" => $username,
        "email" => $email,
        "password" => password_hash(
            $password,
            PASSWORD_DEFAULT
        ),
        "created_at" => date("Y-m-d H:i:s")
    ];

    $users[] = $newUser;

    if (!saveUsers($users)) {
        return [
            "success" => false,
            "message" => "Unable to create account."
        ];
    }

    return [
        "success" => true,
        "message" => "Account created successfully.",
        "user" => $newUser
    ];
}

/*
|--------------------------------------------------------------------------
| Login user
|--------------------------------------------------------------------------
*/

function loginUser(
    $email,
    $password
) {
    $email = trim($email);

    $user = findUserByEmail($email);

    if (!$user) {
        return [
            "success" => false,
            "message" => "Invalid email or password."
        ];
    }

    if (
        !isset($user["password"]) ||
        !password_verify(
            $password,
            $user["password"]
        )
    ) {
        return [
            "success" => false,
            "message" => "Invalid email or password."
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Regenerate session ID
    |--------------------------------------------------------------------------
    */

    session_regenerate_id(true);

    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];
    $_SESSION["email"] = $user["email"];

    return [
        "success" => true,
        "message" => "Login successful.",
        "user" => $user
    ];
}

/*
|--------------------------------------------------------------------------
| Check login
|--------------------------------------------------------------------------
*/

function isLoggedIn()
{
    return isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"]);
}

/*
|--------------------------------------------------------------------------
| Require login
|--------------------------------------------------------------------------
*/

function requireLogin($redirect = null)
{
    if (!isLoggedIn()) {
        if ($redirect === null) {
            $script = $_SERVER["SCRIPT_NAME"] ?? "";
            if (strpos($script, "/games/") !== false) {
                $redirect = "../login.php";
            } else {
                $redirect = "login.php";
            }
        }

        header("Location: " . $redirect);
        exit;
    }
}

/*
|--------------------------------------------------------------------------
| Current user
|--------------------------------------------------------------------------
*/

function currentUser()
{
    if (!isLoggedIn()) {
        return null;
    }

    $user = findUserById($_SESSION["user_id"]);
    if (!$user) {
        return null;
    }

    // Attach dynamic calculated stats
    $stats = getUserStats($user["id"], $user["username"] ?? "");
    $user["games_played"] = $stats["games_played"];
    $user["games_won"] = $stats["games_won"];
    $user["best_score"] = $stats["best_score"];
    $user["win_rate"] = $stats["win_rate"];
    $user["recent_scores"] = $stats["recent_scores"];

    return $user;
}

/*
|--------------------------------------------------------------------------
| Get user stats dynamically from scores.json
|--------------------------------------------------------------------------
*/

function getUserStats($userId, $username = "")
{
    $scores = readJson(SCORES_FILE);
    $userScores = [];

    foreach ($scores as $s) {
        $matchesUser = false;
        if (isset($s["user_id"]) && $s["user_id"] === $userId) {
            $matchesUser = true;
        } elseif ($username !== "" && isset($s["username"]) && strtolower($s["username"]) === strtolower($username)) {
            $matchesUser = true;
        }

        if ($matchesUser) {
            $userScores[] = $s;
        }
    }

    $gamesPlayed = count($userScores);
    $gamesWon = 0;
    $bestScore = 0;

    foreach ($userScores as $scoreItem) {
        $val = (int)($scoreItem["score"] ?? 0);
        if ($val > $bestScore) {
            $bestScore = $val;
        }
        if ($val > 0) {
            $gamesWon++;
        }
    }

    // Sort recent scores descending by creation date or array order
    usort($userScores, function ($a, $b) {
        $tA = strtotime($a["created_at"] ?? "now");
        $tB = strtotime($b["created_at"] ?? "now");
        return $tB <=> $tA;
    });

    $recentScores = array_slice($userScores, 0, 5);
    $winRate = $gamesPlayed > 0 ? round(($gamesWon / $gamesPlayed) * 100) : 0;

    return [
        "games_played" => $gamesPlayed,
        "games_won" => $gamesWon,
        "best_score" => $bestScore,
        "win_rate" => $winRate,
        "recent_scores" => $recentScores
    ];
}

/*
|--------------------------------------------------------------------------
| Update user profile
|--------------------------------------------------------------------------
*/

function updateUserProfile($userId, $username, $email)
{
    $username = trim($username);
    $email = trim($email);

    if ($username === "" || $email === "") {
        return [
            "success" => false,
            "message" => "Username and email cannot be empty."
        ];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return [
            "success" => false,
            "message" => "Please enter a valid email."
        ];
    }

    $users = getUsers();
    $found = false;

    foreach ($users as &$user) {
        if ($user["id"] !== $userId && strtolower($user["email"]) === strtolower($email)) {
            return [
                "success" => false,
                "message" => "This email is already in use by another account."
            ];
        }

        if ($user["id"] === $userId) {
            $user["username"] = $username;
            $user["email"] = $email;
            $found = true;
        }
    }

    if (!$found) {
        return [
            "success" => false,
            "message" => "User not found."
        ];
    }

    if (!saveUsers($users)) {
        return [
            "success" => false,
            "message" => "Failed to update profile."
        ];
    }

    $_SESSION["username"] = $username;
    $_SESSION["email"] = $email;

    return [
        "success" => true,
        "message" => "Profile updated successfully."
    ];
}

/*
|--------------------------------------------------------------------------
| Update user password
|--------------------------------------------------------------------------
*/

function updateUserPassword($userId, $currentPassword, $newPassword)
{
    if (strlen($newPassword) < 6) {
        return [
            "success" => false,
            "message" => "New password must be at least 6 characters."
        ];
    }

    $users = getUsers();
    $found = false;

    foreach ($users as &$user) {
        if ($user["id"] === $userId) {
            if (!password_verify($currentPassword, $user["password"])) {
                return [
                    "success" => false,
                    "message" => "Incorrect current password."
                ];
            }

            $user["password"] = password_hash($newPassword, PASSWORD_DEFAULT);
            $found = true;
            break;
        }
    }

    if (!$found) {
        return [
            "success" => false,
            "message" => "User not found."
        ];
    }

    if (!saveUsers($users)) {
        return [
            "success" => false,
            "message" => "Failed to update password."
        ];
    }

    return [
        "success" => true,
        "message" => "Password updated successfully."
    ];
}

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

function logoutUser()
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            "",
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}