document.addEventListener("DOMContentLoaded", function() {

    const addFormToCollection = (e) => {
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

    addTagFormDeleteLink(item);
    updateInputState(item);
    addChangeEventListenersToNewFields(item);
    };

    const addTagFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('button');
        removeFormButton.innerText = 'Delete this Exercice';
        removeFormButton.classList.add('btn', 'btn-outline-danger', 'bg-gradient');

        item.append(removeFormButton);

        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            // remove the li for the tag form
            item.remove();
        });
    }

    function addChangeEventListenersToNewFields(item) {
        addChangeEventListeners('.reps-input', updateInputState, item);
        addChangeEventListeners('.duration-input', updateInputState, item);
    }
    
    function addChangeEventListeners(selector, handler) {
        document
            .querySelectorAll(selector)
            .forEach(input => {
                input.addEventListener("change", function() {
                    handler(input.closest('li'));
                });
            });
    }
    
    function updateInputState(item) {
        const repsInput = item.querySelector('.reps-input');
        const durationInput = item.querySelector('.duration-input');

        if (repsInput && durationInput) {
            const repsValue = repsInput.value.trim();
            const durationValue = durationInput.value.trim();
    
            durationInput.disabled = repsValue !== "";
            repsInput.disabled = durationValue !== "";
        }
    }

    addChangeEventListeners('.reps-input', updateInputState);
    addChangeEventListeners('.duration-input', updateInputState);

    document
        .querySelectorAll('.add_item_link')
        .forEach(btn => {
            btn.addEventListener("click", addFormToCollection);
        });

        
        document
        .querySelectorAll('ul.workoutParameters li')
        .forEach((workoutParameters) => {
            addTagFormDeleteLink(workoutParameters);
            updateInputState(workoutParameters);
        });
    });