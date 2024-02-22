const goTopButton = document.getElementById("goTopButton");

window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
        goTopButton.style.opacity = "0.7";
    } else {
        goTopButton.style.opacity = "0";
    }
});

goTopButton.onclick = (event) => {
    event.preventDefault();
    window.scrollTo({ top: 0, behavior: 'instant' });
};
