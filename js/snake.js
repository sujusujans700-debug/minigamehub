/* =========================================================
   SNAKE ARCADE GAME ENGINE
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("snakeCanvas");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    const scoreElement = document.getElementById("snakeScore");
    const lengthElement = document.getElementById("snakeLength");
    const bestElement = document.getElementById("snakeBest");
    const overlay = document.getElementById("snakeOverlay");
    const overlayIcon = document.getElementById("overlayIcon");
    const overlayTitle = document.getElementById("overlayTitle");
    const overlaySubtitle = document.getElementById("overlaySubtitle");
    const startBtn = document.getElementById("startSnakeBtn");

    const gridSize = 20;
    const tileCount = canvas.width / gridSize; // 20x20 grid

    let snake = [];
    let food = { x: 15, y: 15, isGold: false };
    let dx = 0;
    let dy = 0;
    let nextDx = 0;
    let nextDy = 0;
    let score = 0;
    let bestScore = parseInt(localStorage.getItem("minigamehub_snake_best") || "0", 10);
    bestElement.textContent = bestScore;

    let gameLoop = null;
    let isRunning = false;
    let speed = 120;

    function resetGame() {
        snake = [
            { x: 10, y: 10 },
            { x: 9, y: 10 },
            { x: 8, y: 10 }
        ];
        dx = 1;
        dy = 0;
        nextDx = 1;
        nextDy = 0;
        score = 0;
        speed = 120;
        scoreElement.textContent = "0";
        lengthElement.textContent = snake.length;
        spawnFood();
    }

    function spawnFood() {
        let valid = false;
        while (!valid) {
            food.x = Math.floor(Math.random() * tileCount);
            food.y = Math.floor(Math.random() * tileCount);
            valid = !snake.some(segment => segment.x === food.x && segment.y === food.y);
        }
        food.isGold = Math.random() < 0.2; // 20% chance of golden apple
    }

    function draw() {
        // Clear background
        ctx.fillStyle = "#08090b";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // Draw grid lines subtly
        ctx.strokeStyle = "#12151c";
        ctx.lineWidth = 0.5;
        for (let i = 0; i < canvas.width; i += gridSize) {
            ctx.beginPath();
            ctx.moveTo(i, 0);
            ctx.lineTo(i, canvas.height);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(0, i);
            ctx.lineTo(canvas.width, i);
            ctx.stroke();
        }

        // Draw Food
        if (food.isGold) {
            ctx.fillStyle = "#ffd700";
            ctx.shadowColor = "#ffd700";
            ctx.shadowBlur = 12;
        } else {
            ctx.fillStyle = "#ff4d67";
            ctx.shadowColor = "#ff4d67";
            ctx.shadowBlur = 8;
        }
        ctx.beginPath();
        ctx.arc(
            food.x * gridSize + gridSize / 2,
            food.y * gridSize + gridSize / 2,
            gridSize / 2 - 2,
            0,
            Math.PI * 2
        );
        ctx.fill();
        ctx.shadowBlur = 0;

        // Draw Snake
        snake.forEach((segment, index) => {
            if (index === 0) {
                // Head
                ctx.fillStyle = "#b8ff2c";
                ctx.shadowColor = "#b8ff2c";
                ctx.shadowBlur = 8;
            } else {
                ctx.fillStyle = index % 2 === 0 ? "#8fce16" : "#72a812";
                ctx.shadowBlur = 0;
            }

            ctx.fillRect(
                segment.x * gridSize + 1,
                segment.y * gridSize + 1,
                gridSize - 2,
                gridSize - 2
            );
        });
        ctx.shadowBlur = 0;
    }

    function update() {
        dx = nextDx;
        dy = nextDy;

        const head = { x: snake[0].x + dx, y: snake[0].y + dy };

        // Wall collision
        if (head.x < 0 || head.x >= tileCount || head.y < 0 || head.y >= tileCount) {
            gameOver();
            return;
        }

        // Self collision
        if (snake.some(segment => segment.x === head.x && segment.y === head.y)) {
            gameOver();
            return;
        }

        snake.unshift(head);

        // Check food collision
        if (head.x === food.x && head.y === food.y) {
            const points = food.isGold ? 30 : 10;
            score += points;
            scoreElement.textContent = score;
            lengthElement.textContent = snake.length;

            if (score > bestScore) {
                bestScore = score;
                bestElement.textContent = bestScore;
                localStorage.setItem("minigamehub_snake_best", bestScore);
            }

            // Speed up slightly as snake grows
            if (speed > 60) speed -= 1.5;

            spawnFood();
            clearInterval(gameLoop);
            gameLoop = setInterval(updateAndDraw, speed);
        } else {
            snake.pop();
        }
    }

    function updateAndDraw() {
        update();
        draw();
    }

    function startGame() {
        resetGame();
        overlay.style.display = "none";
        isRunning = true;
        clearInterval(gameLoop);
        gameLoop = setInterval(updateAndDraw, speed);
        draw();
    }

    function gameOver() {
        clearInterval(gameLoop);
        isRunning = false;

        overlayIcon.textContent = "💥";
        overlayTitle.textContent = "Game Over!";
        overlaySubtitle.textContent = `You scored ${score} points!`;
        startBtn.textContent = "PLAY AGAIN →";
        overlay.style.display = "flex";

        saveSnakeScore(score);
    }

    function saveSnakeScore(finalScore) {
        if (finalScore <= 0) return;

        fetch("../php/save_score.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `game=Snake&score=${finalScore}`
        }).catch(err => console.error("Could not save score:", err));
    }

    // Keyboard Controls
    window.addEventListener("keydown", e => {
        if (!isRunning && (e.key === "Enter" || e.key === " ")) {
            startGame();
            return;
        }

        switch (e.key) {
            case "ArrowUp":
            case "w":
            case "W":
                if (dy === 0) { nextDx = 0; nextDy = -1; }
                e.preventDefault();
                break;
            case "ArrowDown":
            case "s":
            case "S":
                if (dy === 0) { nextDx = 0; nextDy = 1; }
                e.preventDefault();
                break;
            case "ArrowLeft":
            case "a":
            case "A":
                if (dx === 0) { nextDx = -1; nextDy = 0; }
                e.preventDefault();
                break;
            case "ArrowRight":
            case "d":
            case "D":
                if (dx === 0) { nextDx = 1; nextDy = 0; }
                e.preventDefault();
                break;
        }
    });

    // D-Pad Touch / Button Controls
    document.getElementById("dpadUp")?.addEventListener("click", () => { if (dy === 0) { nextDx = 0; nextDy = -1; } });
    document.getElementById("dpadDown")?.addEventListener("click", () => { if (dy === 0) { nextDx = 0; nextDy = 1; } });
    document.getElementById("dpadLeft")?.addEventListener("click", () => { if (dx === 0) { nextDx = -1; nextDy = 0; } });
    document.getElementById("dpadRight")?.addEventListener("click", () => { if (dx === 0) { nextDx = 1; nextDy = 0; } });

    startBtn.addEventListener("click", startGame);

    // Initial render
    resetGame();
    draw();
});
