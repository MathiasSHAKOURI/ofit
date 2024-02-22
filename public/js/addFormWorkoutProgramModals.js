const embedForm = {
    init: function() {
        console.log("init embed form JS");
        embedForm.addAllEventListeners();
    },

    addAllEventListeners: function(authorFilter) {
        const addButton = document.querySelectorAll('.add_item_link');
        addButton.forEach(element => {
            element.addEventListener("click", embedForm.addFormToCollection())
        });
    },

    addFormToCollection: function (e) {
        const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
        const item = document.createElement('li');

        item.innerHTML = collectionHolder
            .dataset
            .prototype
            .replace(
                /__name__/g,
                collectionHolder.dataset.index
            );

        collectionHolder.appendChild(item);
        collectionHolder.dataset.index++;

        embedForm.addTagFormDeleteLink(item);
        // embedForm.addChangeEventListenersToNewFields(item);
    },

    addTagFormDeleteLink: function (item) {
        const removeFormButton = document.createElement('button');
        removeFormButton.innerText = 'Delete this Exercice';
        removeFormButton.classList.add('btn', 'btn-outline-danger', 'bg-gradient');

        item.append(removeFormButton);

        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
        });
    }, 

    

    
};
document.addEventListener('DOMContentLoaded', embedForm.init);