/* =========================================================
   ROCK PAPER SCISSORS GAME LOGIC
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {
    const choiceButtons = document.querySelectorAll(".rps-choice-btn");
    const playerHandEl = document.getElementById("playerHand");
    const aiHandEl = document.getElementById("aiHand");
    const statusEl = document.getElementById("rpsStatus");
    const playerScoreEl = document.getElementById("rpsPlayerScore");
    const aiScoreEl = document.getElementById("rpsAiScore");
    const roundEl = document.getElementById("rpsRound");
    const choicesContainer = document.getElementById("rpsChoices");
    const matchResultBox = document.getElementById("rpsMatchResult");
    const resultIcon = document.getElementById("rpsResultIcon");
    const resultTitle = document.getElementById("rpsResultTitle");
    const resultSubtitle = document.getElementById("rpsResultSubtitle");
    const finalPointsEl = document.getElementById("rpsFinalPoints");
    const restartBtn = document.getElementById("restartRpsBtn");

    if (!choiceButtons.length) return;

    const emojiMap = {
        rock: "✊",
        paper: "✋",
        scissors: "✌️"
    };

    const choices = ["rock", "paper", "scissors"];
    let playerScore = 0;
    let aiScore = 0;
    let round = 1;
    let totalPoints = 0;
    let isAnimating = false;

    function playRound(playerChoice) {
        if (isAnimating) return;
        isAnimating = true;

        statusEl.textContent = "Rock... Paper... Scissors...";
        playerHandEl.classList.remove("winner-glow");
        aiHandEl.classList.remove("winner-glow");

        // Shake animation with default rock
        playerHandEl.textContent = "✊";
        aiHandEl.textContent = "✊";
        playerHandEl.style.transform = "rotate(-20deg)";
        aiHandEl.style.transform = "rotate(20deg)";

        setTimeout(() => {
            playerHandEl.style.transform = "rotate(0deg)";
            aiHandEl.style.transform = "rotate(0deg)";

            const aiChoice = choices[Math.floor(Math.random() * choices.length)];

            playerHandEl.textContent = emojiMap[playerChoice];
            aiHandEl.textContent = emojiMap[aiChoice];

            evaluateWinner(playerChoice, aiChoice);
            isAnimating = false;
        }, 600);
    }

    function evaluateWinner(player, ai) {
        if (player === ai) {
            statusEl.textContent = `🤝 It's a Tie! Both chose ${player.toUpperCase()}.`;
        } else if (
            (player === "rock" && ai === "scissors") ||
            (player === "paper" && ai === "rock") ||
            (player === "scissors" && ai === "paper")
        ) {
            playerScore++;
            totalPoints += 100;
            playerScoreEl.textContent = playerScore;
            playerHandEl.classList.add("winner-glow");
            statusEl.textContent = `🎉 You won this round! ${player.toUpperCase()} beats ${ai.toUpperCase()}.`;
        } else {
            aiScore++;
            aiScoreEl.textContent = aiScore;
            aiHandEl.classList.add("winner-glow");
            statusEl.textContent = `🤖 AI bot won this round! ${ai.toUpperCase()} beats ${player.toUpperCase()}.`;
        }

        round++;
        roundEl.textContent = `${Math.min(round, 5)} / 5`;

        // Check Match End (First to 3 wins or 5 rounds finished)
        if (playerScore >= 3 || aiScore >= 3 || round > 5) {
            finishMatch();
        }
    }

    function finishMatch() {
        choicesContainer.style.display = "none";

        if (playerScore > aiScore) {
            totalPoints += 200; // Match victory bonus
            resultIcon.textContent = "👑 🏆";
            resultTitle.textContent = "Series Victory!";
            resultSubtitle.textContent = `You defeated AI ${playerScore} - ${aiScore}!`;
        } else if (playerScore === aiScore) {
            totalPoints += 50;
            resultIcon.textContent = "🤝";
            resultTitle.textContent = "Match Drawn!";
            resultSubtitle.textContent = `Evenly matched ${playerScore} - ${aiScore}.`;
        } else {
            resultIcon.textContent = "💀";
            resultTitle.textContent = "Defeated!";
            resultSubtitle.textContent = `AI won ${aiScore} - ${playerScore}.`;
        }

        finalPointsEl.textContent = totalPoints;
        matchResultBox.style.display = "block";

        saveRpsScore(totalPoints);
    }

    function saveRpsScore(points) {
        if (points <= 0) return;

        fetch("../php/save_score.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `game=Rock Paper Scissors&score=${points}`
        }).catch(err => console.error("Could not save score:", err));
    }

    function restartMatch() {
        playerScore = 0;
        aiScore = 0;
        round = 1;
        totalPoints = 0;

        playerScoreEl.textContent = "0";
        aiScoreEl.textContent = "0";
        roundEl.textContent = "1 / 5";
        statusEl.textContent = "Choose your move to battle!";

        playerHandEl.textContent = "✊";
        aiHandEl.textContent = "✊";
        playerHandEl.classList.remove("winner-glow");
        aiHandEl.classList.remove("winner-glow");

        matchResultBox.style.display = "none";
        choicesContainer.style.display = "flex";
    }

    choiceButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const choice = btn.dataset.choice;
            playRound(choice);
        });
    });

    restartBtn.addEventListener("click", restartMatch);
});
