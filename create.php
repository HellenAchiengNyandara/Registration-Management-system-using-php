<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $id_number = $country = "";
$name_err = $id_number_err = $country_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate id number
    $input_id_number = trim($_POST["id_number"]);
    if (empty($input_id_number)) {
        $id_number_err = "Please enter your id number.";
    } else {
        $id_number = $input_id_number;
    }

    // Validate country
    //$input_country = trim($_POST["country"]);
    //if (empty($input_country)) {
    //$country_err = "Please enter your country.";
    // } elseif (!ctype_digit($input_country)) {
    //  $country_err = "Please enter a varchar.";
    // } else {
    //  $country = $input_country;
    // }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($id_number_err) && empty($Country_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO employees11 (name, id_number, country) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_id_number, $param_country);

            // Set parameters
            $param_name = $name;
            $param_id_number = $id_number;
            $param_country = $country;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to register Client.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>ID NUMBER</label>
                            <textarea name="id_number" class="form-control <?php echo (!empty($id_number_err)) ? 'is-invalid' : ''; ?>"><?php echo $id_number; ?></textarea>
                            <span class="invalid-feedback"><?php echo $id_number_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <select name="Country">
                                <option value="Uganda">Uganda</option>
                                <option value="Kenya">Kenya</option>
                                <option value="Tanzania">Tanzania</option>
                                <option value="Congo">Congo</option>
                            </select>

                            <?php echo (!empty($country_err)) ? 'is-invalid' : ''; ?><?php echo $country; ?>
                            <span class="invalid-feedback"><?php echo $country_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>