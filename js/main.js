/* =========================================================
   MINIGAMEHUB - MAIN JAVASCRIPT
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {

    /* -----------------------------------------------------
       PAGE FADE IN
    ----------------------------------------------------- */

    document.body.classList.add("page-loaded");


    /* -----------------------------------------------------
       PASSWORD SHOW / HIDE
    ----------------------------------------------------- */

    const passwordButtons =
        document.querySelectorAll("[data-password-toggle]");

    passwordButtons.forEach(button => {

        button.addEventListener("click", () => {

            const input =
                document.querySelector(
                    button.dataset.passwordToggle
                );

            if (!input) return;

            if (input.type === "password") {

                input.type = "text";

                button.textContent = "HIDE";

            } else {

                input.type = "password";

                button.textContent = "SHOW";

            }

        });

    });


    /* -----------------------------------------------------
       MOBILE MENU
    ----------------------------------------------------- */

    const menuButton =
        document.querySelector(".menu-toggle");

    const navigation =
        document.querySelector(".navbar nav");

    if (menuButton && navigation) {

        menuButton.addEventListener("click", () => {

            navigation.classList.toggle("active");

            menuButton.classList.toggle("active");

        });

    }


    /* -----------------------------------------------------
       ESCAPE KEY CLOSE MENU
    ----------------------------------------------------- */

    document.addEventListener("keydown", event => {

        if (event.key === "Escape") {

            if (navigation) {

                navigation.classList.remove("active");

            }

        }

    });


    /* -----------------------------------------------------
       INTERSECTION ANIMATION
    ----------------------------------------------------- */

    const animatedElements =
        document.querySelectorAll(".animate-on-scroll");

    if ("IntersectionObserver" in window) {

        const observer =
            new IntersectionObserver(
                entries => {

                    entries.forEach(entry => {

                        if (entry.isIntersecting) {

                            entry.target.classList.add("visible");

                            observer.unobserve(
                                entry.target
                            );

                        }

                    });

                },
                {
                    threshold: 0.15
                }
            );

        animatedElements.forEach(element => {

            observer.observe(element);

        });

    }


    /* -----------------------------------------------------
       CURRENT YEAR
    ----------------------------------------------------- */

    const year =
        document.getElementById("currentYear");

    if (year) {

        year.textContent =
            new Date().getFullYear();

    }

});