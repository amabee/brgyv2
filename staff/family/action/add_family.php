<?php
// Include your database configuration file
include_once('../../../config.php');
session_start();

// Sanitize and get data from the POST request
$patient_id = htmlspecialchars($_POST['patient_id']);
$nurse_id = htmlspecialchars($_POST['nurse_id']);
$method = 1;
$serial = '123';
$date = date('Y-m-d');
$doctor_id = $_SESSION['user_id'];

// Initialize variables for checkboxes
$severe_headaches = htmlspecialchars($_POST['severe_headaches']);
$history_stroke_heart_attack_hypertension = htmlspecialchars($_POST['history_stroke_heart_attack_hypertension']);
$hematoma_bruising_gum_bleeding = htmlspecialchars($_POST['hematoma_bruising_gum_bleeding']);
$breast_cancer_breast_mass = htmlspecialchars($_POST['breast_cancer_breast_mass']);
$severe_chest_pain = htmlspecialchars($_POST['severe_chest_pain']);
$cough_more_than_14_days = htmlspecialchars($_POST['cough_more_than_14_days']);
$vaginal_bleeding = htmlspecialchars($_POST['vaginal_bleeding']);
$vaginal_discharge = htmlspecialchars($_POST['vaginal_discharge']);
$phenobarbital_rifampicin = htmlspecialchars($_POST['phenobarbital_rifampicin']);
$smoker = htmlspecialchars($_POST['smoker']);
$with_disability = htmlspecialchars($_POST['with_disability']);

$jaundice = htmlspecialchars($_POST['jaundice']);
// Get data from input fields
$no_of_children = htmlspecialchars($_POST['no_of_children']);
$income = htmlspecialchars($_POST['income']);
$plan_to_have_more_children = htmlspecialchars($_POST['plan_to_have_more_children']);
$client_type = htmlspecialchars($_POST['client_type']);
$reason_for_fp = htmlspecialchars($_POST['reason_for_fp']);

// Get data for obstetrical history
$no_of_pregnancies = htmlspecialchars($_POST['no_of_pregnancies']);
$date_of_last_delivery = htmlspecialchars($_POST['date_of_last_delivery']);
$last_period = htmlspecialchars($_POST['last_period']);
$type_of_last_delivery = htmlspecialchars($_POST['type_of_last_delivery']);
$mens_type = htmlspecialchars($_POST['mens_type']);

// Get data for risk for sexuality
$abnormal_discharge = htmlspecialchars($_POST['abnormal_discharge']);
$genital_sores_ulcers = htmlspecialchars($_POST['genital_sores_ulcers']);
$genital_pain_burning_sensation = htmlspecialchars($_POST['genital_pain_burning_sensation']);
$treatment_for_sti = htmlspecialchars($_POST['treatment_for_sti']);
$hiv_aids_pid = htmlspecialchars($_POST['hiv_aids_pid']);

// Get data for risk for violence against women
$unpleasant_relationship = htmlspecialchars($_POST['unpleasant_relationship']);
$partner_does_not_approve = htmlspecialchars($_POST['partner_does_not_approve']);
$domestic_violence = htmlspecialchars($_POST['domestic_violence']);

// Get data for physical examination
$weight = htmlspecialchars($_POST['weight']);
$bp = htmlspecialchars($_POST['bp']);
$height = htmlspecialchars($_POST['height']);
$pulse = htmlspecialchars($_POST['pulse']);
$skin = htmlspecialchars($_POST['skin']);
$extremities = htmlspecialchars($_POST['extremities']);
$conjunctiva = htmlspecialchars($_POST['conjunctiva']);
$neck = htmlspecialchars($_POST['neck']);
$breast = htmlspecialchars($_POST['breast']);
$abdomen = htmlspecialchars($_POST['abdomen']);

$sql_patient_id = "SELECT id FROM patients WHERE serial_no = ?";
$stmt_patient_id = $conn->prepare($sql_patient_id);
$stmt_patient_id->bind_param("s", $patient_id);

