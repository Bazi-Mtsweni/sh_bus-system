<div id="alert" class="alert"> <!-- success or error -->
    <i id="alert-icon" class="fa-solid"></i>
    <p id="alert-message"></p>
</div>

<div id="delete-modal" class="modal" style="display: none;">
    <h3>Delete Application</h3>
    <p>This will permanently delete the application, the user will have to re-apply.<br><br> Do you wish to continue?</p>
    <div class="modal-actions">
        <button id="delete-btn" onclick="deleteApplication();" class="btn-red"><i class='fa-solid fa-trash-can'></i>Delete</button>
        <button class="btn-black" onclick="closeModal();">Cancel</button>
    </div>
</div>