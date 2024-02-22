const coachApi = {
    init: function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const page = (urlParams.get('page') == undefined ? 1 : urlParams.get('page'));
        coachApi.loadCoachs(page);
        const baseUrl = window.location.origin;
    },

    addAllEventListeners: function() {
        const paginationContainer = document.querySelectorAll('.page-item:not(.disabled):not(.active)');

        paginationContainer.forEach((element) => {
            element.addEventListener('click', (event) => {
                event.preventDefault();    
                const page = parseInt(event.currentTarget.dataset.page);
                
                if (!isNaN(page)) {    
                    coachApi.loadCoachs(page);
                    history.pushState(null, null, `?page=${page}`);
                }
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    },

    renderCoach: function(data) {
        let coachsHTML = '';

        data.items.forEach(coach => {
            coachsHTML += `
            <div class="col-md-6 col-xl-4 col-xxl-3 mb-4 fade-in">
                <div class="card my-3" style="min-height: 450px;">
                    <a href="coach/${coach.id}/${coach.firstname}">
                        <img src="${coach.picture}" class="card-img-top object-fit-cover" alt="Image de profile de ${coach.firstname} ${coach.lastname}" style="height: 200px;">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">${coach.firstname} ${coach.lastname}</h5>
                        <p class="card-text mx-2 ellipsis-4">${coach.presentation}</p>
                    </div>
                    <div class="card-footer text-end">
                        <a class="text-reset" href="coach/${coach.id}/${coach.firstname}"><i class="fa-solid fa-up-right-from-square"></i></a>
                    </div>
                </div>
            </div>
            `;
        });

        const coachListElement = document.getElementById('coachListContainer');
        coachListElement.innerHTML = coachsHTML;

        setTimeout(() => {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(element => element.classList.add('active'));
        }, 0);
    },

    renderPagination: function(data) {
        const totalPages = data.pages;
        let paginationHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            paginationHTML += '<li class="page-item'+((data.page == i) ? ' active' : '')+'" data-page="'+i+'"><span class="page-link" href="#">'+i+'</span></li>';
        }

        let prevDisabled = (data.page < 2) ? ' disabled' : '';
        let nextDisabled = (data.page == data.pages) ? ' disabled' : '';
        let prevPage = parseInt(data.page) - 1;
        let nextPage = parseInt(data.page) + 1;

        paginationContainer = `
            <nav aria-label="Page Navigation">
                <ul class="pagination">
                    <li class="page-item${prevDisabled}" data-page="${prevPage}">
                        <span class="page-link">
                            <span aria-hidden="true">&lt;</span>
                        </span>
                    </li>
                    ${paginationHTML}
                    <li class="page-item${nextDisabled}" data-page="${nextPage}">
                        <span class="page-link">
                            <span aria-hidden="true">&gt;</span>
                        </span>
                    </li>
                </ul>
            </nav>
        `;

        const paginationElement = document.getElementById('paginationContainer');
        paginationElement.innerHTML = paginationContainer;

        coachApi.addAllEventListeners();
    },

    loadCoachs: function(page) {
        history.pushState(null, null, `?page=${page}`);

        fetch(`api/coachs?page=${page}`)
        .then(response => response.json())
        .then(data => {
            coachApi.renderCoach(data);
            coachApi.renderPagination(data);
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des données :', error);
        });
    },
};

document.addEventListener('DOMContentLoaded', coachApi.init);
