/* =========================================================
   GUESS THE NUMBER
   ========================================================= */

const guessInput =
    document.getElementById(
        "guessInput"
    );


const guessButton =
    document.getElementById(
        "guessBtn"
    );


if (
    guessInput &&
    guessButton
) {


    let secretNumber =
        generateNumber();


    let attempts = 0;


    let bestAttempts =
        localStorage.getItem(
            "minigamehub_best_guess"
        );


    const message =
        document.getElementById(
            "guessMessage"
        );


    const attemptsElement =
        document.getElementById(
            "attempts"
        );


    const bestElement =
        document.getElementById(
            "bestAttempts"
        );


    const restartButton =
        document.getElementById(
            "guessRestart"
        );


    /* -----------------------------------------------------
       SHOW BEST SCORE
    ----------------------------------------------------- */

    if (bestAttempts) {

        bestElement.textContent =
            bestAttempts;

    }


    /* -----------------------------------------------------
       GENERATE NUMBER
    ----------------------------------------------------- */

    function generateNumber() {

        return Math.floor(
            Math.random() * 100
        ) + 1;

    }


    /* -----------------------------------------------------
       MAKE GUESS
    ----------------------------------------------------- */

    function makeGuess() {

        const guess =
            Number(
                guessInput.value
            );


        if (
            !guess ||
            guess < 1 ||
            guess > 100
        ) {

            message.textContent =
                "⚠ Enter a number between 1 and 100.";

            message.style.color =
                "#ff4d67";

            return;

        }


        attempts++;


        attemptsElement.textContent =
            attempts;


        if (
            guess === secretNumber
        ) {

            playerWon();

            return;

        }


        if (
            guess < secretNumber
        ) {

            message.textContent =
                "📈 Too low! Try a higher number.";

        } else {

            message.textContent =
                "📉 Too high! Try a lower number.";

        }


        message.style.color =
            "#b8ff2c";


        guessInput.select();

    }


    /* -----------------------------------------------------
       PLAYER WINS
    ----------------------------------------------------- */

    function playerWon() {

        message.textContent =
            `🎉 Correct! The number was ${secretNumber}.`;


        message.style.color =
            "#b8ff2c";


        guessInput.disabled =
            true;


        guessButton.disabled =
            true;


        if (
            !bestAttempts ||
            attempts <
            Number(bestAttempts)
        ) {

            bestAttempts =
                attempts;


            localStorage.setItem(
                "minigamehub_best_guess",
                bestAttempts
            );


            bestElement.textContent =
                bestAttempts;

        }


        const score =
            Math.max(
                100,
                1000 -
                ((attempts - 1) * 50)
            );


        saveGuessScore(score);

    }


    /* -----------------------------------------------------
       BUTTON
    ----------------------------------------------------- */

    guessButton.addEventListener(
        "click",
        makeGuess
    );


    /* -----------------------------------------------------
       ENTER KEY
    ----------------------------------------------------- */

    guessInput.addEventListener(
        "keydown",
        event => {

            if (
                event.key ===
                "Enter"
            ) {

                makeGuess();

            }

        }
    );


    /* -----------------------------------------------------
       NEW NUMBER
    ----------------------------------------------------- */

    restartButton.addEventListener(
        "click",
        newGame
    );


    function newGame() {

        secretNumber =
            generateNumber();


        attempts = 0;


        attemptsElement.textContent =
            "0";


        message.textContent =
            "Enter a number to begin.";


        message.style.color =
            "";


        guessInput.value =
            "";


        guessInput.disabled =
            false;


        guessButton.disabled =
            false;


        guessInput.focus();

    }


    /* -----------------------------------------------------
       SAVE SCORE
    ----------------------------------------------------- */

    function saveGuessScore(score) {

        fetch(
            "../php/save_score.php",
            {

                method: "POST",

                headers: {
                    "Content-Type":
                        "application/x-www-form-urlencoded"
                },

                body:
                    `game=Guess It&score=${score}`

            }
        )
        .catch(error => {

            console.log(
                "Score could not be saved:",
                error
            );

        });

    }

}