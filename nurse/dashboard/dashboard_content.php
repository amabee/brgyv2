
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
$tables = ['fp_information', 'immunization'];

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
    

    
<!--  -->
        

                       
<!--  -->
<div class="row">


        <div class="col-sm-6">
<div class="row">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
               <?php
               $sql = "SELECT COUNT(*) AS totalConsultations
FROM fp_information";

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

                <p>Total Family Planning</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-gray">
              <div class="inner">
              <?php
               $sql = "SELECT COUNT(*) AS totalConsultations FROM immunization ";

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
                <p>Total Immunization </p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

        </div>
        <!--  -->


        <div class="row">
          
            <div class="col-md-10">
                <h1>Checkup Category</h1>
                <canvas id="kindOfCheckups" width="300" height="250"></canvas>
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
    <div class="col-sm-6 bg-gradient-blue" style="text-align: left; padding:20px;border-radius:10px;">
    
    <div style="max-width: 600px; margin: 0 auto; background-color: #f8f8f8; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center; color: #333;">Announcements</h2>

    <?php
    $sql = "SELECT * FROM announcements ";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }

    while ($row = $result->fetch_assoc()) {
        echo '<div style="border: 1px solid #ddd; margin-bottom: 20px; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
            <h3 style="color: #333;">' . htmlspecialchars($row['title']) . '</h3>
            <p style="color: #666;">' . htmlspecialchars($row['description']) . '</p>
            <p style="color: #666;">Date: ' . htmlspecialchars($row['date']) . '</p>
            <p style="color: #666;">Time: ' . htmlspecialchars($row['time']) . '</p>
        </div>';
    }
    ?>

    <hr style="border-color: #ddd;">
</div>



   
      </div>
      <!-- Include this script in your HTML file -->
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
