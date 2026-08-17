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
            strtolower($user["email"]) ===
            strtolower($email)
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
            "message" =>
                "Password must contain at least 6 characters."
        ];

    }


    if (findUserByEmail($email)) {

        return [
            "success" => false,
            "message" =>
                "An account with this email already exists."
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

        "created_at" => date(
            "Y-m-d H:i:s"
        )

    ];


    $users[] = $newUser;


    if (!saveUsers($users)) {

        return [
            "success" => false,
            "message" =>
                "Unable to create account."
        ];

    }


    return [
        "success" => true,
        "message" =>
            "Account created successfully."
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


    $user =
        findUserByEmail($email);


    if (!$user) {

        return [
            "success" => false,
            "message" =>
                "Invalid email or password."
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
            "message" =>
                "Invalid email or password."
        ];

    }


    /*
    |--------------------------------------------------------------------------
    | Regenerate session ID
    |--------------------------------------------------------------------------
    */

    session_regenerate_id(true);


    $_SESSION["user_id"] =
        $user["id"];


    $_SESSION["username"] =
        $user["username"];


    $_SESSION["email"] =
        $user["email"];


    return [
        "success" => true,
        "message" => "Login successful."
    ];

}


/*
|--------------------------------------------------------------------------
| Check login
|--------------------------------------------------------------------------
*/

function isLoggedIn()
{
    return isset(
        $_SESSION["user_id"]
    );
}


/*
|--------------------------------------------------------------------------
| Require login
|--------------------------------------------------------------------------
*/

function requireLogin()
{
    if (!isLoggedIn()) {

        header(
            "Location: ../login.php"
        );

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


    return findUserById(
        $_SESSION["user_id"]
    );
}


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

function logoutUser()
{
    $_SESSION = [];


    if (
        ini_get("session.use_cookies")
    ) {

        $params =
            session_get_cookie_params();


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