<script src="./js/modal.js"></script>
<div class="modal" id="Modal">
    <div class="mib" onclick="hideModal()"></div>
    <div class="window">
        <div class="modal-header">
            <span class="title" id="ModalTitle"></span>
            <div class="close" onclick="hideModal()">
                <div class="icon"></div>
            </div>
        </div>
        <form id="ModalForm" class="form" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input name="id" id="objId" class="hidden"/>

            @if(false)
            <input name="type" id="reqType" class="hidden"/>
            
            @endif

            <div id="FormContent" class="form-content">    
            </div>
            <div id="Buttons" class="buttons">
                <button class="button save" type="submit" action="test">Save</button>
            </div>
        </form>
    </div>
</div>