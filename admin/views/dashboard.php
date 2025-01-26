<?php
$dir = dirname(__DIR__);
include_once 'includes/header.php';
?>
<main class="content">
  <div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1>
    <div class="row">
      <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
        <div class="card flex-fill w-100">
          <div class="card-header">

            <h5 class="card-title mb-0">Telco Distribution</h5>
          </div>
          <div class="card-body d-flex">
            <div class="align-self-center w-100">
              <div class="py-3">
                <div class="chart chart-xs">
                  <canvas id="chartjs-dashboard-pie"></canvas>
                </div>
              </div>

              <table class="table mb-0">
                <tbody>
                  <tr>
                    <td>Safaricom</td>
                    <td class="text-end">0</td>
                  </tr>
                  <tr>
                    <td>Airtel</td>
                    <td class="text-end">0</td>
                  </tr>
                  <tr>
                    <td>Telkom</td>
                    <td class="text-end">0</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>


<?php
include_once 'includes/footer.php';
?>