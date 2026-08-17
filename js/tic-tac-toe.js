/* =========================================================
   TIC TAC TOE
   ========================================================= */

const board =
    document.getElementById("board");


if (board) {


    const cells =
        document.querySelectorAll(
            "#board button"
        );


    const status =
        document.getElementById(
            "gameStatus"
        );


    const restartButton =
        document.getElementById(
            "restartBtn"
        );


    const playerScoreElement =
        document.getElementById(
            "playerScore"
        );


    const computerScoreElement =
        document.getElementById(
            "computerScore"
        );


    const drawScoreElement =
        document.getElementById(
            "drawScore"
        );


    let gameBoard =
        [
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            "",
            ""
        ];


    let gameActive = true;


    let playerScore = 0;

    let computerScore = 0;

    let drawScore = 0;


    const winningPatterns = [

        [0, 1, 2],

        [3, 4, 5],

        [6, 7, 8],

        [0, 3, 6],

        [1, 4, 7],

        [2, 5, 8],

        [0, 4, 8],

        [2, 4, 6]

    ];


    /* -----------------------------------------------------
       PLAYER MOVE
    ----------------------------------------------------- */

    cells.forEach(cell => {

        cell.addEventListener(
            "click",
            () => {

                const index =
                    Number(
                        cell.dataset.index
                    );


                if (
                    gameBoard[index] !== "" ||
                    !gameActive
                ) {

                    return;

                }


                makeMove(
                    index,
                    "X"
                );


                const result =
                    checkWinner();


                if (result) {

                    finishGame(result);

                    return;

                }


                gameActive = false;

                status.textContent =
                    "Computer is thinking...";


                setTimeout(
                    computerMove,
                    500
                );

            }
        );

    });


    /* -----------------------------------------------------
       MAKE MOVE
    ----------------------------------------------------- */

    function makeMove(index, player) {

        gameBoard[index] =
            player;


        cells[index].textContent =
            player;


        cells[index].style.color =
            player === "X"
                ? "#b8ff2c"
                : "#ffffff";

    }


    /* -----------------------------------------------------
       COMPUTER MOVE
    ----------------------------------------------------- */

    function computerMove() {

        if (!gameActive) {

            return;

        }


        const available =
            gameBoard
                .map(
                    (value, index) =>
                        value === ""
                            ? index
                            : null
                )
                .filter(
                    value =>
                        value !== null
                );


        if (available.length === 0) {

            return;

        }


        /* Try to win */

        let move =
            findWinningMove("O");


        /* Block player */

        if (move === null) {

            move =
                findWinningMove("X");

        }


        /* Take center */

        if (
            move === null &&
            gameBoard[4] === ""
        ) {

            move = 4;

        }


        /* Random move */

        if (move === null) {

            move =
                available[
                    Math.floor(
                        Math.random() *
                        available.length
                    )
                ];

        }


        makeMove(
            move,
            "O"
        );


        const result =
            checkWinner();


        if (result) {

            finishGame(result);

            return;

        }


        gameActive = true;

        status.textContent =
            "Your turn";

    }


    /* -----------------------------------------------------
       FIND WINNING MOVE
    ----------------------------------------------------- */

    function findWinningMove(player) {

        for (
            let i = 0;
            i < gameBoard.length;
            i++
        ) {

            if (gameBoard[i] !== "") {

                continue;

            }


            gameBoard[i] =
                player;


            const won =
                hasWinner(player);


            gameBoard[i] =
                "";


            if (won) {

                return i;

            }

        }


        return null;

    }


    /* -----------------------------------------------------
       CHECK WINNER
    ----------------------------------------------------- */

    function checkWinner() {

        for (
            const pattern
            of winningPatterns
        ) {

            const [a, b, c] =
                pattern;


            if (
                gameBoard[a] &&
                gameBoard[a] ===
                    gameBoard[b] &&
                gameBoard[a] ===
                    gameBoard[c]
            ) {

                return {
                    winner:
                        gameBoard[a],

                    pattern:
                        pattern

                };

            }

        }


        if (
            gameBoard.every(
                cell => cell !== ""
            )
        ) {

            return {
                winner: "draw"
            };

        }


        return null;

    }


    /* -----------------------------------------------------
       CHECK SPECIFIC PLAYER
    ----------------------------------------------------- */

    function hasWinner(player) {

        return winningPatterns.some(
            pattern => {

                return pattern.every(
                    index =>
                        gameBoard[index] ===
                        player
                );

            }
        );

    }


    /* -----------------------------------------------------
       FINISH GAME
    ----------------------------------------------------- */

    function finishGame(result) {

        gameActive = false;


        if (
            result.winner ===
            "draw"
        ) {

            drawScore++;

            drawScoreElement.textContent =
                drawScore;

            status.textContent =
                "It's a draw!";

            return;

        }


        result.pattern.forEach(
            index => {

                cells[index]
                    .classList.add(
                        "win"
                    );

            }
        );


        if (
            result.winner === "X"
        ) {

            playerScore++;

            playerScoreElement.textContent =
                playerScore;

            status.textContent =
                "🎉 You won!";

        } else {

            computerScore++;

            computerScoreElement.textContent =
                computerScore;

            status.textContent =
                "Computer won!";

        }


        saveTicTacToeScore(
            result.winner
        );

    }


    /* -----------------------------------------------------
       RESTART
    ----------------------------------------------------- */

    restartButton.addEventListener(
        "click",
        restartGame
    );


    function restartGame() {

        gameBoard =
            [
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                ""
            ].slice(0, 9);


        gameActive = true;


        cells.forEach(cell => {

            cell.textContent =
                "";

            cell.classList.remove(
                "win"
            );

        });


        status.textContent =
            "Your turn";

    }


    /* -----------------------------------------------------
       SAVE SCORE
    ----------------------------------------------------- */

    function saveTicTacToeScore(
        winner
    ) {

        if (winner !== "X") {

            return;

        }


        fetch(
            "../php/save_score.php",
            {

                method: "POST",

                headers: {
                    "Content-Type":
                        "application/x-www-form-urlencoded"
                },

                body:
                    "game=Tic-Tac-Toe&score=10"

            }
        );

    }

}