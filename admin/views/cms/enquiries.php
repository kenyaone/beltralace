<?php
$dir = dirname(__DIR__);
include_once $dir . '/includes/header.php';
?>
<input type="hidden" name="route_view" value="<?php echo DIRADMIN . 'enquiries'; ?>">
<main class="content">
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="h3">Enquiries</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped" id="enquiries-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Language / Subject</th>
                            <th>Received</th>
                            <th class="col-1"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- View Enquiry Modal -->
    <div class="modal fade" id="view-enquiry-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enquiry Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="enquiry-modal-body">
                    <div class="text-center py-4"><span class="spinner-border text-primary" role="status"></span></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Enquiry Modal -->
    <div class="modal fade" id="delete-enquiry-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="delete-enquiry-form" method="post" action="<?php echo API; ?>">
                <input type="hidden" name="id">
                <input type="hidden" name="object" value="Enquiry">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="user_token" value="<?php echo encrypt_data($user->id); ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <p class="mb-0">Are you sure you want to permanently delete this enquiry?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
$(document).ready(function () {

    $('#enquiries-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [],
        ajax: {
            url: '<?php echo API; ?>',
            data: function (d) {
                d.object = 'Enquiry';
                d.action = 'data_table';
            },
            type: 'GET'
        },
        columnDefs: [{
            targets: [4],
            orderable: false
        }],
        language: {
            searchPlaceholder: 'Search...',
            sEmptyTable: 'No enquiries found'
        }
    });

    // View enquiry
    $(document).on('click', '.view-enquiry-btn', function () {
        var id = $(this).data('id');
        $('#enquiry-modal-body').html('<div class="text-center py-4"><span class="spinner-border text-primary" role="status"></span></div>');
        $('#view-enquiry-modal').modal('show');

        $.ajax({
            url: '<?php echo API; ?>',
            method: 'GET',
            data: { object: 'Enquiry', action: 'get_details', id: id },
            dataType: 'json',
            success: function (e) {
                if (!e) {
                    $('#enquiry-modal-body').html('<p class="text-danger">Could not load enquiry.</p>');
                    return;
                }

                var fullName = [e.first_name, e.middle_name, e.last_name].filter(Boolean).join(' ') || e.name || '—';

                var html = '<div class="row g-3">';

                // Personal details
                html += '<div class="col-12"><h6 class="text-muted text-uppercase small mb-2 border-bottom pb-1">Contact</h6></div>';
                html += field('Name', fullName);
                html += field('Email', e.email ? '<a href="mailto:' + esc(e.email) + '">' + esc(e.email) + '</a>' : '—', true);
                if (e.phone) html += field('Phone', esc(e.phone));
                if (e.nationality)    html += field('Nationality', esc(e.nationality));
                if (e.native_language) html += field('Native Language', esc(e.native_language));
                if (e.address || e.town || e.country) {
                    var addr = [e.address, e.town, e.country].filter(Boolean).map(esc).join(', ');
                    html += field('Address', addr, true);
                }

                // Enquiry details
                html += '<div class="col-12 mt-2"><h6 class="text-muted text-uppercase small mb-2 border-bottom pb-1">Enquiry</h6></div>';
                if (e.language) html += field('Language of Interest', esc(e.language));
                if (e.subject)  html += field('Subject', esc(e.subject), true);
                if (e.message)  html += field('Message', '<div class="p-2 bg-light rounded">' + nl2br(esc(e.message)) + '</div>', true);

                html += field('Received', esc(e.created_at || '—'));

                // Files
                if (e.files && e.files.length > 0) {
                    html += '<div class="col-12 mt-2"><h6 class="text-muted text-uppercase small mb-2 border-bottom pb-1">Attached Files</h6></div>';
                    html += '<div class="col-12"><ul class="list-unstyled mb-0">';
                    $.each(e.files, function (i, f) {
                        var url = '<?php echo UPLOADS_PATH; ?>/enquiries/' + f.file_name;
                        html += '<li class="mb-1"><a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download me-1"></i>' + esc(f.file_name) + '</a></li>';
                    });
                    html += '</ul></div>';
                }

                html += '</div>';
                $('#enquiry-modal-body').html(html);
            },
            error: function () {
                $('#enquiry-modal-body').html('<p class="text-danger">Failed to load enquiry details.</p>');
            }
        });
    });

    // Delete enquiry
    $(document).on('click', '.delete-enquiry-btn', function () {
        var id = $(this).data('id');
        $('#delete-enquiry-form').find('[name="id"]').val(id);
        $('#delete-enquiry-modal').modal('show');
    });

    $(document).on('submit', '#delete-enquiry-form', function (e) {
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(form[0]);
        $.ajax({
            beforeSend: function () { $('#overlay').removeClass('d-none'); },
            complete:   function () { $('#overlay').addClass('d-none'); },
            url: $(form).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function (response) {
                toastr.success(response.message);
                $('#enquiries-table').DataTable().ajax.reload(null, false);
                $('#delete-enquiry-modal').modal('hide');
            },
            error: function (data) {
                toastr.error(data.responseJSON.message);
                $('#delete-enquiry-modal').modal('hide');
            }
        });
    });

    // Helpers
    function esc(str) {
        return $('<span>').text(str).html();
    }
    function nl2br(str) {
        return str.replace(/\n/g, '<br>');
    }
    function field(label, value, fullWidth) {
        var col = fullWidth ? 'col-12' : 'col-md-6';
        return '<div class="' + col + '"><small class="text-muted d-block">' + label + '</small><span>' + value + '</span></div>';
    }
});
</script>

<?php
include_once $dir . '/includes/footer.php';
?>
