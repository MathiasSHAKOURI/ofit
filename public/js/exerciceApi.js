const exerciceApi = {
    init: function() {
        console.log("init exercice JS");
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const page = urlParams.get('page');
        const muscularGroup = urlParams.get('muscularGroup');
        exerciceApi.loadExercices(page, muscularGroup);
        exerciceApi.addAllEventListeners(muscularGroup);
        exerciceApi.checkResetButtonState(muscularGroup);
        exerciceApi.updateTitle(muscularGroup);
        exerciceApi.checkSelectedMusculargroup(muscularGroup);
    },

    checkResetButtonState: function(selectedMuscularGroup) {
        const resetFilterButton = document.querySelector('#resetExerciceFilter');
        if (selectedMuscularGroup === "all" || selectedMuscularGroup === null) {
            resetFilterButton.classList.add('d-none');
        } else {
            resetFilterButton.classList.remove('d-none');
        }
    },

    checkSelectedMusculargroup: function(selectedMuscularGroup){
        const bodypicture = document.querySelectorAll('.bodypicture');
        if (selectedMuscularGroup) {
            bodypicture.forEach((item) => {
                const itemValue = item.getAttribute('value');
                if (itemValue === selectedMuscularGroup) {
                    item.classList.add('selected');
                } else {
                    item.classList.remove('selected');
                }
            });
        } 
    },

    updateTitle: function(selectedMuscularGroup){
        const exercieTitle = document.querySelector('#exercieTitle');  
        if (selectedMuscularGroup === "all" || selectedMuscularGroup === null) {
            exercieTitle.textContent = "Les exercices";
        } else {
            exercieTitle.textContent = selectedMuscularGroup.charAt(0).toUpperCase() + selectedMuscularGroup.slice(1);
        }
    },

    addAllEventListeners: function(selectedMuscularGroup) {
        const paginationContainer = document.querySelectorAll('.page-item:not(.disabled):not(.active)');
        const resetFilterButton = document.querySelector('#resetExerciceFilter');
        const bodypicture = document.querySelectorAll('.bodypicture');
        const exercieTitle = document.querySelector('#exercieTitle');    

        resetFilterButton.addEventListener('click', () => {
            selectedMuscularGroup === "all";
            resetFilterButton.classList.add('d-none');
            bodypicture.forEach((element) => {
                    element.classList.remove('selected');
                    bodypicture.forEach((item) => {
                        const itemValue = item.getAttribute('value');
                        item.classList.remove('selected');
                    });
                });
            exercieTitle.textContent = "Les exercices";
            exerciceApi.loadExercices(null, null);
        });

        bodypicture.forEach((element) => {
            element.addEventListener('mouseenter', () => {
                const hoveredValue = element.getAttribute('value');

                bodypicture.forEach((item) => {
                    if (item.getAttribute('value') === hoveredValue) {
                        item.classList.add('hovered');
                    }
                });
            });
        
            element.addEventListener('mouseleave', () => {
                bodypicture.forEach((item) => {
                    item.classList.remove('hovered');
                });
            });
        });

        bodypicture.forEach((element) => {
            element.addEventListener('click', (event) => {
                event.preventDefault();
                const exercieTitle = document.querySelector('#exercieTitle');
                const selectedMuscularGroup = event.target.getAttribute('value');
                const page = 1;
                exerciceApi.checkResetButtonState(selectedMuscularGroup);

                element.classList.add('selected');
        
                bodypicture.forEach((item) => {
                    const itemValue = item.getAttribute('value');
                    if (itemValue === selectedMuscularGroup) {
                        item.classList.add('selected');
                    } else {
                        item.classList.remove('selected');
                    }
                });

                exercieTitle.textContent = selectedMuscularGroup.charAt(0).toUpperCase() + selectedMuscularGroup.slice(1);

                exerciceApi.loadExercices(page, selectedMuscularGroup);
                history.pushState(null, null, `?page=${page}&muscularGroup=${selectedMuscularGroup}`);
            });
        });
    },

    renderExercices: function(data) {

        let exercicesHTML = '';

        data.items.forEach(exercice => {
            const exerciceLink = `exercice/${exercice.id}/${exercice.slug}`;

            exercicesHTML += `
            <div class="col-md-6 mb-5">
                <div class="card fade-in" style="height: 100%">
                    <div class="row g-0">
                        <div class="col-xl-4 my-auto" style="height: 230px; overflow: hidden;">
                            <a href="${exerciceLink}" class="text-reset text-decoration-none">
                                <img src="${exercice.picture}" class="rounded-start" alt="image de l'exercice ${exercice.title}" style="object-fit: cover; width: 100%; height: 100%;">
                            </a>
                        </div>
                        <div class="col-xl-8">
                            <div class="card-body d-flex flex-column justify-content-between" style="height: 100%">
                                <div>
                                    <h5 class="card-title">${exercice.title}</h5>
                                    <a href="#">
                                        <div class="btn btn-success btn-sm mb-2">${exercice.muscularGroup.label}</div>
                                    </a>
                                    <p class="card-text ellipsis-4">${exercice.description}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });

        const exerciceListElement = document.getElementById('exerciceListContainer');
        exerciceListElement.innerHTML = exercicesHTML;
        setTimeout(() => {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(element => element.classList.add('active'));
        }, 0);
    },

    renderMessage: function(message, messageType) {
        const exerciceMessage = document.getElementById('exerciceMessage');

        if (message) {
            exerciceApi.emptyContent();
            exerciceMessage.setAttribute('class','alert alert-' + messageType+' text-center fst-italic');
            exerciceMessage.textContent = message;
        } else {
            exerciceMessage.classList.add('d-none');
        }
    },

    emptyContent: function(){
        const exerciceListElement = document.getElementById('exerciceListContainer');
        const paginationElement = document.getElementById('paginationContainer');
        exerciceListElement.innerHTML = '';
        paginationElement.innerHTML = '';
    },

    renderPagination: function(data, selectedMuscularGroup) {
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
                    <li class="page-item${(data.page === i ? ' active' : '')}" data-page="${i}" onclick="exerciceApi.paginationButton(this)">
                        <span class="page-link">${i}</span>
                    </li>`;
            }
        } else {
            paginationHTML += `
                <li class="page-item${(data.page === 1 ? ' active' : '')}" data-page="1" onclick="exerciceApi.paginationButton(this)">
                    <span class="page-link">1</span>
                </li>`;
        
            if (data.page > 2) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        
            for (let i = Math.max(data.page - 1, 2); i <= Math.min(data.page + 1, totalPages - 1); i++) {
                paginationHTML += `
                    <li class="page-item${(data.page === i ? ' active' : '')}" data-page="${i}" onclick="exerciceApi.paginationButton(this)">
                        <span class="page-link">${i}</span>
                    </li>`;
            }
        
            if (data.page < totalPages - 1) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        
            paginationHTML += `
                <li class="page-item${(data.page === totalPages ? ' active' : '')}" data-page="${totalPages}" onclick="exerciceApi.paginationButton(this)">
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
                    <li class="page-item${prevDisabled}" data-page="${prevPage}" onclick="exerciceApi.paginationButton(this)">
                        <span class="page-link">
                            <span aria-hidden="true">&lt;</span>
                        </span>
                    </li>
                    ${paginationHTML}
                    <li class="page-item${nextDisabled}" data-page="${nextPage}" onclick="exerciceApi.paginationButton(this)">
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
        const selectedMuscularGroup = currentUrl.searchParams.get('muscularGroup');
    
        currentUrl.searchParams.set('page', page);
    
        history.pushState(null, null, currentUrl.href);
        exerciceApi.loadExercices(page, selectedMuscularGroup);
        const exerciceListContainer = document.getElementById('exerciceListContainer');
        exerciceListContainer.scrollIntoView();
        
        const offset = 300;
        window.scrollBy(0, -offset);
    },    

    loadExercices: function(page, muscularGroup = null) {
        if(!page) {
            page = 1;
            history.pushState(null, null, `?page=1`);
        }       
        const apiUrl = `api/exercices?page=${page}${muscularGroup ? `&muscularGroup=${muscularGroup}` : ''}`;
        fetch(apiUrl)
        .then(async response => {
            const data = await response.json();
            if (response.status !== 200) {
                exerciceApi.renderMessage(data.message, data.messageType);
            } else {
                if (data.total) {
                    exerciceApi.renderExercices(data);
                    exerciceApi.renderPagination(data, muscularGroup);
                    exerciceApi.renderMessage()
                } else {
                    exerciceApi.renderMessage('Aucun résultat trouvé', 'warning');
                }
            }
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des données :', error);
        });
    },
};

document.addEventListener('DOMContentLoaded', exerciceApi.init);