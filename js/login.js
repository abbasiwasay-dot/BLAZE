let loginForm = document.getElementById("loginForm");
let registerForm = document.getElementById("registerForm");

let loginTab = document.querySelector('[data-target="loginForm"]');
let registerTab = document.querySelector('[data-target="registerForm"]');

let tabs = document.querySelector(".auth-tabs");

document.querySelectorAll("[data-target]").forEach(item => {

    item.addEventListener("click", function(e) {

        e.preventDefault();

        let target = this.dataset.target;

        if (target === "loginForm") {
            loginForm.classList.add("active");
            registerForm.classList.remove("active");

            loginTab.classList.add("active");
            registerTab.classList.remove("active");

            tabs.classList.remove("register");
        }

        if (target === "registerForm") {
            registerForm.classList.add("active");
            loginForm.classList.remove("active");

            registerTab.classList.add("active");
            loginTab.classList.remove("active");

            tabs.classList.add("register");
        }
    });
});