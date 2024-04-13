<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Patient Dashboard</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/patientHeader.php");

            session_start();

            $db = new SQLite3('C:\xampp\data\stage_3.db');

            $patientId = $_SESSION['patient_id'];

            $query = "SELECT COUNT(*) AS count
                      FROM POA_questionnaire pq
                      JOIN surgery s ON pq.surgery_id = s.surgery_id
                      WHERE s.patient_id = $patientId";

            $result = $db->querySingle($query);

            if ($result === false) {
                echo "Error executing query";
            } else {
                if ($result > 0) {
                    echo '<main>
                              <h1>Welcome <?php echo $username; ?></h1>

                              <div class="dashboardBoxes">
                                  <div class="pageLinks">
                                      <p class="headings">Your Appointments</p>
                                      <a href="">Past and Upcoming Appointments</a> 
                                  </div>
                                  <div class="pageLinks">
                                      <p class="headings"> Need To Complete </p>
                                      <ul>';
                    $questionnaireQuery = "SELECT pq.poa_form_id
                                           FROM POA_questionnaire pq
                                           JOIN surgery s ON pq.surgery_id = s.surgery_id
                                           WHERE s.patient_id = $patientId";

                    $questionnaireResults = $db->query($questionnaireQuery);

                    while ($row = $questionnaireResults->fetchArray(SQLITE3_ASSOC)) {
                        echo '<li><a href="../questionnaire/questionnaire.php?id=' . $row['poa_form_id'] . '">Pre-operative assessment</a></li>';
                    }

                    echo '</ul></div> 
                                  <div class="viewProfileButton">
                                      <br>
                                      <a href="patientProfile.php" class="viewProfile">View Your Profile</a>
                                  </div>
                              </div>
                          </main>';
                } else {
                    echo '<main>
                              <h1>Welcome <?php echo $username; ?></h1>

                              <div class="dashboardBoxes">
                                  <div class="pageLinks">
                                      <p class="headings">Your Appointments</p>
                                      <a href="">Past and Upcoming Appointments</a> 
                                  </div>
                                  <div class="viewProfileButton">
                                      <br>
                                      <a href="patientProfile.php" class="viewProfile">View Your Profile</a>
                                  </div>
                              </div>
                          </main>';
                }
            }
            $db->close();
        ?>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
