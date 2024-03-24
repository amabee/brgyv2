<?php
// Include your database configuration file
include_once('../../config.php');


$sql = "SELECT * FROM superadmins WHERE is_active = 0 AND is_deleted = 0 ORDER BY id DESC";


$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

?>

<div class="container-fluid">
<button type="button" id="openModalButton" class="btn btn-primary">
  Add Superadmin
</button>

<br><br>


<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Superadmin</h5>
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
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Birthdate</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td class="align-middle"><?php echo $row['id']; ?></td>
                                <td class="align-middle"><?php echo $row['first_name']; ?></td>
                                <td class="align-middle"><?php echo $row['last_name']; ?></td>
                                <td class="align-middle"><?php echo $row['birthdate']; ?></td>
                                <td class="align-middle"><?php echo $row['address']; ?></td>
                                <td class="align-middle">
                                <button type="button" class="btn btn-success editbtn" data-row-id="<?php echo $row['id']; ?>">
                    <i class="fas fa-edit"></i> Edit
                </button>
                                  <button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="align-middle">No Superadmin Found</td>
                                <td class="align-middle"></td>
                                <td class="align-middle"><td>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Admin</h5>
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

<script>
 $(document).ready(function () {

    document.getElementById('openModalButton').addEventListener('click', function() {
  $('#addModal').modal('show'); // Show the modal
});

    // will use
    <?php if ($result->num_rows > 0): ?>
        var table = $('#tablebod').DataTable({
            columnDefs: [
                { targets: 0, data: 'id' },
                { targets: 1, data: 'first_name' },
                { targets: 2, data: 'last_name' },
                { targets: 3, data: 'birthdate' },
                { targets: 4, data: 'address' },
                {
                    targets: 5,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        return editButton + ' ' + deleteButton;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
    <?php else: ?>
        // Initialize DataTable without the "Action" column when no rows are found
        var table = $('#tablebod').DataTable({
            columnDefs: [
                { targets: 0, data: 'id' },
                { targets: 1, data: 'first_name' },
                { targets: 2, data: 'last_name' },
                { targets: 3, data: 'birthdate' },
                { targets: 4, data: 'address' }
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
    <?php endif; ?>
    $('#addButton').click(function () {

        table.destroy(); // Destroy the existing DataTable
        table = $('#tablebod').DataTable({
            columnDefs: [
                { targets: 0, data: 'id' },
                { targets: 1, data: 'first_name' },
                { targets: 2, data: 'last_name' },
                { targets: 3, data: 'birthdate' },
                { targets: 4, data: 'address' },
                {
                    targets: 5,
                    searchable: false,
                    data: null,
                    render: function (data, type, row) {
                        var editButton = '<button type="button" class="btn btn-success editbtn" data-row-id="' + row.id + '"><i class="fas fa-edit"></i> Edit</button>';
                        var deleteButton = '<button type="button" class="btn btn-danger deletebtn" data-id="' + row.id + '"><i class="fas fa-trash"></i> Delete</button>';
                        return editButton + ' ' + deleteButton;
                    }
                } // Action column
            ],
            // Set the default ordering to 'id' column in descending order
            order: [[0, 'desc']]
        });
        // Get data from the form


        $('.error').text('');

    // Get data from the form
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var birthdate = $('#birthdate').val();
    var address = $('#address').val();
    var username = $('#username').val();
    var password = $('#password').val();
    // Validate input fields
    var isValid = true;

    if (first_name.trim() === '') {
        $('#first_name_error').text('Field is required');
        isValid = false;
    }

    if (last_name.trim() === '') {
        $('#last_name_error').text('Field is required');
        isValid = false;
    }

    if (birthdate.trim() === '') {
        $('#birthdate_error').text('Field is required');
        isValid = false;
    }

    if (address.trim() === '') {
        $('#address_error').text('Field is required');
        isValid = false;
    }
    if (birthdate.trim() === '') {
        $('#birthdate_error').text('Field is required');
        isValid = false;
    }

    if (address.trim() === '') {
        $('#address_error').text('Field is required');
        isValid = false;
    }
    if (username.trim() === '') {
        $('#username_error').text('Field is required');
        isValid = false;
    }

    if (password.trim() === '') {
        $('#password_error').text('Field is required');
        isValid = false;
    }

    if (isValid) {      

        // AJAX request to send data to the server
        $.ajax({
            url: 'action/add_superadmin.php',
            method: 'POST',
            data: {
                first_name: first_name,
                last_name: last_name,
                birthdate: birthdate,
                address: address,
                username: username,
                password: password
            },
            success: function (response) {
                // Handle the response
                if (response === 'Success') {
                    // Clear the form fields
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#birthdate').val('');
                    $('#address').val('');
                    $('#username').val('');
                    $('#password').val('');

                    updateData();
                    $('#addModal').modal('hide');

        // Remove the modal backdrop manually
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
            // Show a success SweetAlert
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Superadmin added successfully',
            });
            
                } else {
                        // Show an error SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error adding data: ' + response,
            });
                }
            },
            error: function (error) {
                // Handle errors
                Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error adding data: ' + error,
        });
            },
        
        });
     }
    });


    function updateData() {
        $.ajax({
            url: 'action/get_superadmin.php',
            method: 'GET',
            success: function (data) {
                // Assuming the server returns JSON data, parse it
                var get_data = JSON.parse(data);

                // Clear the DataTable and redraw with new data
                table.clear().rows.add(get_data).draw();
            },
            error: function (error) {
                // Handle errors
                console.error('Error retrieving data: ' + error);
            }
        });
    }

    // Delete button click event
$('#tablebod').on('click', '.deletebtn', function () {
    var deletedataId = $(this).data('id');
    
    // Confirm the deletion with a SweetAlert dialog
    Swal.fire({
        title: 'Confirm Delete',
        text: 'Are you sure you want to delete this data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'action/delete_superadmin.php',
                method: 'POST',
                data: { primary_id: deletedataId },
                success: function (response) {
                    if (response === 'Success') {
                      
                        updateData();
                        Swal.fire('Deleted', 'The Superadmin has been deleted.', 'success');
                    } else {
                        Swal.fire('Error', 'Error deleting data: ' + response, 'error');
                    }
                },
                error: function (error) {
                    Swal.fire('Error', 'Error deleting data: ' + error, 'error');
                }
            });
        }
    });
});



