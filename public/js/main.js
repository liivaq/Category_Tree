function toggleElementVisibility(className, keepUnhidden = false) {
    const element = document.querySelector(className);
    if (element) {
        if (keepUnhidden) {
            element.classList.remove('hidden');
            setTimeout(() => {
                element.classList.add('hidden');
            }, 3000);
        } else {
            element.classList.toggle('hidden');
        }
    }
}

function handleButtonClick(event) {
    const targetId = event.currentTarget.getAttribute('data-target');
    if (targetId) {
        toggleElementVisibility(`#section-${targetId}`);
    }
}

function attachEventListenerToElements(selector, eventType, handlerFunction) {
    const elements = document.querySelectorAll(selector);
    elements.forEach(element => {
        element.addEventListener(eventType, handlerFunction);
    });
}

document.addEventListener('DOMContentLoaded', function () {

    const duration = 2000;

    const successMessageContainer = document.getElementById('success-message');
    if (successMessageContainer) {
        // Hide the success message after the specified duration
        setTimeout(function() {
            toggleElementVisibility('#success-message');
        }, duration);
    }

    attachEventListenerToElements('.save-button', 'click', handleSaveButton);

    attachEventListenerToElements('.delete-button', 'click', handleDeleteButton);

    attachEventListenerToElements('#showCreate', 'click', function () {
        toggleElementVisibility('#create');
    });

    attachEventListenerToElements('.add-button', 'click', function (event) {
        const targetId = event.currentTarget.getAttribute('data-target');
        toggleElementVisibility(`#addForm-${targetId}`);
    });

    attachEventListenerToElements('.subsection-button', 'click', handleButtonClick);

    attachEventListenerToElements('.edit-button, .cancel-button', 'click', function (event) {
        const sectionId = this.getAttribute('data-target');
        toggleElementVisibility(`#viewmode-${sectionId}`);
        toggleElementVisibility(`#editmode-${sectionId}`);
    });


    function handleSaveButton(event) {
        const sectionId = event.currentTarget.getAttribute('data-section-id');
        event.preventDefault();

        const editTitle = document.querySelector(`#editTitle-${sectionId}`).value;
        const editDescription = document.querySelector(`#editDescription-${sectionId}`).value;

        const data = {
            title: editTitle,
            description: editDescription,
            id: sectionId
        };

        fetch('/section/edit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data),
        })
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                if (data.success) {
                    const viewmodeSection = document.querySelector(`#viewmode-${sectionId}`);
                    viewmodeSection.querySelector('.font-semibold').textContent = editTitle;
                    viewmodeSection.querySelector('.mb-4').textContent = editDescription;
                    toggleElementVisibility(`#viewmode-${sectionId}`);
                    toggleElementVisibility(`#editmode-${sectionId}`);
                } else {
                    const errorMessageElement = document.querySelector(`#database-error`);
                    errorMessageElement.textContent = 'Sorry, something went wrong! Try again later.';
                    toggleElementVisibility(`#database-error`, true);
                    console.error('Deletion failed:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function handleDeleteButton(event) {
        const sectionId = event.currentTarget.getAttribute('data-section-id');
        event.preventDefault();

        fetch(`/section/delete/${sectionId}`, {
            method: 'POST'
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const elementToRemove = document.querySelector(`#main-section-${sectionId}`);
                    if (elementToRemove) {
                        elementToRemove.remove();
                    }
                } else {
                    const errorMessageElement = document.querySelector(`#database-error`);
                    errorMessageElement.textContent = 'Sorry, something went wrong! Try again later.';
                    toggleElementVisibility(`#database-error`, true);
                    console.error('Deletion failed:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

});
