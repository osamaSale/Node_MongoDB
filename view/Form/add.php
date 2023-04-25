<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Employee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body add_epmployee">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="name_input" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email_input" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password_input" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" id="phone_input" name="phone" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Authorization</label>
                    <select id="authorization_input" name="authorization" class="form-control" required>
                        <option>Open</option>
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" id="image_fileImage" name="fileImage" class="form-control">
                    <span id="user_uploaded_image"></span>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
               <!--  <input type="submit" class="btn btn-success" value="Add" onclick="addEmployee()"> -->
                <button type="submit" id="btnFetch" class="spinner-button btn btn-primary mb-2"  onclick="addEmployee()">Add</button>
            </div>
        </div>
    </div>
</div>