// Edit button click event
$('#tablebod').on('click', '.editbtn', function () {
    var editId = $(this).data('row-id');

    $.ajax({
        url: 'action/get_superadmin_by_id.php', // 
        method: 'POST',
        data: { primary_id: editId },
        success: function (data) {
          
            var editGetData = data; 


            $('#editModal #editdataId').val(editGetData.id);
            $('#editModal #editFirstName').val(editGetData.first_name);
            $('#editModal #editLastName').val(editGetData.last_name);
            $('#editModal #editBirthdate').val(editGetData.birthdate);
            $('#editModal #editAddress').val(editGetData.address);
            $('#editModal #ediuser').val(editGetData.username);
            $('#editModal #editPassword').val(editGetData.password);
           
            $('#editModal').modal('show');
        },
        error: function (error) {
            console.error('Error fetching  data: ' + error);
        },
    });
});

$('#updateButton').click(function () {
    event.preventDefault();
    $('.error').text('');

    var editId = $('#editdataId').val();
    var firstName = $('#editFirstName').val();
    var lastName = $('#editLastName').val();
    var birthdate = $('#editBirthdate').val();
    var address = $('#editAddress').val();
    var username = $('#ediuser').val();
    var password = $('#editPassword').val();

     // Validate input fields
     var isValid = true;

        if (firstName.trim() === '') {
            $('#editFirstName_error').text('Field is required');
            isValid = false;
        }

        if (lastName.trim() === '') {
            $('#editLastName_error').text('Field is required');
            isValid = false;
        }

        if (birthdate.trim() === '') {
            $('#editBirthdate_error').text('Field is required');
            isValid = false;
        }

        if (address.trim() === '') {
            $('#editAddress_error').text('Field is required');
            isValid = false;
        }

        if (username.trim() === '') {
            $('#ediuser_error').text('Field is required');
            isValid = false;
        }

        if (password.trim() === '') {
            $('#editPassword_error').text('Field is required');
            isValid = false;
        }

        // Only proceed with AJAX request if all fields are valid
        if (isValid) {
            

    $.ajax({
        url: 'action/update_superadmin.php',
        method: 'POST',
        data: {
            primary_id: editId,
            first_name: firstName,
            last_name: lastName,
            birthdate: birthdate,
            address: address,
            username: username,
            password: password
        },
        success: function (response) {
            // Handle the response
            if (response === 'Success') {
                updateData();
                $('#editModal').modal('hide');
                // Remove the modal backdrop manually
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                // Show a success Swal notification
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Superadmin updated successfully',
                });
            } else {
                // Show an error Swal notification
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating data: ' + response,
                });
            }
        },
        error: function (error) {
            // Show an error Swal notification for AJAX errors
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error updating data: ' + error,
            });
        }
    });
    }
});



});


</script>
<script>
    $(document).ready(function () {
        $('#username').on('change', function () {
        
            var username = $(this).val();
            console.log(username);
            $.ajax({
                type: 'POST',
                url: 'action/check_username.php',
                data: {username: username},
                success: function (response) {
                    console.log("AJAX success response:", response);

                    if (response === 'success') {
                        $('#username_error').html('Username already exists. Please choose a different one.');
                    } else {
                        $('#username_error').html('');
                    }
                },
                error: function (xhr, status, error) {
                    console.log("AJAX error:", status, error);
                }
            });
        });
    });
</script>
<script>
  function validatePassword2() {
    var password = document.getElementById('editPassword').value;

    // Define the regular expression for the password pattern
    var passwordPattern = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/;

    // Check if the password matches the pattern
    if (!passwordPattern.test(password)) {
      document.getElementById('editPassword_error').innerHTML = 'Password must be 8 characters long, include at least 1 uppercase letter, 1 special character, and 1 number.';
      return false;
    } else {
      document.getElementById('editPassword_error').innerHTML = '';
      return true;
    }
  }
  function validatePassword() {
    var password = document.getElementById('password').value;

    // Define the regular expression for the password pattern
    var passwordPattern = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/;

    // Check if the password matches the pattern
    if (!passwordPattern.test(password)) {
      document.getElementById('password_error').innerHTML = 'Password must be 8 characters long, include at least 1 uppercase letter, 1 special character, and 1 number.';
      return false;
    } else {
      document.getElementById('password_error').innerHTML = '';
      return true;
    }
  }
  
  // Attach the validatePassword function to the input change event
  document.getElementById('password').addEventListener('input', validatePassword);
  document.getElementById('editPassword').addEventListener('input', validatePassword2);
</script>

<script>
  // Set the timeout duration (in milliseconds)
  var inactivityTimeout = 360000; // 10 seconds

  // Track user activity
  var activityTimer;

  function resetTimer() {
    clearTimeout(activityTimer);
    activityTimer = setTimeout(logout, inactivityTimeout);
  }

  function logout() {
    // Redirect to logout PHP script
    window.location.href = '../action/logout.php';
  }

  // Add event listeners to reset the timer on user activity
  document.addEventListener('mousemove', resetTimer);
  document.addEventListener('keypress', resetTimer);

  // Initialize the timer on page load
  resetTimer();
</script>