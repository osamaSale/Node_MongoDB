<div id="viewEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body view_employee">
               
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="name_input1" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email_input1" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password_input1" class="form-control" readonly admin>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" id="phone_input1" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Authorization</label>
                    <input type="text" id="authorization_input1" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Image</label><br/>
                    <span id="user_uploaded_image"></span>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Close">
            </div>
        </div>
    </div>
</div>