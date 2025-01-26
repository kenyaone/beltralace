<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';

// $placeholders = MessagePlaceholder::getList();
?>
<input type="hidden" name="route_view" value="<?php echo DIRADMIN .$view; ?>">
<input type="hidden" name="route_action" value="<?php echo $action; ?>">
<input type="hidden" name="route_value" value="<?php echo $value; ?>">
<main class="content">
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3">Users</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo DIRADMIN; ?>">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="all-users-tab" data-bs-toggle="tab" data-bs-target="#all-users" role="tab" aria-controls="all-users" aria-selected="true">Users</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="new-user-tab" data-bs-toggle="tab" data-bs-target="#new-user" role="tab" aria-controls="new-user" aria-selected="false">New <i class="fa fa-plus"></i></a>
                    </li>
                    <li class="nav-item d-none" role="presentation">
                        <a class="nav-link" id="edit-user-tab" data-bs-toggle="tab" data-bs-target="#edit-user" role="tab" aria-controls="edit-user" aria-selected="false">Edit <i class="fa fa-edit"></i></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="all-users" role="tabpanel" aria-labelledby="all-users-tab">
                        <div class="row">
                            <div class="col-md-12 datatables-buttons m-b-20 text-right">
                            </div>
                        </div>
                        <table class="table table-striped" data-status="" id="users-table">
                            <thead>
                                <tr>
                                    <th class="col-1"></th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th class="col-1"></th>
                                </tr>
                            </thead>
                        </table>
                        <div class="modal fade" id="prompt-modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form id="prompt-form" method="post" action="<?php echo API; ?>">
                                    <input type="hidden" name="id">
                                    <input type="hidden" name="object" value="User">
                                    <input type="hidden" name="action" value="delete" />
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm action</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body m-3">
                                            <p class="mb-0">Do you really want to remove this item from the database?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Proceed</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="new-user" role="tabpanel" aria-labelledby="new-user-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="new-user-form" class="user-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="User">
                                    <input type="hidden" name="action" value="create">
                                    <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                                    <input type="hidden" name="send_email" value="1">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-6">
                                            <label for="first_name" class="col-form-label">First Name</label>
                                            <input type="text" name="first_name" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last_name" class="col-form-label">Last Name</label>
                                            <input type="text" name="last_name" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-4">
                                            <label for="email" class="col-form-label">Email</label>
                                            <input type="text" name="email" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone" class="col-form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="username" class="col-form-label">Username</label>
                                            <input type="text" name="username" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn btn-primary mx-2"> Clear</button>
                                    <button type="submit" class="btn btn-success"> Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="edit-user" role="tabpanel" aria-labelledby="edit-user-tab">
                        <form action="<?php echo API; ?>" method="POST" role="form" id="edit-user-form" class="user-form">
                            <div>
                                <div class="mb-3">
                                    <input type="hidden" name="object" value="User">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id">
                                    <div class="form-group row mb-3">
                                        <div class="col-md-6">
                                            <label for="first_name" class="col-form-label">First Name</label>
                                            <input type="text" name="first_name" id="first_name" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="last_name" class="col-form-label">Last Name</label>
                                            <input type="text" name="last_name" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <div class="col-md-4">
                                            <label for="email" class="col-form-label">Email</label>
                                            <input type="text" name="email" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="phone" class="col-form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control" autocomplete="off">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="username" class="col-form-label">Username</label>
                                            <input type="text" name="username" class="form-control" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary cancel-edit-user-btn mx-2"> Cancel</button>
                                    <button type="submit" class="btn btn-success"> Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> 

