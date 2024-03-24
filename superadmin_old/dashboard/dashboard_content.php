
      <?php
      include_once('../../config.php');
      $currentDate = date('Y-m-d');
      $currentMonth = date('m');
      $currentYear = date('Y');

      
      
      // Query to count patients per day
      $sql = "SELECT checkup_date, COUNT(id) as patient_count FROM fp_information GROUP BY checkup_date";
      $result = $conn->query($sql);
      
      if ($result === false) {
          die("Query failed: " . $conn->error);
      }
      
      // Fetch data and prepare for the chart
      $chart_data = array();
      while ($row = $result->fetch_assoc()) {
          $chart_data[] = array(
              'date' => $row['checkup_date'],
              'count' => $row['patient_count']
          );
      }



// Create an array of table names
$tables = ['fp_information', 'immunization', 'prenatal', 'consultations'];

// Initialize an array to store the counts
$counts = array();

foreach ($tables as $table) {
    $sql = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    $row = $result->fetch_assoc();
    $counts[] = $row['count'];
}





      ?>
      
      
      <div class="container-fluid">
    

        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
               <?php
               $sql = "SELECT COUNT(*) AS totalConsultations FROM consultations WHERE checkup_date = '$currentDate'";

               $result = $conn->query($sql);
               
               if ($result === false) {
                   die("Query failed: " . $conn->error);
               }
               
               if ($result->num_rows > 0) {
                   $row = $result->fetch_assoc();
                   $totalConsultations = $row['totalConsultations'];
               
                   // Display the total consultations count within an <h3> element
                   echo "<h3>$totalConsultations</h3>";
               } else {
                   // If no consultations were found for today's date, display 0
                   echo "<h3>0</h3>";
               }
               
               // Close the database connection
            
               ?>

                <p>Today's Patient</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
               <?php
               $sql = "SELECT COUNT(*) AS totalConsultations FROM consultations WHERE YEAR(checkup_date) = '$currentYear' AND MONTH(checkup_date) = '$currentMonth'";

               $result = $conn->query($sql);
               
               if ($result === false) {
                   die("Query failed: " . $conn->error);
               }
               
               if ($result->num_rows > 0) {
                   $row = $result->fetch_assoc();
                   $totalConsultations = $row['totalConsultations'];
               
                   // Display the total consultations count within an <h3> element
                   echo "<h3>$totalConsultations</h3>";
               } else {
                   // If no consultations were found for the current month, display 0
                   echo "<h3>0</h3>";
               }
               
               // Close the database connection
          
               ?>

                <p>Monthly Patient</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              <?php
               $sql = "SELECT COUNT(*) AS totalConsultations FROM consultations";

               $result = $conn->query($sql);
               
               if ($result === false) {
                   die("Query failed: " . $conn->error);
               }
               
               if ($result->num_rows > 0) {
                   $row = $result->fetch_assoc();
                   $totalConsultations = $row['totalConsultations'];
               
                   // Display the total consultations count within an <h3> element
                   echo "<h3>$totalConsultations</h3>";
               } else {
                   // If no consultations were found for the current month, display 0
                   echo "<h3>0</h3>";
               }
               
               // Close the database connection
          
               ?>
                <p>Total Patient</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

        <div class="row">
            <div class="col-md-7">
                <h1>Patients Per Day</h1>
                <canvas id="patientChart" width="400" height="300"></canvas>
            </div>
            <div class="col-md-5">
                <h1>Checkup Category</h1>
                <canvas id="kindOfCheckups" width="300" height="200"></canvas>
            </div>
        </div>

    <script>
        var tableNames = <?php echo json_encode($tables); ?>;
        var data = <?php echo json_encode($counts); ?>;
        var ctx = document.getElementById('kindOfCheckups').getContext('2d');

        var chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: tableNames,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                    ],
                }],
            },
        });
    </script>

    <script>
        var data = <?php echo json_encode($chart_data); ?>;
        var dates = data.map(item => item.date);
        var counts = data.map(item => item.count);

        var ctx = document.getElementById('patientChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Patients per Day',
                    data: counts,
                    borderColor: 'blue',
                    fill: false,
                }],
            },
            options: {
                scales: {
                    x: [{
                        ticks: {
                            maxTicksLimit: 10,
                        },
                    }],
                },
            },
        });
    </script>
      </div>