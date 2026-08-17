/* =========================================================
   SPACE DODGER GAME ENGINE
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("spaceCanvas");
    if (!canvas) return;

    const ctx = canvas.getContext("2d");
    const scoreEl = document.getElementById("spaceScore");
    const starsEl = document.getElementById("spaceStars");
    const bestEl = document.getElementById("spaceBest");
    const overlay = document.getElementById("spaceOverlay");
    const overlayIcon = document.getElementById("spaceOverlayIcon");
    const overlayTitle = document.getElementById("spaceOverlayTitle");
    const overlaySubtitle = document.getElementById("spaceOverlaySubtitle");
    const startBtn = document.getElementById("startSpaceBtn");

    let isPlaying = false;
    let animationId = null;

    let bestScore = parseInt(localStorage.getItem("minigamehub_space_best") || "0", 10);
    bestEl.textContent = bestScore;

    const ship = {
        x: canvas.width / 2 - 15,
        y: canvas.height - 65,
        width: 30,
        height: 38,
        speed: 6,
        dx: 0
    };

    let starsBackground = [];
    let asteroids = [];
    let collectibleStars = [];
    let distance = 0;
    let starsCollected = 0;
    let totalScore = 0;
    let asteroidSpeed = 3;
    let spawnTimer = 0;

    // Generate Starfield
    for (let i = 0; i < 40; i++) {
        starsBackground.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: Math.random() * 2 + 0.5,
            speed: Math.random() * 1.5 + 0.5
        });
    }

    function resetGame() {
        ship.x = canvas.width / 2 - 15;
        ship.dx = 0;
        asteroids = [];
        collectibleStars = [];
        distance = 0;
        starsCollected = 0;
        totalScore = 0;
        asteroidSpeed = 3;
        spawnTimer = 0;

        scoreEl.textContent = "0";
        starsEl.textContent = "0";
    }

    function drawStarsBackground() {
        ctx.fillStyle = "#ffffff";
        starsBackground.forEach(star => {
            ctx.beginPath();
            ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
            ctx.fill();

            star.y += star.speed;
            if (star.y > canvas.height) {
                star.y = 0;
                star.x = Math.random() * canvas.width;
            }
        });
    }

    function drawShip() {
        ctx.save();
        ctx.translate(ship.x + ship.width / 2, ship.y + ship.height / 2);

        // Thruster flame
        if (isPlaying) {
            ctx.fillStyle = Math.random() < 0.5 ? "#ff4d67" : "#ffd700";
            ctx.beginPath();
            ctx.moveTo(-5, ship.height / 2);
            ctx.lineTo(5, ship.height / 2);
            ctx.lineTo(0, ship.height / 2 + 12 + Math.random() * 6);
            ctx.closePath();
            ctx.fill();
        }

        // Ship body
        ctx.fillStyle = "#b8ff2c";
        ctx.beginPath();
        ctx.moveTo(0, -ship.height / 2);
        ctx.lineTo(ship.width / 2, ship.height / 2);
        ctx.lineTo(0, ship.height / 3);
        ctx.lineTo(-ship.width / 2, ship.height / 2);
        ctx.closePath();
        ctx.fill();

        // Cockpit
        ctx.fillStyle = "#08090b";
        ctx.beginPath();
        ctx.arc(0, -2, 4, 0, Math.PI * 2);
        ctx.fill();

        ctx.restore();
    }

    function spawnObjects() {
        spawnTimer++;

        // Spawn Asteroids
        if (spawnTimer % 35 === 0) {
            const size = Math.random() * 22 + 18;
            asteroids.push({
                x: Math.random() * (canvas.width - size),
                y: -size,
                width: size,
                height: size,
                speed: asteroidSpeed + (Math.random() * 1.5),
                rot: 0,
                rotSpeed: (Math.random() - 0.5) * 0.05
            });
        }

        // Spawn Collectible Stars
        if (spawnTimer % 90 === 0) {
            collectibleStars.push({
                x: Math.random() * (canvas.width - 24) + 12,
                y: -20,
                size: 10,
                speed: asteroidSpeed * 0.8
            });
        }

        // Increase difficulty gradually
        if (spawnTimer % 300 === 0) {
            asteroidSpeed += 0.4;
        }
    }

    function update() {
        // Move Ship
        ship.x += ship.dx;
        if (ship.x < 0) ship.x = 0;
        if (ship.x > canvas.width - ship.width) ship.x = canvas.width - ship.width;

        distance += 1;
        totalScore = Math.floor(distance / 5) + (starsCollected * 25);
        scoreEl.textContent = totalScore;

        if (totalScore > bestScore) {
            bestScore = totalScore;
            bestEl.textContent = bestScore;
            localStorage.setItem("minigamehub_space_best", bestScore);
        }

        spawnObjects();

        // Update Asteroids
        for (let i = asteroids.length - 1; i >= 0; i--) {
            const a = asteroids[i];
            a.y += a.speed;
            a.rot += a.rotSpeed;

            // Draw Asteroid
            ctx.save();
            ctx.translate(a.x + a.width / 2, a.y + a.height / 2);
            ctx.rotate(a.rot);
            ctx.fillStyle = "#8b909b";
            ctx.beginPath();
            ctx.arc(0, 0, a.width / 2, 0, Math.PI * 2);
            ctx.fill();
            ctx.strokeStyle = "#ff4d67";
            ctx.lineWidth = 1.5;
            ctx.stroke();
            ctx.restore();

            // Collision check
            if (
                ship.x < a.x + a.width &&
                ship.x + ship.width > a.x &&
                ship.y < a.y + a.height &&
                ship.y + ship.height > a.y
            ) {
                gameOver();
                return;
            }

            if (a.y > canvas.height + 50) {
                asteroids.splice(i, 1);
            }
        }

        // Update Collectible Stars
        for (let i = collectibleStars.length - 1; i >= 0; i--) {
            const s = collectibleStars[i];
            s.y += s.speed;

            // Draw Star
            ctx.save();
            ctx.fillStyle = "#ffd700";
            ctx.shadowColor = "#ffd700";
            ctx.shadowBlur = 10;
            ctx.font = "16px sans-serif";
            ctx.textAlign = "center";
            ctx.fillText("⭐", s.x, s.y);
            ctx.restore();

            // Collision with star
            const dist = Math.hypot(
                (ship.x + ship.width / 2) - s.x,
                (ship.y + ship.height / 2) - s.y
            );

            if (dist < 24) {
                starsCollected++;
                starsEl.textContent = starsCollected;
                collectibleStars.splice(i, 1);
                continue;
            }

            if (s.y > canvas.height + 30) {
                collectibleStars.splice(i, 1);
            }
        }
    }

    function gameLoop() {
        ctx.fillStyle = "#050608";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        drawStarsBackground();

        if (isPlaying) {
            update();
            drawShip();
            animationId = requestAnimationFrame(gameLoop);
        } else {
            drawShip();
        }
    }

    function startGame() {
        resetGame();
        overlay.style.display = "none";
        isPlaying = true;
        cancelAnimationFrame(animationId);
        gameLoop();
    }

    function gameOver() {
        isPlaying = false;
        cancelAnimationFrame(animationId);

        overlayIcon.textContent = "💥";
        overlayTitle.textContent = "Ship Destroyed!";
        overlaySubtitle.textContent = `Score: ${totalScore} pts (${starsCollected} stars collected)`;
        startBtn.textContent = "LAUNCH AGAIN →";
        overlay.style.display = "flex";

        saveSpaceScore(totalScore);
    }

    function saveSpaceScore(finalScore) {
        if (finalScore <= 0) return;

        fetch("../php/save_score.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `game=Space Dodger&score=${finalScore}`
        }).catch(err => console.error("Could not save score:", err));
    }

    // Controls
    window.addEventListener("keydown", e => {
        if (e.key === "ArrowLeft" || e.key === "a" || e.key === "A") {
            ship.dx = -ship.speed;
        } else if (e.key === "ArrowRight" || e.key === "d" || e.key === "D") {
            ship.dx = ship.speed;
        }
    });

    window.addEventListener("keyup", e => {
        if (
            e.key === "ArrowLeft" || e.key === "a" || e.key === "A" ||
            e.key === "ArrowRight" || e.key === "d" || e.key === "D"
        ) {
            ship.dx = 0;
        }
    });

    // Canvas touch / mouse steer
    canvas.addEventListener("mousemove", e => {
        if (!isPlaying) return;
        const rect = canvas.getBoundingClientRect();
        const mouseX = e.clientX - rect.left;
        ship.x = mouseX - ship.width / 2;
    });

    canvas.addEventListener("touchmove", e => {
        if (!isPlaying || !e.touches[0]) return;
        const rect = canvas.getBoundingClientRect();
        const touchX = e.touches[0].clientX - rect.left;
        ship.x = touchX - ship.width / 2;
        e.preventDefault();
    }, { passive: false });

    startBtn.addEventListener("click", startGame);

    // Initial render
    gameLoop();
});
