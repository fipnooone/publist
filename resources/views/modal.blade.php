<script>
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

        function createInput(type='text') {
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

                @foreach ($authors as $author)
                    //var newOption = document.createElement('option');
                    var newOption = new Option("{{ $author->name }}", "{{ $author->id }}");
                    //newOption.value = {{ $author->id }};
                    //newOption.text = {{ $author->name }};
                    newSelect.appendChild(newOption);
                @endforeach

                //newInput.value = value;
                createParentDiv().appendChild(newSelect);
                return;
            case 'password':
                createInput('password').autocomplete='new-password';
                return;
            case 'email':
                createInput('email');
                return;
            default: return;
        }
    }

    function showModal(type, action, data={}) {
        let modalTitle = document.getElementById('ModalTitle');
        if (!type && !action) {
            modalTitle.innerText = 'Create new book';
        } else if (type && !action){
            modalTitle.innerText = 'Create new author';
        } else if (action) {
            modalTitle.innerText = `Edit ${data.name}`;
            let newButton = document.createElement('button');
            newButton.value = 'delete';
            newButton.classList.add('delete');
            newButton.classList.add('button');
            newButton.name = 'submit';
            newButton.innerText = 'Delete';
            newButton.id = 'buttonDelete';
            document.getElementById('Buttons').appendChild(newButton);
        }

        let formContent = document.getElementById('FormContent');
        data.fields.forEach(field => {
            setFieldContent(formContent, field.type, field.name, field.text, field.value);
        });

        document.getElementById('Modal').style.display = 'flex';
        document.getElementById('reqType').value = type ? 1 : 0;
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
</script>
<div class="modal" id="Modal">
    <div class="mib" onclick="hideModal()"></div>
    <div class="window">
        <div class="modal-header">
            <span class="title" id="ModalTitle"></span>
            <div class="close" onclick="hideModal()">
                <div class="icon"></div>
            </div>
        </div>
        <form class="form" action="{{ route('edit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input name="type" id="reqType" class="hidden"/>
            <input name="id" id="objId" class="hidden"/>
            <div id="FormContent" class="form-content">    
            </div>
            <div id="Buttons" class="buttons">
                <button class="button save" type="submit" name="submit" value="save" action="test">Save</button>
            </div>
        </form>
    </div>
</div>