if ($stmt_patient_id->execute()) {
    $stmt_patient_id->bind_result($patient_id);
    if ($stmt_patient_id->fetch()) {
        // Now you have the patient_id
        $stmt_patient_id->close();

        // Prepare and execute the SQL statement to insert into fp_information
        $sql1 = "INSERT INTO fp_information (patient_id, nurse_id, method, serial, checkup_date, doctor_id, no_of_children, income, plan_to_have_more_children, client_type, reason_for_fp)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("sssssssssss", $patient_id, $nurse_id, $method, $serial, $date, $doctor_id, $no_of_children, $income, $plan_to_have_more_children, $client_type, $reason_for_fp);

        // Execute the SQL statement to insert into fp_information
        if ($stmt1->execute()) {
            $last_inserted_id = $stmt1->insert_id; // Get the last inserted ID

            $sql7 = "INSERT INTO fp_consultation (fp_information_id,patient_id,nurse_id,checkup_date)
    VALUES (?,?,?,?)";
            $stmt7 = $conn->prepare($sql7);
            $stmt7->bind_param("dsss", $last_inserted_id, $patient_id, $nurse_id, $date);
            $stmt7->execute();

            // Prepare and execute the SQL statement to insert into fp_medical_history with the foreign key
            $sql2 = "INSERT INTO fp_medical_history (fp_information_id, patient_id, severe_headaches, history_stroke_heart_attack_hypertension, hematoma_bruising_gum_bleeding, breast_cancer_breast_mass, severe_chest_pain, cough_more_than_14_days, vaginal_bleeding, vaginal_discharge, phenobarbital_rifampicin, smoker, with_disability,jaundice)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("dsssssssssssss", $last_inserted_id, $patient_id, $severe_headaches, $history_stroke_heart_attack_hypertension, $hematoma_bruising_gum_bleeding, $breast_cancer_breast_mass, $severe_chest_pain, $cough_more_than_14_days, $vaginal_bleeding, $vaginal_discharge, $phenobarbital_rifampicin, $smoker, $with_disability, $jaundice);

            // Execute the SQL statement to insert into fp_medical_history
            if ($stmt2->execute()) {
                // Prepare and execute the SQL statement to insert into fp_obstetrical_history
                $sql3 = "INSERT INTO fp_obstetrical_history (fp_information_id, no_of_pregnancies, date_of_last_delivery, last_period, type_of_last_delivery, mens_type)
        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param("dsssss", $last_inserted_id, $no_of_pregnancies, $date_of_last_delivery, $last_period, $type_of_last_delivery, $mens_type);

                // Execute the SQL statement to insert into fp_obstetrical_history
                if ($stmt3->execute()) {
                    // Prepare and execute the SQL statement to insert into fp_risk_for_sexuality
                    $sql4 = "INSERT INTO fp_risk_for_sexuality (fp_information_id, abnormal_discharge, genital_sores_ulcers, genital_pain_burning_sensation, treatment_for_sti, hiv_aids_pid)
            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt4 = $conn->prepare($sql4);
                    $stmt4->bind_param("dsssss", $last_inserted_id, $abnormal_discharge, $genital_sores_ulcers, $genital_pain_burning_sensation, $treatment_for_sti, $hiv_aids_pid);

                    // Execute the SQL statement to insert into fp_risk_for_sexuality
                    if ($stmt4->execute()) {
                        // Prepare and execute the SQL statement to insert into fp_risk_for_violence_against_women
                        $sql5 = "INSERT INTO fp_risk_for_violence_against_women (fp_information_id, unpleasant_relationship, partner_does_not_approve, domestic_violence)
                VALUES (?, ?, ?, ?)";
                        $stmt5 = $conn->prepare($sql5);
                        $stmt5->bind_param("dsss", $last_inserted_id, $unpleasant_relationship, $partner_does_not_approve, $domestic_violence);

                        // Execute the SQL statement to insert into fp_risk_for_violence_against_women
                        if ($stmt5->execute()) {
                            // Prepare and execute the SQL statement to insert into fp_physical_examination
                            $sql6 = "INSERT INTO fp_physical_examination (fp_information_id, weight, bp, height, pulse, skin, extremities, conjunctiva, neck, breast, abdomen)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmt6 = $conn->prepare($sql6);
                            $stmt6->bind_param("dssssssssss", $last_inserted_id, $weight, $bp, $height, $pulse, $skin, $extremities, $conjunctiva, $neck, $breast, $abdomen);

                            // Execute the SQL statement to insert into fp_physical_examination
                            if ($stmt6->execute()) {
                                // Successful insertion
                                echo 'Success';
                            } else {
                                // Error handling for the sixth insert
                                echo 'Error in fp_physical_examination: ' . $conn->error;
                            }
                        } else {
                            // Error handling for the fifth insert
                            echo 'Error in fp_risk_for_violence_against_women: ' . $conn->error;
                        }
                    } else {
                        // Error handling for the fourth insert
                        echo 'Error in fp_risk_for_sexuality: ' . $conn->error;
                    }
                } else {
                    // Error handling for the third insert
                    echo 'Error in fp_obstetrical_history: ' . $conn->error;
                }
            } else {
                // Error handling for the second insert
                echo 'Error in fp_medical_history: ' . $conn->error;
            }
        } else {
            // Error handling for the first insert
            echo 'Error in fp_information: ' . $conn->error;
        }
    } else {
        // Patient with the provided serial_no not found
        echo 'Error: Patient not found';
    }
} else {
    // Error executing the query
    echo 'Error: ' . $conn->error;
}
// Close the database connections
$stmt1->close();
$stmt2->close();
$stmt3->close();
$stmt4->close();
$stmt5->close();
$stmt6->close();
$conn->close();
?>