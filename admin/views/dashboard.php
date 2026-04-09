<?php
$dir = dirname(__DIR__);
include_once 'includes/header.php';
?>
<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>

    <!-- Stat Cards -->
    <div class="row mb-4">
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
              <h5 class="card-title text-muted mb-1">Total Enquiries</h5>
              <h2 class="mb-0" id="stat-enquiries">—</h2>
            </div>
            <div class="ms-3 text-primary">
              <i class="fas fa-envelope fa-2x opacity-50"></i>
            </div>
          </div>
          <div class="card-footer py-2">
            <a href="<?php echo DIRADMIN; ?>enquiries" class="text-muted small">View all enquiries &rarr;</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
              <h5 class="card-title text-muted mb-1">Published Pages</h5>
              <h2 class="mb-0" id="stat-pages">—</h2>
            </div>
            <div class="ms-3 text-success">
              <i class="fas fa-file-alt fa-2x opacity-50"></i>
            </div>
          </div>
          <div class="card-footer py-2">
            <a href="<?php echo DIRADMIN; ?>pages" class="text-muted small">Manage pages &rarr;</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
              <h5 class="card-title text-muted mb-1">Blog Articles</h5>
              <h2 class="mb-0" id="stat-blogs">—</h2>
            </div>
            <div class="ms-3 text-warning">
              <i class="fas fa-bullhorn fa-2x opacity-50"></i>
            </div>
          </div>
          <div class="card-footer py-2">
            <a href="<?php echo DIRADMIN; ?>blog-articles" class="text-muted small">Manage blog &rarr;</a>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="card">
          <div class="card-body d-flex align-items-center">
            <div class="flex-grow-1">
              <h5 class="card-title text-muted mb-1">Active Widgets</h5>
              <h2 class="mb-0" id="stat-widgets">—</h2>
            </div>
            <div class="ms-3 text-info">
              <i class="fas fa-th-large fa-2x opacity-50"></i>
            </div>
          </div>
          <div class="card-footer py-2">
            <a href="<?php echo DIRADMIN; ?>widgets" class="text-muted small">Manage widgets &rarr;</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Monthly Enquiries Chart -->
      <div class="col-12 col-xl-8 d-flex">
        <div class="card flex-fill">
          <div class="card-header">
            <h5 class="card-title mb-0">Enquiries — Last 6 Months</h5>
          </div>
          <div class="card-body">
            <div class="chart chart-sm">
              <canvas id="enquiries-chart" height="100"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Enquiries -->
      <div class="col-12 col-xl-4 d-flex">
        <div class="card flex-fill">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Recent Enquiries</h5>
            <a href="<?php echo DIRADMIN; ?>enquiries" class="btn btn-sm btn-outline-secondary">View All</a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-sm mb-0" id="recent-enquiries-table">
                <thead>
                  <tr>
                    <th class="ps-3">Name</th>
                    <th>Language</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody id="recent-enquiries-body">
                  <tr><td colspan="3" class="text-center text-muted py-3">Loading...</td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

<script src="<?php echo ASSETS_PATH; ?>/node_modules/chart.js/dist/chart.umd.js"></script>
<script>
$(document).ready(function () {
    $.ajax({
        url: '<?php echo API; ?>',
        method: 'GET',
        data: { object: 'Stats', action: 'get_dashboard' },
        dataType: 'json',
        success: function (data) {
            // Stat cards
            $('#stat-enquiries').text(data.total_enquiries ?? 0);
            $('#stat-pages').text(data.published_pages ?? 0);
            $('#stat-blogs').text(data.total_blog_articles ?? 0);
            $('#stat-widgets').text(data.published_widgets ?? 0);

            // Monthly chart
            var labels = [];
            var counts = [];
            if (data.monthly_enquiries && data.monthly_enquiries.length) {
                $.each(data.monthly_enquiries, function (i, row) {
                    labels.push(row.month);
                    counts.push(parseInt(row.count));
                });
            }

            var ctx = document.getElementById('enquiries-chart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Enquiries',
                        data: counts,
                        backgroundColor: 'rgba(59, 125, 221, 0.2)',
                        borderColor: 'rgba(59, 125, 221, 0.9)',
                        borderWidth: 2,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });

            // Recent enquiries
            var $tbody = $('#recent-enquiries-body');
            $tbody.empty();
            if (data.recent_enquiries && data.recent_enquiries.length) {
                $.each(data.recent_enquiries, function (i, row) {
                    var name = row.display_name || '—';
                    var lang = row.language || row.subject || '—';
                    if (lang.length > 14) lang = lang.substring(0, 14) + '…';
                    $tbody.append(
                        '<tr>' +
                        '<td class="ps-3">' + $('<span>').text(name).html() + '</td>' +
                        '<td>' + $('<span>').text(lang).html() + '</td>' +
                        '<td class="text-muted small">' + (row.created_at || '') + '</td>' +
                        '</tr>'
                    );
                });
            } else {
                $tbody.append('<tr><td colspan="3" class="text-center text-muted py-3">No enquiries yet</td></tr>');
            }
        },
        error: function () {
            $('#stat-enquiries, #stat-pages, #stat-blogs, #stat-widgets').text('—');
        }
    });
});
</script>

<?php
include_once 'includes/footer.php';
?>
