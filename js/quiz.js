/* =========================================================
   QUICK QUIZ
   ========================================================= */

const quizQuestions = [

    {
        question: "Which language is used to style web pages?",
        category: "WEB DEVELOPMENT",
        answers: [
            "HTML",
            "CSS",
            "PHP",
            "JSON"
        ],
        correct: 1
    },

    {
        question: "Which language is used to add interactivity to websites?",
        category: "WEB DEVELOPMENT",
        answers: [
            "CSS",
            "HTML",
            "JavaScript",
            "JSON"
        ],
        correct: 2
    },

    {
        question: "What does PHP mainly run on?",
        category: "PROGRAMMING",
        answers: [
            "Browser",
            "Server",
            "Monitor",
            "Keyboard"
        ],
        correct: 1
    },

    {
        question: "Which one is a data format?",
        category: "DATA",
        answers: [
            "JSON",
            "HTML",
            "CSS",
            "JavaScript"
        ],
        correct: 0
    },

    {
        question: "What does HTML stand for?",
        category: "WEB DEVELOPMENT",
        answers: [
            "Hyper Text Markup Language",
            "High Text Machine Language",
            "Hyper Transfer Markup Language",
            "Home Tool Markup Language"
        ],
        correct: 0
    }

];


let currentQuestion = 0;

let score = 0;

let timer = 15;

let timerInterval = null;

let answered = false;


/* =========================================================
   START QUIZ
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {

    if (!document.getElementById("question")) {

        return;

    }

    showQuestion();

});


/* =========================================================
   SHOW QUESTION
   ========================================================= */

function showQuestion() {

    const questionData =
        quizQuestions[currentQuestion];


    answered = false;


    document.getElementById("question").textContent =
        questionData.question;


    document.getElementById("category").textContent =
        questionData.category;


    document.getElementById("questionNumber").textContent =
        `${currentQuestion + 1} / ${quizQuestions.length}`;


    document.getElementById("score").textContent =
        score;


    const progress =
        ((currentQuestion + 1) /
            quizQuestions.length) * 100;


    document.getElementById("progressBar").style.width =
        `${progress}%`;


    const answersContainer =
        document.getElementById("answers");


    answersContainer.innerHTML = "";


    questionData.answers.forEach(
        (answer, index) => {

            const button =
                document.createElement("button");

            button.className =
                "answer-btn";

            button.textContent =
                `${String.fromCharCode(65 + index)}. ${answer}`;


            button.addEventListener(
                "click",
                () => {

                    selectAnswer(
                        index,
                        button
                    );

                }
            );


            answersContainer.appendChild(button);

        }
    );


    document.getElementById("nextBtn").style.display =
        "none";


    startTimer();

}


/* =========================================================
   TIMER
   ========================================================= */

function startTimer() {

    clearInterval(timerInterval);


    timer = 15;


    updateTimer();


    timerInterval =
        setInterval(() => {

            timer--;

            updateTimer();


            if (timer <= 0) {

                clearInterval(timerInterval);

                timeUp();

            }

        }, 1000);

}


/* =========================================================
   UPDATE TIMER
   ========================================================= */

function updateTimer() {

    const timerElement =
        document.getElementById("timer");


    if (!timerElement) return;


    timerElement.textContent =
        timer;


    if (timer <= 5) {

        timerElement.style.color =
            "#ff4d67";

    } else {

        timerElement.style.color =
            "";

    }

}


/* =========================================================
   SELECT ANSWER
   ========================================================= */

function selectAnswer(index, button) {

    if (answered) return;


    answered = true;


    clearInterval(timerInterval);


    const questionData =
        quizQuestions[currentQuestion];


    const allButtons =
        document.querySelectorAll(
            ".answer-btn"
        );


    allButtons.forEach(btn => {

        btn.disabled = true;

    });


    if (index === questionData.correct) {

        button.classList.add("correct");

        score += 10;

    } else {

        button.classList.add("wrong");


        allButtons[
            questionData.correct
        ].classList.add("correct");

    }


    document.getElementById("score").textContent =
        score;


    document.getElementById("nextBtn").style.display =
        "block";

}


/* =========================================================
   TIME UP
   ========================================================= */

function timeUp() {

    if (answered) return;


    answered = true;


    const questionData =
        quizQuestions[currentQuestion];


    const buttons =
        document.querySelectorAll(
            ".answer-btn"
        );


    buttons.forEach(button => {

        button.disabled = true;

    });


    buttons[
        questionData.correct
    ].classList.add("correct");


    document.getElementById("nextBtn").style.display =
        "block";


    document.getElementById("timer").textContent =
        "0";

}


/* =========================================================
   NEXT QUESTION
   ========================================================= */

function nextQuestion() {

    currentQuestion++;


    if (currentQuestion >= quizQuestions.length) {

        finishQuiz();

        return;

    }


    showQuestion();

}


/* =========================================================
   FINISH QUIZ
   ========================================================= */

function finishQuiz() {

    clearInterval(timerInterval);


    document.querySelector(".quiz-header").style.display =
        "none";


    document.querySelector(".progress").style.display =
        "none";


    document.querySelector(".question-area").style.display =
        "none";


    document.getElementById("answers").style.display =
        "none";


    document.getElementById("nextBtn").style.display =
        "none";


    const result =
        document.getElementById("result");


    result.style.display =
        "block";


    document.getElementById("finalScore").textContent =
        `${score} / ${quizQuestions.length * 10}`;


    saveQuizScore();

}


/* =========================================================
   SAVE SCORE
   ========================================================= */

function saveQuizScore() {

    fetch("../php/save_score.php", {

        method: "POST",

        headers: {
            "Content-Type":
                "application/x-www-form-urlencoded"
        },

        body:
            `game=Quiz&score=${score}`

    })
    .catch(error => {

        console.log(
            "Score could not be saved:",
            error
        );

    });

}