const workoutApi = {
    init: function() {
        console.log("init workout JS");
        const inputs = workoutApi.getInputs();
        workoutApi.loadWorkouts(inputs.page, inputs.category, inputs.authorId, inputs.min, inputs.max);

        if (inputs.min) {
            document.querySelector('#min').value = inputs.min;
        }

        if (inputs.max) {
            document.querySelector('#max').value = inputs.max;
        }

        const authorFilter = document.querySelector('#coachId');
        for (let i = 0; i < authorFilter.options.length; i++) {
            if (authorFilter.options[i].value === inputs.authorId) {
                authorFilter.selectedIndex = i;
                break;
            }
        }

        const categoryFilter = document.querySelector('#category');
        for (let i = 0; i < categoryFilter.options.length; i++) {
            if (categoryFilter.options[i].value === inputs.category) {
                categoryFilter.selectedIndex = i;
                break;
            }
        }
        workoutApi.addAllEventListeners(authorFilter, categoryFilter);
        workoutApi.checkResetButtonState(authorFilter.value);
        workoutApi.checkResetButtonState(categoryFilter.value);
    },

    checkResetButtonState: function() {
        const resetFilterButton = document.querySelector('#resetFilter');
        const form = document.querySelector('#workoutFilters');
        const formInputs = form.querySelectorAll('input, textarea, select');

        let inputNotEmpty = false;
        formInputs.forEach(function(input) {
            if (input.value.trim() !== '') {
                inputNotEmpty = true;
            }
        });

        if (inputNotEmpty) {
            resetFilterButton.classList.remove('d-none');
        } else {
            resetFilterButton.classList.add('d-none');
        }
    },

    getInputs: function () {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const page = urlParams.get('page');
        const category = urlParams.get('categoryId');
        const authorId = urlParams.get('authorId');
        const min = urlParams.get('min');
        const max = urlParams.get('max');
        return { page, category, authorId, min, max };
    },

    addAllEventListeners: function(authorFilter, categoryFilter) {
        const minInput = document.getElementById("min");
        const maxInput = document.getElementById("max");
        const resetFilterButton = document.querySelector('#resetFilter');
        const workoutFilters = document.querySelector('#workoutFilters');

        resetFilterButton.addEventListener('click', () => {
            workoutFilters.reset();
            resetFilterButton.classList.add('d-none');
            workoutApi.loadWorkouts(null, null, null, null);
        });

        minInput.onchange = maxInput.onchange = () => {
            workoutApi.checkMinMax(minInput, maxInput)
        }

        authorFilter.onchange = () => {
            const selectedAuthorId = authorFilter.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('authorId', selectedAuthorId);
            const inputs = workoutApi.getInputs();
            history.pushState(null, null, `?page=1${inputs.category ? `&categoryId=${inputs.category}` : ''}${selectedAuthorId ? `&authorId=${selectedAuthorId}` : ''}${inputs.min ? `&min=${inputs.min}` : ''}${inputs.max ? `&max=${inputs.max}` : ''}`);
            workoutApi.loadWorkouts(1, inputs.category, selectedAuthorId, inputs.min, inputs.max);
            workoutApi.checkResetButtonState(selectedAuthorId);
        };

        categoryFilter.onchange = () => {
            const selectedCategory = categoryFilter.value;
            const currentUrl = new URL(window.location.href);
            const inputs = workoutApi.getInputs();
            history.pushState(null, null, `?page=1${selectedCategory ? `&categoryId=${selectedCategory}` : ''}${inputs.authorId ? `&authorId=${inputs.authorId}` : ''}${inputs.min ? `&min=${inputs.min}` : ''}${inputs.max ? `&max=${inputs.max}` : ''}`);
            workoutApi.loadWorkouts(1, selectedCategory, inputs.authorId, inputs.min, inputs.max);
            workoutApi.checkResetButtonState(selectedCategory);
        };

        minInput.onchange = () => {
            const minInputValue = minInput.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('min', minInputValue);
            const inputs = workoutApi.getInputs();
            history.pushState(null, null, `?page=1${inputs.category ? `&categoryId=${inputs.category}` : ''}${inputs.authorId ? `&authorId=${inputs.authorId}` : ''}${minInputValue ? `&min=${minInputValue}` : ''}${inputs.max ? `&max=${inputs.max}` : ''}`);
            workoutApi.loadWorkouts(1, inputs.category, inputs.authorId, minInputValue, inputs.max);
            workoutApi.checkResetButtonState(minInputValue);
        };

        maxInput.onchange = () => {
            const maxInputValue = maxInput.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('max', maxInputValue);
            const inputs = workoutApi.getInputs();
            history.pushState(null, null, `?page=1${inputs.category ? `&categoryId=${inputs.category}` : ''}${inputs.authorId ? `&authorId=${inputs.authorId}` : ''}${inputs.min ? `&min=${inputs.min}` : ''}${maxInputValue ? `&max=${maxInputValue}` : ''}`);
            workoutApi.loadWorkouts(1, inputs.category, inputs.authorId, inputs.min, maxInputValue);
            workoutApi.checkResetButtonState(maxInputValue);
        };
    },

    renderWorkout: function(data) {
        let workoutHTML = '';

        data.items.forEach(workout => {
            const workoutLink = `programme/${workout.id}/${workout.slug}`;
            let author = workout.user ? workout.user.pseudo : "Un coach";

            const exercisesHTML = workout.workoutParameters.map(exercice => `
                <a href="exercice/${exercice.exercice.id}/${exercice.exercice.slug}">
                    <div class="overflow-hidden mx-3 rounded shadow mb-3 position-relative" style="width: 100px; height: 80px;">
                        <img src="${exercice.exercice.picture}" alt="${exercice.exercice.title}" class="object-fit-cover w-100 h-100 position-absolute top-50 start-50 translate-middle" style="max-height: 595px;" data-bs-toggle="tooltip" data-bs-title="${exercice.exercice.title}">
                    </div>
                </a>
            `).join('');
            
            workoutHTML += `
            <div class="my-4">
                <div class="card overflow-hidden position-relative fade-in">
                    <div class="row g-0">
                        <div class="col-2 position-relative">
                            <a href="programme/${workout.id}/${workout.slug}" class="text-reset text-decoration-none">
                                <img src="${workout.picture}" class="card-img object-fit-cover h-100 position-absolute top-50 start-50 translate-middle" alt="image du programme {{ workout.title }}">
                            </a>
                        </div>
                        <div class="col-lg-3 col-10">
                            <div class="card-body d-flex flex-column justify-content-between" style="height: 100%">
                                <div class="">
                                    <h5 class="card-title fw-bold">${workout.workoutCategory.label}</h5>
                                    <h6 class="mt-3">${workout.title}</h6>
                                    <h6 class="mt-3">
                                        <i class="bi bi-person-circle"></i> ${author}
                                    </h6>
                                    <h6 class="mt-3"><i class="fa-regular fa-clock"></i> ${workout.duration} min</h6>
                                    <h6 class="mt-3"><i class="fa-solid fa-dumbbell me-1"></i>${workout.workoutParameters.length} exercices</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-7 my-auto pt-2 d-none d-lg-block">
                            <div class="ms-1 d-flex flex-wrap justify-content-start">
                                ${exercisesHTML}
                            </div>
                        </div>
                    </div>
                    <a class="text-reset" href="#"><i class="fa-solid fa-up-right-from-square position-absolute bottom-0 end-0 me-1 mb-1"></i></a>
                </div>
            </div>
            `;
        });

        const workoutListContainer = document.getElementById('workoutListContainer');
        workoutListContainer.innerHTML = workoutHTML;
        setTimeout(() => {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(element => element.classList.add('active'));
        }, 0);
    },

    checkMinMax: function(minInput, maxInput){
        const min = parseInt(minInput.value, 10);
        const max = parseInt(maxInput.value, 10);
        if (min > max) {
            workoutApi.renderMessage('Le temps minimum doit être inferieur ou égale au temps maximum', 'danger');
        } else {
            workoutApi.renderMessage();
        }
    },

    renderPagination: function(data, category, authorId, min, max) {
        const totalPages = data.pages;
        const paginationElement = document.getElementById('paginationContainer');

        if (totalPages === 1) {
            paginationElement.innerHTML = '';
            return;
        }
        let paginationHTML = '';
        if (totalPages < 6) {
            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `
                    <li class="page-item${(data.page === i ? ' active' : '')}" data-page="${i}" onclick="workoutApi.paginationButton(this)">
                        <span class="page-link">${i}</span>
                    </li>`;
            }
        } else {
            paginationHTML += `
                <li class="page-item${(data.page === 1 ? ' active' : '')}" data-page="1" onclick="workoutApi.paginationButton(this)">
                    <span class="page-link">1</span>
                </li>`;
        
            if (data.page > 2) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        
            for (let i = Math.max(data.page - 1, 2); i <= Math.min(data.page + 1, totalPages - 1); i++) {
                paginationHTML += `
                    <li class="page-item${(data.page === i ? ' active' : '')}" data-page="${i}" onclick="workoutApi.paginationButton(this)">
                        <span class="page-link">${i}</span>
                    </li>`;
            }
        
            if (data.page < totalPages - 1) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        
            paginationHTML += `
                <li class="page-item${(data.page === totalPages ? ' active' : '')}" data-page="${totalPages}" onclick="workoutApi.paginationButton(this)">
                    <span class="page-link">${totalPages}</span>
                </li>`;
        }

        let prevDisabled = (data.page < 2) ? ' disabled' : '';
        let nextDisabled = (data.page == data.pages) ? ' disabled' : '';
        let prevPage = parseInt(data.page) - 1;
        let nextPage = parseInt(data.page) + 1;

        paginationContainer = `
            <nav aria-label="Page Navigation">
                <ul class="pagination">
                    <li class="page-item${prevDisabled}" data-page="${prevPage}" onclick="workoutApi.paginationButton(this)">
                        <span class="page-link">
                            <span aria-hidden="true">&lt;</span>
                        </span>
                    </li>
                    ${paginationHTML}
                    <li class="page-item${nextDisabled}" data-page="${nextPage}" onclick="workoutApi.paginationButton(this)">
                        <span class="page-link">
                            <span aria-hidden="true">&gt;</span>
                        </span>
                    </li>
                </ul>
            </nav>
        `;

        paginationElement.innerHTML = paginationContainer;
    },

    paginationButton: function(liElement) {
        if (liElement.classList.contains('disabled')) return;
        const page = parseInt(liElement.dataset.page);
        const currentUrl = new URL(window.location.href);  

        const category = currentUrl.searchParams.get('category');
        const authorId = currentUrl.searchParams.get('authorId');
        const min = currentUrl.searchParams.get('min');
        const max = currentUrl.searchParams.get('max');

        currentUrl.searchParams.set('page', page);
    
        history.pushState(null, null, currentUrl.href);
        workoutApi.loadWorkouts(page, category, authorId, min, max);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },     

    renderMessage: function(message, messageType) {
        const workoutMessage = document.getElementById('workoutMessage');

        if (message) {
            workoutMessage.setAttribute('class','alert alert-' + messageType+' text-center fst-italic');
            workoutMessage.textContent = message;
            workoutApi.emptyContent();
        } else {
            workoutMessage.classList.add('d-none');
        }
    },  

    emptyContent: function(){
        const workoutListContainer = document.getElementById('workoutListContainer');
        const paginationElement = document.getElementById('paginationContainer');
        workoutListContainer.innerHTML = '';
        paginationElement.innerHTML = '';
    },

    loadWorkouts: function(page, category = null, authorId = null, min = null, max = null) {
        if(!page) {
            page = 1;
            history.pushState(null, null, `?page=1`);
        }       
        const apiUrl = `api/programmes?page=${page}${category ? `&categoryId=${category}` : ''}${authorId ? `&authorId=${authorId}` : ''}${min ? `&min=${min}` : ''}${max ? `&max=${max}` : ''}`;
        fetch(apiUrl)
        .then(async response => {
            const data = await response.json();
            if (response.status !== 200) {
                workoutApi.renderMessage(data.message, data.messageType);
            } else {
                if (data.total) {
                    workoutApi.renderWorkout(data);
                    workoutApi.renderPagination(data, category, authorId, min, max);
                    workoutApi.renderMessage()
                } else {
                    workoutApi.renderMessage('Aucun résultat trouvé', 'warning');
                }
            }
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des données :', error);
        });
    },

};
document.addEventListener('DOMContentLoaded', workoutApi.init);