<script>
    $(document).ready(function() {
        if($("[name='route_action']").val().length){
            var action = $("[name='route_action']").val();
            switch (action) {
                case 'new':

                    $('a[aria-controls="all-users"]').removeClass('active');
                    $('#all-users').removeClass('active');
                    $('a[aria-controls="new-user"]').addClass('active');
                    $('#new-user').addClass('active').addClass('show');
                    $('a[aria-controls="new-user"]').closest('li').removeClass('d-none');

                    break;

                case 'edit':
                    var value = $("[name='route_value']").val();

                    if(value.length){
                        editUser(value);

                        $('a[aria-controls="all-users"]').removeClass('active');
                        $('#all-users').removeClass('active');
                        $('a[aria-controls="edit-user"]').addClass('active');
                        $('#edit-user').addClass('active').addClass('show');
                        $('a[aria-controls="edit-user"]').closest('li').removeClass('d-none');

                    }
                    break;
            
                default:
                    break;
            }
        }

        $('#users-table').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            "order": [],
            "ajax": {
                url: "<?php echo API; ?>",
                data: function(d) {
                    d.object = 'User';
                    d.action = 'data_table';
                },
                type: "GET"
            },
            "columnDefs": [{
                    "targets": [0, 6],
                    "orderable": false,
                },

            ],
            language: {
                searchPlaceholder: "Search...",
                sEmptyTable: "There is no data in the table yet"
            }
        });

        $("#new-user-form").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                },
                phone: {
                    required: true,
                },
                username: {
                    required: true,
                    minlength: 2
                },
            },
            messages: {
                first_name: {
                    required: "First name is required",
                    minlength: "First name should be at least 2 characters"
                },
                last_name: {
                    required: "Last name is required",
                    minlength: "Last name should be at least 2 characters"
                },
                email: {
                    required: "Email is required",
                },
                phone: {
                    required: "Phone is required",
                },
                username: {
                    required: "Last name is required",
                    minlength: "Username should be at least 2 characters"
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    beforeSend: function() {
                        $('#overlay').removeClass('d-none');
                    },
                    complete: function() {
                        $('#overlay').addClass('d-none');
                    },
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    success: function(response, textStatus, jqXHR) {
                        form.reset();
                        toastr.success(response.message);
                        $('#users-table').DataTable().ajax.reload(null, false);

                        if($("[name='route_action']").val().length){
                            window.location = $("[name='route_view']").val();
                        }
                    },
                    error: function(data) {

                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

        $(document).on('click', '.edit-user-btn', function(){
            var id = $(this).attr('data-id');

            editUser(id);

            $('a[aria-controls="all-users"]').removeClass('active');
            $('#all-users').removeClass('active');
            $('a[aria-controls="edit-user"]').addClass('active');
            $('#edit-user').addClass('active').addClass('show');
            $('a[aria-controls="edit-user"]').closest('li').removeClass('d-none');
        });

        $("#edit-user-form").validate({
            rules: {
                subject: {
                    required: true,
                    minlength: 2
                },
                message: {
                    required: true,
                    minlength: 10
                }
            },
            messages: {
                subject: {
                    required: "Subject is required",
                    minlength: "Subject should be at least 2 characters"
                },
                message: {
                    required: "Message is required",
                    minlength: "Message should be at least 10 characters"
                }
            },
            submitHandler: function(form) {
                var formData = new FormData(form);
                $.ajax({
                    beforeSend: function() {
                        $('#overlay').removeClass('d-none');
                    },
                    complete: function() {
                        $('#overlay').addClass('d-none');
                    },
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    success: function(response, textStatus, jqXHR) {
                        form.reset();
                        toastr.success(response.message);
                        $('#users-table').DataTable().ajax.reload(null, false);

                        if($("[name='route_action']").val().length){
                            window.location = $("[name='route_view']").val();
                        }

                        $('a[aria-controls="edit-user"]').removeClass('active');
                        $('#edit-user').removeClass('active');
                        $('a[aria-controls="all-users"]').addClass('active');
                        $('#all-users').addClass('active').addClass('show');
                        $('a[aria-controls="edit-user"]').closest('li').addClass('d-none');

                    },
                    error: function(data) {
                        toastr.error(data.responseJSON.message);
                    }
                });
            }
        });

        $(document).on('click', '.cancel-edit-user-btn', function(){
            var id = $(this).attr('data-id');

            $('a[aria-controls="edit-user"]').removeClass('active');
            $('#edit-user').removeClass('active');
            $('a[aria-controls="all-users"]').addClass('active');
            $('#all-users').addClass('active').addClass('show');
            $('a[aria-controls="edit-user"]').closest('li').addClass('d-none');
        });

        $(document).on('click', '.activate-user-btn', function(){
            var id = $(this).attr('data-id');
            $('#prompt-form').find("[name='id']").val(id);
            $('#prompt-form').find("[name='action']").val('activate_user');
            $('#prompt-form').find(".modal-body p").html("Deactivating this user account will prevent them from logging in. Do you wish to proceed?");
            $('#prompt-modal').modal('toggle');
        });

        $(document).on('click', '.deactivate-user-btn', function(){
            var id = $(this).attr('data-id');
            $('#prompt-form').find("[name='id']").val(id);
            $('#prompt-form').find("[name='action']").val('deactivate_user');
            $('#prompt-form').find(".modal-body p").html("Deactivating this user account will prevent them from logging in. Do you wish to proceed?");
            $('#prompt-modal').modal('toggle');
        });

        $(document).on('click', '.reset-password-btn', function(){
            var id = $(this).attr('data-id');
            $('#prompt-form').find("[name='id']").val(id);
            $('#prompt-form').find("[name='action']").val('reset_password');
            $('#prompt-form').find(".modal-body p").html("Resetting this user account's password will send their new credentials to their email address. Do you wish to proceed?");
            $('#prompt-modal').modal('toggle');
        });

        $(document).on('submit', '#prompt-form', function(e){
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            $('#prompt-modal').modal('toggle');
            $.ajax({
                beforeSend: function() {
                    $('#overlay').removeClass('d-none');
                },
                complete: function() {
                    $('#overlay').addClass('d-none');
                },
                url: $(form).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                dataType: 'json',
                contentType: false,
                success: function(response, textStatus, jqXHR) {
                    toastr.success(response.message);
                    $('#users-table').DataTable().ajax.reload(null, false);
                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                }
            });
        });

    });

    function editUser (id){
        $.ajax({
            type: 'GET',
            url: '<?php echo API;?>',
            data: {
                object: 'User',
                action: 'get_details',
                id: id
            },
            cache: false,
            dataType: 'JSON',
            success: function (response) {
                $('#edit-user-form').find('[name="id"]').val(response.id).end()
                .find('[name="first_name"]').val(response.first_name).end()
                .find('[name="last_name"]').val(response.last_name).end()
                .find('[name="email"]').val(response.email).end()
                .find('[name="phone"]').val(response.phone).end()
                .find('[name="username"]').val(response.username).end();
            }
        });
    }
</script>

<?php
include_once $dir . '/includes/footer.php';
?>