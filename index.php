<?php //html pa din, ang opening lang ay php, meaning inainclude ang ginawa mong connection
include "db.php"; //kapag gusto mo isama yong db.php alisin mo na ang index... sa IBABAW din ang lagay ng php. 

$message = ""; //dineclare lang para mamaya lalagyan ng value

if (isset($_POST["submit"])) {
    $name = $_POST["Name"]; //POST/GET 
    $email = $_POST["Email"];
    


    $sql = "INSERT INTO formstb (Name, Email) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $name, $email);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Data saved successfully!";
    } else {
        $message = "Error saving data.";
    }

    mysqli_stmt_close($stmt);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Form</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            width: 300px;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px #ccc;
        }

        input {
            width: 100%;
            padding: 10px 0;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Registration Form</h2>

        <p><?php echo htmlspecialchars($message); ?></p>

        <form method="POST" action="">
            <label>Full Name</label>
            <input type="text" name="Name"
                   placeholder="Enter your name" required>

            <label>Email</label>
            <input type="email" name="Email"
                   placeholder="Enter your email" required>


           
            <button type="submit" name="submit">
                Submit
            </button>
        </form>
    </div>

</body>
</html>