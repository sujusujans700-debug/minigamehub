<?php

/*
|--------------------------------------------------------------------------
| MiniGameHub Configuration
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


/*
|--------------------------------------------------------------------------
| Project paths
|--------------------------------------------------------------------------
*/

define(
    "BASE_PATH",
    dirname(__DIR__)
);

define(
    "DATA_PATH",
    BASE_PATH . DIRECTORY_SEPARATOR . "data"
);


/*
|--------------------------------------------------------------------------
| JSON files
|--------------------------------------------------------------------------
*/

define(
    "USERS_FILE",
    DATA_PATH . DIRECTORY_SEPARATOR . "users.json"
);

define(
    "SCORES_FILE",
    DATA_PATH . DIRECTORY_SEPARATOR . "scores.json"
);

define(
    "QUESTIONS_FILE",
    DATA_PATH . DIRECTORY_SEPARATOR . "questions.json"
);

define(
    "GAMES_FILE",
    DATA_PATH . DIRECTORY_SEPARATOR . "games.json"
);


/*
|--------------------------------------------------------------------------
| Application name
|--------------------------------------------------------------------------
*/

define(
    "APP_NAME",
    "MiniGameHub"
);


/*
|--------------------------------------------------------------------------
| Helper: Read JSON
|--------------------------------------------------------------------------
*/

function readJson($file)
{
    if (!file_exists($file)) {
        return [];
    }

    $content = file_get_contents($file);

    if ($content === false || trim($content) === "") {
        return [];
    }

    $data = json_decode($content, true);

    return is_array($data) ? $data : [];
}


/*
|--------------------------------------------------------------------------
| Helper: Write JSON
|--------------------------------------------------------------------------
*/

function writeJson($file, $data)
{
    $json = json_encode(
        $data,
        JSON_PRETTY_PRINT |
        JSON_UNESCAPED_UNICODE
    );

    if ($json === false) {
        return false;
    }

    return file_put_contents(
        $file,
        $json,
        LOCK_EX
    ) !== false;
}