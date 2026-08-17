/* =========================================================
   MEMORY GAME
   ========================================================= */

const memoryBoard =
    document.getElementById(
        "memoryBoard"
    );


if (memoryBoard) {


    const symbols = [

        "🎮",
        "🚀",
        "🎯",
        "👾",
        "⭐",
        "🔥",
        "💎",
        "🏆"

    ];


    let cards = [];

    let flippedCards = [];

    let matchedPairs = 0;

    let moves = 0;

    let memoryTime = 0;

    let memoryTimerInterval = null;

    let lockBoard = false;


    /* -----------------------------------------------------
       START GAME
    ----------------------------------------------------- */

    window.startMemoryGame =
        function () {

            clearInterval(
                memoryTimerInterval
            );


            cards = [
                ...symbols,
                ...symbols
            ];


            cards.sort(
                () =>
                    Math.random() -
                    0.5
            );


            flippedCards = [];

            matchedPairs = 0;

            moves = 0;

            memoryTime = 0;

            lockBoard = false;


            document.getElementById(
                "moves"
            ).textContent = "0";


            document.getElementById(
                "pairs"
            ).textContent = "0 / 8";


            document.getElementById(
                "memoryTimer"
            ).textContent = "0";


            document.getElementById(
                "memoryResult"
            ).style.display = "none";


            memoryBoard.innerHTML =
                "";


            cards.forEach(
                (symbol, index) => {

                    createMemoryCard(
                        symbol,
                        index
                    );

                }
            );


            memoryTimerInterval =
                setInterval(
                    () => {

                        memoryTime++;


                        document.getElementById(
                            "memoryTimer"
                        ).textContent =
                            memoryTime;

                    },
                    1000
                );

        };


    /* -----------------------------------------------------
       CREATE CARD
    ----------------------------------------------------- */

    function createMemoryCard(
        symbol,
        index
    ) {

        const card =
            document.createElement(
                "button"
            );


        card.className =
            "memory-item";


        card.dataset.index =
            index;


        card.innerHTML = `

            <div class="memory-front">
                ?
            </div>

            <div class="memory-back">
                ${symbol}
            </div>

        `;


        card.addEventListener(
            "click",
            () => flipCard(card)
        );


        memoryBoard.appendChild(
            card
        );

    }


    /* -----------------------------------------------------
       FLIP CARD
    ----------------------------------------------------- */

    function flipCard(card) {

        if (
            lockBoard ||
            card.classList.contains(
                "flipped"
            ) ||
            card.classList.contains(
                "matched"
            )
        ) {

            return;

        }


        card.classList.add(
            "flipped"
        );


        flippedCards.push(card);


        if (
            flippedCards.length === 2
        ) {

            moves++;


            document.getElementById(
                "moves"
            ).textContent =
                moves;


            checkMatch();

        }

    }


    /* -----------------------------------------------------
       CHECK MATCH
    ----------------------------------------------------- */

    function checkMatch() {

        lockBoard = true;


        const first =
            flippedCards[0];


        const second =
            flippedCards[1];


        const firstSymbol =
            first.querySelector(
                ".memory-back"
            ).textContent.trim();


        const secondSymbol =
            second.querySelector(
                ".memory-back"
            ).textContent.trim();


        if (
            firstSymbol ===
            secondSymbol
        ) {

            setTimeout(
                () => {

                    first.classList.add(
                        "matched"
                    );

                    second.classList.add(
                        "matched"
                    );


                    matchedPairs++;


                    document.getElementById(
                        "pairs"
                    ).textContent =
                        `${matchedPairs} / 8`;


                    flippedCards = [];


                    lockBoard = false;


                    if (
                        matchedPairs === 8
                    ) {

                        finishMemoryGame();

                    }

                },
                400
            );

        } else {

            setTimeout(
                () => {

                    first.classList.remove(
                        "flipped"
                    );

                    second.classList.remove(
                        "flipped"
                    );


                    flippedCards = [];


                    lockBoard = false;

                },
                800
            );

        }

    }


    /* -----------------------------------------------------
       FINISH
    ----------------------------------------------------- */

    function finishMemoryGame() {

        clearInterval(
            memoryTimerInterval
        );


        /*
           Better score for fewer moves
           and faster completion.
        */

        let score =
            Math.max(
                100,
                1000 -
                (moves * 20) -
                (memoryTime * 3)
            );


        document.getElementById(
            "memoryFinalScore"
        ).textContent =
            score;


        document.getElementById(
            "memoryResult"
        ).style.display =
            "block";


        saveMemoryScore(score);

    }


    /* -----------------------------------------------------
       SAVE SCORE
    ----------------------------------------------------- */

    function saveMemoryScore(score) {

        fetch(
            "../php/save_score.php",
            {

                method: "POST",

                headers: {
                    "Content-Type":
                        "application/x-www-form-urlencoded"
                },

                body:
                    `game=Memory&score=${score}`

            }
        );

    }


    /* -----------------------------------------------------
       START
    ----------------------------------------------------- */

    startMemoryGame();

}