<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT 
logs.*,
COALESCE(admins.first_name, superadmins.first_name, nurses.first_name, midwife.first_name, staffs.first_name) as first_name,
COALESCE(admins.last_name, superadmins.last_name, nurses.last_name, midwife.last_name, staffs.last_name) as last_name,
users.role as role,
users.username as username
FROM logs
LEFT JOIN users ON users.id = logs.user_id
LEFT JOIN admins ON admins.user_id = logs.user_id
LEFT JOIN superadmins ON superadmins.user_id = logs.user_id
LEFT JOIN nurses ON nurses.user_id = logs.user_id
LEFT JOIN midwife ON midwife.user_id = logs.user_id
LEFT JOIN staffs ON staffs.user_id = logs.user_id
ORDER BY logs.id DESC;
";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">




<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="addForm">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                    <div id="first_name_error" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                    <div id="last_name_error" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                    <div id="birthdate_error" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    <div id="address_error" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div id="username_error" class="error"></div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                    <div id="password_error" class="error"></div>
                </div>
            </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModalButton">Close</button>
                <button type="submit" class="btn btn-primary" id="addButton">Save</button>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-12">
            <div class="card-body table-responsive p-0" style="z-index: -99999">
                <table id="tablebod" class="table table-head-fixed text-nowrap table-striped" >
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Type</th>
                            <th>Role</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td class="align-middle"><?php echo $row['id']; ?></td>
                                <td class="align-middle"><?php echo $row['first_name']; ?><?php echo $row['last_name']; ?></td>
                                <td class="align-middle"><?php echo $row['username']; ?></td>
                                <td class="align-middle"><?php echo $row['type']; ?></td>
                                <td class="align-middle"><?php echo $row['role']; ?></td>
                                <td class="align-middle"><?php echo $row['date']; ?></td>
                                <td class="align-middle"><?php echo $row['time']; ?></td>
                             
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle">No Data Found</td>
                                <td class="align-middle"></td>
                                <td class="align-middle"><td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                                <td class="align-middle"></td>
                            
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal edit -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Staff</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="editForm">
                    <input type="hidden" id="editdataId" name="primary_id">
                    <div class="form-group">
                        <label for="editFirstName">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" name="first_name" required>
                        <div id="editFirstName_error" class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="editLastName">Last Name</label>
                        <input type="text" class="form-control" id="editLastName" name="last_name" required>
                        <div id="editLastName_error" class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="editBirthdate">Birthdate</label>
                        <input type="date" class="form-control" id="editBirthdate" name="birthdate" required>
                        <div id="editBirthdate_error" class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <textarea class="form-control" id="editAddress" name="address" rows="3" required></textarea>
                        <div id="editAddress_error" class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="ediuser">Username</label>
                        <input type="text" class="form-control" id="ediuser" name="username" required>
                        <div id="ediuser_error" class="error"></div>
                    </div>
                    <div class="form-group">
                        <label for="editPassword">Password</label>
                        <input type="text" class="form-control" id="editPassword" name="password" required>
                        <div id="editPassword_error" class="error"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateButton">Update</button>
            </div>
        </div>
    </div>
</div>

    <!-- modal edit -->
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tablebod').DataTable();
    });
</script>
