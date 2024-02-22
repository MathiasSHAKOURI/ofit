const articlesApi = {
    init: function() {
        console.log("init article JS")
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const page = urlParams.get('page');
        const authorId = urlParams.get('authorId');
        articlesApi.loadArticles(page, authorId);

        const authorFilter = document.querySelector('#idSelect');
        for (let i = 0; i < authorFilter.options.length; i++) {
            if (authorFilter.options[i].value === authorId) {
                authorFilter.selectedIndex = i;
                break;
            }
        }
        articlesApi.checkResetButtonState(authorFilter)
        articlesApi.addAllEventListeners(authorFilter);
    },

    checkResetButtonState: function(authorFilter) {
        const resetFilterButton = document.querySelector('#resetFilter');
        const selectedAuthorId = authorFilter.value;
        if (selectedAuthorId === "") {
            resetFilterButton.classList.add('d-none');
        } else {
            resetFilterButton.classList.remove('d-none');
        }
    },

    addAllEventListeners: function(authorFilter) {
        const resetFilterButton = document.querySelector('#resetFilter');
        resetFilterButton.addEventListener('click', () => {
            authorFilter.selectedIndex = 0;
            resetFilterButton.classList.add('d-none');
            articlesApi.loadArticles(null, null);
        });

        authorFilter.onchange = () => {
            const selectedAuthorId = authorFilter.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('authorId', selectedAuthorId);
            history.pushState(null, null, `?page=1&authorId=${selectedAuthorId}`);
            articlesApi.loadArticles(1, selectedAuthorId);
            if (selectedAuthorId === "") {
                resetFilterButton.classList.add('d-none');
            } else {
                resetFilterButton.classList.remove('d-none');
            }
        };
        if (authorFilter.value === "") {
            resetFilterButton.classList.add('d-none')
        }
    },

    formatDateToDMY(date) {
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
    
        return `${day}/${month}/${year}`;
    },

    renderArticles: function(data) {
        let articlesHTML = '';

        data.items.forEach(article => {
            const publishedDate = new Date(article.publishedAt);
            const formattedPublishedDate = articlesApi.formatDateToDMY(publishedDate);
            const articleLink = `article/${article.id}/${article.slug}`;

            articlesHTML += `
            <div class="col-lg-6">
                <div class="card mb-3 fade-in">
                    <a href="${articleLink}" class="text-reset text-decoration-none">
                        <div class="row g-0">
                            <div class="col-md-4 rounded-top overflow-hidden position-relative">
                                <img src="${article.picture}" class="object-fit-cover w-100 md-position-absolute md-top-50 md-start-50 md-translate-middle" alt="Illustration ${article.title}" style="height: 223px;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">${article.title}</h5>
                                    <p class="card-text ellipsis-4">${article.content}</p>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between small">
                                <div class="d-flex">
                                    <i class="bi bi-person-circle"></i>
                                    <p class="card-text my-auto mx-2">
                                    ${article.user ? article.user.pseudo : 'Un coach'}
                                    </p>
                                </div>
                                <div class="small">
                                    Publié le ${formattedPublishedDate}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            `;
        });

        const articleListElement = document.getElementById('articleListContainer');
        articleListElement.innerHTML = articlesHTML;
        setTimeout(() => {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach(element => element.classList.add('active'));
        }, 0);
        articlesApi.renderMessage(data.message);
    },

    renderMessage: function(message, messageType) {
        const articleMessage = document.getElementById('articleMessage');

        if (message) {
            articlesApi.emptyContent();
            articleMessage.setAttribute('class','alert alert-' + messageType+' text-center fst-italic');
            articleMessage.textContent = message;
        } else {
            articleMessage.classList.add('d-none');
        }
    },

    emptyContent: function(){
        const articleListElement = document.getElementById('articleListContainer');
        const paginationElement = document.getElementById('paginationContainer');
        articleListElement.innerHTML = '';
        paginationElement.innerHTML = '';
    },

    renderPagination: function(data) {
        const totalPages = data.pages;
        const currentPage = data.page;

        const paginationElement = document.getElementById('paginationContainer');

        if (totalPages === 1) {
            paginationElement.innerHTML = '';
            return;
        }

        let paginationHTML = '';
        if (totalPages < 6) {
            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `
                    <li class="page-item${(currentPage === i ? ' active' : '')}" data-page="${i}" onclick="articlesApi.paginationButton(this)">
                        <span class="page-link">${i}</span>
                    </li>`;
            }
        } else {
            paginationHTML += `
                <li class="page-item${(currentPage === 1 ? ' active' : '')}" data-page="1" onclick="articlesApi.paginationButton(this)">
                    <span class="page-link">1</span>
                </li>`;
        
            if (currentPage > 2) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        
            for (let i = Math.max(currentPage - 1, 2); i <= Math.min(currentPage + 1, totalPages - 1); i++) {
                paginationHTML += `
                    <li class="page-item${(currentPage === i ? ' active' : '')}" data-page="${i}" onclick="articlesApi.paginationButton(this)">
                        <span class="page-link">${i}</span>
                    </li>`;
            }
        
            if (currentPage < totalPages - 1) {
                paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
            }
        
            paginationHTML += `
                <li class="page-item${(currentPage === totalPages ? ' active' : '')}" data-page="${totalPages}" onclick="articlesApi.paginationButton(this)">
                    <span class="page-link">${totalPages}</span>
                </li>`;
        }

        let prevDisabled = (currentPage < 2) ? ' disabled' : '';
        let nextDisabled = (currentPage == totalPages) ? ' disabled' : '';
        let prevPage = parseInt(currentPage) - 1;
        let nextPage = parseInt(currentPage) + 1;

        paginationContainer = `
            <nav aria-label="Page Navigation">
                <ul class="pagination">
                    <li class="page-item${prevDisabled}" data-page="${prevPage}" onclick="articlesApi.paginationButton(this)">
                        <span class="page-link">
                            <span aria-hidden="true">&lt;</span>
                        </span>
                    </li>
                    ${paginationHTML}
                    <li class="page-item${nextDisabled}" data-page="${nextPage}" onclick="articlesApi.paginationButton(this)">
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
        const authorFilter = document.querySelector('#idSelect');
        const selectedAuthorId = authorFilter.value;
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('page', page);
        if (selectedAuthorId) {
            currentUrl.searchParams.set('authorId', selectedAuthorId);
        } else {
            currentUrl.searchParams.delete('authorId');
        }
        history.pushState(null, null, currentUrl.href);
        articlesApi.loadArticles(page, selectedAuthorId);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    loadArticles: function(page, authorId = null) {
        if(!page) {
            page = 1;
            history.pushState(null, null, `?page=1`);
        }        

        const category = document.querySelector('#category').value.toLowerCase();
        const apiUrl = `api/article-${category}?page=${page}${authorId ? `&authorId=${authorId}` : ''}`;
        fetch(apiUrl)
        .then(async response => {
            const data = await response.json();
            if (response.status !== 200) {
                articlesApi.renderMessage(data.message, data.messageType);
            } else {
                if (data.total) {
                    articlesApi.renderArticles(data);
                    articlesApi.renderPagination(data);
                } else {
                    articlesApi.renderMessage('Aucun résultat trouvé', 'warning');
                }
            }
        })
        .catch(error => {
            console.error('Une erreur s\'est produite lors de la récupération des données :', error);
        });
    },
};

document.addEventListener('DOMContentLoaded', articlesApi.init);