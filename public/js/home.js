const scrollIn = {
    init: function() {
        console.log("init scroll JS");
        const triggerPointAjust = 1.2;
        scrollIn.articles(triggerPointAjust);
        scrollIn.histoire(triggerPointAjust);
        scrollIn.programmes(triggerPointAjust);
        scrollIn.coachs(triggerPointAjust);
    },

    articles: function(triggerPointAjust) {
        const articles = document.querySelector(".articles");
        articles.classList.add("active");

        window.addEventListener("scroll", function() {
            var scroll = window.scrollY;
            var windowHeight = window.innerHeight;
            var offset = articles.offsetTop;
            var height = articles.offsetHeight;

            var triggerPoint = windowHeight / triggerPointAjust;

            if (scroll + triggerPoint >= offset && scroll <= offset + height) {
                articles.classList.add("active");
            } else {
                articles.classList.remove("active");
            }
        });
    },

    histoire: function(triggerPointAjust) {
        const histoire = document.querySelector(".histoire");

        window.addEventListener("scroll", function() {
            var scroll = window.scrollY;
            var windowHeight = window.innerHeight;
            var offset = histoire.offsetTop;
            var height = histoire.offsetHeight;

            var triggerPoint = windowHeight / triggerPointAjust;

            if (scroll + triggerPoint >= offset && scroll <= offset + height) {
                histoire.classList.add("active");
            } else {
                histoire.classList.remove("active");
            }
        });
    },

    programmes: function(triggerPointAjust) {
        const programmes = document.querySelector(".programmes");

        window.addEventListener("scroll", function() {
            var scroll = window.scrollY;
            var windowHeight = window.innerHeight;
            var offset = programmes.offsetTop;
            var height = programmes.offsetHeight;

            var triggerPoint = windowHeight / triggerPointAjust;

            if (scroll + triggerPoint >= offset && scroll <= offset + height) {
                programmes.classList.add("active");
            } else {
                programmes.classList.remove("active");
            }
        });
    },

    coachs: function(triggerPointAjust) {
        const coachs = document.querySelector(".coachs");

        window.addEventListener("scroll", function() {
            var scroll = window.scrollY;
            var windowHeight = window.innerHeight;
            var offset = coachs.offsetTop;
            var height = coachs.offsetHeight;

            var triggerPoint = windowHeight / triggerPointAjust;

            if (scroll + triggerPoint >= offset && scroll <= offset + height) {
                coachs.classList.add("active");
            } else {
                coachs.classList.remove("active");
            }
        });
    },
}

document.addEventListener('DOMContentLoaded', scrollIn.init);
