<?php

require_once __DIR__ . "/auth.php";


/*
|--------------------------------------------------------------------------
| Only logged-in users can save scores
|--------------------------------------------------------------------------
*/

if (!isLoggedIn()) {

    http_response_code(401);

    header(
        "Content-Type: application/json"
    );

    echo json_encode([
        "success" => false,
        "message" =>
            "You must be logged in."
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Get submitted data
|--------------------------------------------------------------------------
*/

$game =
    trim($_POST["game"] ?? "");


$score =
    $_POST["score"] ?? null;


/*
|--------------------------------------------------------------------------
| Validate game
|--------------------------------------------------------------------------
*/

if ($game === "") {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" =>
            "Game name is required."
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Validate score
|--------------------------------------------------------------------------
*/

if (
    $score === null ||
    !is_numeric($score)
) {

    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" =>
            "Valid score is required."
    ]);

    exit;
}


$score = (int)$score;


if ($score < 0) {

    $score = 0;

}


/*
|--------------------------------------------------------------------------
| Get scores
|--------------------------------------------------------------------------
*/

$scores =
    readJson(SCORES_FILE);


/*
|--------------------------------------------------------------------------
| Create score record
|--------------------------------------------------------------------------
*/

$newScore = [

    "id" =>
        uniqid("score_", true),

    "user_id" =>
        $_SESSION["user_id"],

    "username" =>
        $_SESSION["username"],

    "game" =>
        $game,

    "score" =>
        $score,

    "created_at" =>
        date("Y-m-d H:i:s")

];


$scores[] =
    $newScore;


/*
|--------------------------------------------------------------------------
| Save
|--------------------------------------------------------------------------
*/

if (
    !writeJson(
        SCORES_FILE,
        $scores
    )
) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" =>
            "Could not save score."
    ]);

    exit;
}


/*
|--------------------------------------------------------------------------
| Response
|--------------------------------------------------------------------------
*/

header(
    "Content-Type: application/json"
);


echo json_encode([

    "success" => true,

    "message" =>
        "Score saved successfully.",

    "score" =>
        $score

]);