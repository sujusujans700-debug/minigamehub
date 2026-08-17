/* =========================================================
   WHACK-A-MOLE GAME LOGIC
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {
    const holes = document.querySelectorAll(".mole-hole");
    const scoreVal = document.getElementById("wamScore");
    const timerVal = document.getElementById("wamTimer");
    const comboVal = document.getElementById("wamCombo");
    const startBtn = document.getElementById("startWamBtn");
    const resultBox = document.getElementById("wamResult");
    const finalScoreVal = document.getElementById("wamFinalScore");

    if (!holes.length || !startBtn) return;

    let score = 0;
    let combo = 1;
    let streak = 0;
    let timeLeft = 30;
    let gameTimer = null;
    let moleTimer = null;
    let lastHole = null;
    let isPlaying = false;

    function randomTime(min, max) {
        return Math.round(Math.random() * (max - min) + min);
    }

    function randomHole() {
        const idx = Math.floor(Math.random() * holes.length);
        const hole = holes[idx];
        if (hole === lastHole) return randomHole();
        lastHole = hole;
        return hole;
    }

    function popMole() {
        if (!isPlaying) return;

        const hole = randomHole();
        const moleEl = hole.querySelector(".mole");

        // Types: Normal (75%), Gold (15%), Bomb (10%)
        const rand = Math.random();
        if (rand < 0.15) {
            moleEl.textContent = "🌟";
            hole.dataset.type = "gold";
        } else if (rand < 0.25) {
            moleEl.textContent = "💣";
            hole.dataset.type = "bomb";
        } else {
            moleEl.textContent = "🐹";
            hole.dataset.type = "normal";
        }

        hole.classList.remove("hit");
        hole.classList.add("active");

        const time = randomTime(600, 1100);

        moleTimer = setTimeout(() => {
            hole.classList.remove("active");
            if (isPlaying) popMole();
        }, time);
    }

    function whack(e) {
        if (!isPlaying) return;
        const hole = this;

        if (!hole.classList.contains("active") || hole.classList.contains("hit")) return;

        const type = hole.dataset.type || "normal";
        hole.classList.add("hit");
        hole.classList.remove("active");

        if (type === "bomb") {
            streak = 0;
            combo = 1;
            score = Math.max(0, score - 15);
            comboVal.textContent = "x1";
        } else {
            streak++;
            if (streak >= 6) combo = 3;
            else if (streak >= 3) combo = 2;
            else combo = 1;

            comboVal.textContent = `x${combo}`;
            const basePoints = type === "gold" ? 25 : 10;
            score += basePoints * combo;
        }

        scoreVal.textContent = score;
    }

    holes.forEach(hole => hole.addEventListener("click", whack));

    function startGame() {
        if (isPlaying) return;

        isPlaying = true;
        score = 0;
        streak = 0;
        combo = 1;
        timeLeft = 30;

        scoreVal.textContent = "0";
        comboVal.textContent = "x1";
        timerVal.textContent = "30s";
        resultBox.style.display = "none";
        startBtn.style.display = "none";

        popMole();

        gameTimer = setInterval(() => {
            timeLeft--;
            timerVal.textContent = `${timeLeft}s`;

            if (timeLeft <= 5) {
                timerVal.style.color = "#ff4d67";
            } else {
                timerVal.style.color = "var(--accent)";
            }

            if (timeLeft <= 0) {
                endGame();
            }
        }, 1000);
    }

    function endGame() {
        isPlaying = false;
        clearInterval(gameTimer);
        clearTimeout(moleTimer);

        holes.forEach(h => h.classList.remove("active", "hit"));

        finalScoreVal.textContent = score;
        resultBox.style.display = "block";
        startBtn.textContent = "PLAY AGAIN (30s) →";
        startBtn.style.display = "inline-flex";

        saveWamScore(score);
    }

    function saveWamScore(finalScore) {
        if (finalScore <= 0) return;

        fetch("../php/save_score.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `game=Whack-a-Mole&score=${finalScore}`
        }).catch(err => console.error("Could not save score:", err));
    }

    startBtn.addEventListener("click", startGame);
});
