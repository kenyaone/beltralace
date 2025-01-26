<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';
?>
<input type="hidden" name="route_view" value="<?php echo DIRADMIN . $page; ?>">
<input type="hidden" name="route_action" value="<?php echo $action; ?>">
<input type="hidden" name="route_value" value="<?php echo $value; ?>">
<main class="content">
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3">Pages</h1>
            <div class="ms-auto">
                <a href="<?php echo DIRADMIN . 'pages/new'; ?>" class="btn btn-outline-dark task-form-btn">New Page <i class="fas fa-fw fa-plus"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-md-12 datatables-buttons m-b-20 text-right">
                    </div>
                </div>
                <table class="table table-striped" data-status="" id="pages-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Created</th>
                            <th>Last Modified</th>
                            <th class="col-1"></th>
                        </tr>
                    </thead>
                </table>
                <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="delete-page-form" method="post" action="<?php echo API; ?>">
                            <input type="hidden" name="id">
                            <input type="hidden" name="object" value="Page">
                            <input type="hidden" name="action" value="delete" />
                            <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
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
                                    <button type="submit" class="btn btn-danger">Proceed</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="publish-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form id="publish-page-form" method="post" action="<?php echo API; ?>">
                            <input type="hidden" name="id">
                            <input type="hidden" name="object" value="Page">
                            <input type="hidden" name="action" value="publish" />
                            <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirm action</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body m-3">
                                    <p class="mb-0">Are you sure you want to proceed with this action?</p>
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
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#pages-table').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            "order": [],
            "ajax": {
                url: "<?php echo API; ?>",
                data: function(d) {
                    d.object = 'Page';
                    d.action = 'data_table';
                },
                type: "GET"
            },
            "columnDefs": [{
                    "targets": [4],
                    "orderable": false,
                },

            ],
            language: {
                searchPlaceholder: "Search...",
                sEmptyTable: "There is no data in the table yet"
            }
        });

        $(document).on('click', '.delete-page-btn', function() {
            var id = $(this).attr('data-id');
            $('#delete-page-form').find("[name='id']").val(id);
            $('#delete-modal').modal('toggle');
        });

        $(document).on('submit', '#delete-page-form', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
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
                    $('#pages-table').DataTable().ajax.reload(null, false);
                    $('#delete-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#delete-modal').modal('toggle');
                }
            });
        });

        $(document).on('click', '.publish-page-btn', function() {
            var id = $(this).attr('data-id');
            $('#publish-page-form').find("[name='id']").val(id);
            $('#publish-page-form').find("[name='action']").val('publish');
            $('#publish-modal').modal('toggle');
        });

        $(document).on('click', '.unpublish-page-btn', function() {
            var id = $(this).attr('data-id');
            $('#publish-page-form').find("[name='id']").val(id);
            $('#publish-page-form').find("[name='action']").val('unpublish');
            $('#publish-modal').modal('toggle');
        });

        $(document).on('submit', '#publish-page-form', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
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
                    $('#pages-table').DataTable().ajax.reload(null, false);
                    $('#publish-modal').modal('toggle');

                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    $('#publish-modal').modal('toggle');
                }
            });
        });
    });


</script>

<?php
include_once $dir . '/includes/footer.php';
?>