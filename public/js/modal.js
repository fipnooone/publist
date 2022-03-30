async function request(url) {
    let response = await fetch(url);
    let data = await response.json();
    return data;
}

let authorsPromise = request('/api/authors');

function setFieldContent(parent, type, name, text, value) {
    function createParentDiv() {
        let newDiv = document.createElement('div');
        newDiv.classList.add("form-input-block");
        parent.appendChild(newDiv);

        let newTitle = document.createElement('span');
        newDiv.appendChild(newTitle);
        newTitle.classList.add("form-input-title");
        newTitle.innerText = text;
        return newDiv;
    }

    function createInput(type = 'text') {
        let newInput = document.createElement('input');
        newInput.classList.add("f-i");
        if (value)
            newInput.value = value;
        newInput.name = name;
        newInput.type = type;
        createParentDiv().appendChild(newInput);
        return newInput;
    }

    switch (type) {
        case 'text':
            createInput();
            return;
        case 'select':
            let newSelect = document.createElement('select');
            newSelect.classList.add("f-i");
            newSelect.name = name;

            authorsPromise.then(authors => {
                authors.forEach(author => {
                    let newOption = new Option(author.name, author.id);
                    newSelect.appendChild(newOption);
                });
            });

            createParentDiv().appendChild(newSelect);
            return;
        case 'password':
            createInput('password').autocomplete = 'new-password';
            return;
        case 'email':
            createInput('email');
            return;
        default:
            return;
    }
}

function showModal(type, action, data = {}) {
    let modalTitle = document.getElementById('ModalTitle');

    setActionUrl(type);

    if (!action) {
        modalTitle.innerText = 'Create new ' + (type ? 'author' : 'book');
        setRequestMethod('POST');
    } else {
        setRequestMethod('PATCH');
        modalTitle.innerText = `Edit ${data.name}`;
        let newButton = document.createElement('button');
        newButton.value = 'delete';
        newButton.classList.add('delete');
        newButton.classList.add('button');
        newButton.name = 'submit';
        newButton.innerText = 'Delete';
        newButton.id = 'buttonDelete';
        newButton.setAttribute('onclick', 'setRequestMethod("DELETE")');
        document.getElementById('Buttons').appendChild(newButton);
    }

    let formContent = document.getElementById('FormContent');
    data.fields.forEach(field => {
        setFieldContent(formContent, field.type, field.name, field.text, field.value);
    });

    document.getElementById('Modal').style.display = 'flex';
    //document.getElementById('reqType').value = type ? 1 : 0;
    if (action)
        document.getElementById('objId').value = data.id;
}

function hideModal() {
    document.getElementById('Modal').style.display = 'none';
    document.getElementById('FormContent').textContent = '';
    let buttonDelete = document.getElementById('buttonDelete');
    if (buttonDelete)
        buttonDelete.remove();
}

function setRequestMethod(method) {
    document.getElementsByName('_method')[0].value = method;
}

function setActionUrl(type) {
    document.getElementById('ModalForm').action = (type ? 'author' : 'book') + '/edit';
}
