<?php
    session_start(); // Start a session

    // Initialize variables
    $investment = $interest_rate = $years = '';
    $error_message = '';
    $investment_f = $yearly_rate_f = $future_value_f = '';
    $years_display = ''; // Variable to store the displayed value of years
    $form_submitted = false;

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $form_submitted = true; // Set to true when the form is submitted

        // Get form values
        $investment = filter_input(INPUT_POST, 'investment', FILTER_VALIDATE_FLOAT);
        $interest_rate = filter_input(INPUT_POST, 'interest_rate', FILTER_VALIDATE_FLOAT);
        $years = filter_input(INPUT_POST, 'years', FILTER_VALIDATE_INT);

        // Validate form data
        if ($investment === false ) {
            $error_message .= 'Investment must be a valid number.<br>'; 
        } else if ($investment <= 0) {
            $error_message .= 'Investment must be greater than zero.<br>'; 
        } 
        
        if ($interest_rate === false ) {
            $error_message .= 'Interest rate must be a valid number.<br>'; 
        } else if ($interest_rate <= 0) {
            $error_message .= 'Interest rate must be greater than zero.<br>'; 
        } else if ($interest_rate > 15) {
            $error_message .= 'Interest rate must be less than or equal to 15.<br>';
        }
        
        if ($years === false) {
            $error_message .= 'Years must be a valid whole number.<br>';
        } else if ($years <= 0) {
            $error_message .= 'Years must be greater than zero.<br>';
        } else if ($years > 30) {
            $error_message .= 'Years must be less than 31.<br>';
        }

        // Only calculate if there are no errors
        if (empty($error_message)) {
            // Store values for display
            $years_display = $years;

            // Calculate the future value
            $future_value = $investment;
            for ($i = 1; $i <= $years; $i++) {
                $future_value += $future_value * $interest_rate * 0.01;
            }

            // Applying formatting
            $investment_f = '$' . number_format($investment, 2);
            $yearly_rate_f = $interest_rate . '%';
            $future_value_f = '$' . number_format($future_value, 2);

            // Storing the results in session variables
            $_SESSION['investment_f'] = $investment_f;
            $_SESSION['yearly_rate_f'] = $yearly_rate_f;
            $_SESSION['years_display'] = $years_display;
            $_SESSION['future_value_f'] = $future_value_f;

            // Redirecting to the same page to display results
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }

    // Checking if there are results stored in the session to display after reload
    if (isset($_SESSION['future_value_f'])) {
        $investment_f = $_SESSION['investment_f'];
        $yearly_rate_f = $_SESSION['yearly_rate_f'];
        $years_display = $_SESSION['years_display'];
        $future_value_f = $_SESSION['future_value_f'];

        // Unset session variables after displaying the results
        unset($_SESSION['investment_f']);
        unset($_SESSION['yearly_rate_f']);
        unset($_SESSION['years_display']);
        unset($_SESSION['future_value_f']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Future Value Calculator</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <main>
        <h1>Future Value Calculator</h1>

        <?php if (!empty($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>

        <form action="" method="post">
            <div id="data">
                <label>Investment Amount:</label>
                <input type="text" name="investment" value=""><br>

                <label>Yearly Interest Rate:</label>
                <input type="text" name="interest_rate" value=""><br>

                <label>Number of Years:</label>
                <input type="text" name="years" value=""><br>
            </div>

            <div id="buttons">
                <label>&nbsp;</label>
                <input type="submit" value="Calculate"><br>
            </div>
        </form>

        <?php if (!empty($future_value_f)) { ?>
        <div id="results">
            <h2>Results</h2>
            <label>Investment Amount:</label>
            <span><?php echo htmlspecialchars($investment_f); ?></span><br />

            <label>Yearly Interest Rate:</label>
            <span><?php echo htmlspecialchars($yearly_rate_f); ?></span><br />

            <label>Number of Years:</label>
            <span><?php echo htmlspecialchars($years_display); ?></span><br />

            <label>Future Value:</label>
            <span><?php echo htmlspecialchars($future_value_f); ?></span><br />

            <p>This calculation was done on <?php echo date('m/d/Y'); ?>.</p>
        </div>
        <?php } ?>
    </main>
</body>
</html>
