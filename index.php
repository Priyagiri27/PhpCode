<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="movie.css">
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the input values
  $movie = $_POST["movie"];
  $date = $_POST["date"];
  $time = $_POST["time"];
  $seats = $_POST["seats"];

  // Perform form validation
  if (empty($movie) || empty($date) || empty($time) || empty($seats) || $seats <= 0) {
    $message = "Please fill in all fields with valid values.";
  } else {
    // Connect to database (replace with your own database details)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "movie_tickets";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Insert booking details into database
    $sql = "INSERT INTO bookings (movie, date, time, seats) VALUES ('$movie', '$date', '$time', '$seats')";
    if ($conn->query($sql) === TRUE) {
      $message = "Booking successful. Your booking ID is " . $conn->insert_id . ".";
    } else {
      $message = "Booking failed. Please try again later.";
    }

    // Close database connection
    $conn->close();
  }
}

?>

<!-- HTML code for booking form -->
<div class="container">
<h1>Book Movie Tickets</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <label for="movie">Movie:</label>
  <input type="text" id="movie" name="movie"><br><br>
  <label for="date">Date:</label>
  <input type="date" id="date" name="date"><br><br>
  <label for="time">Time:</label>
  <input type="time" id="time" name="time"><br><br>
  <label for="seats">Number of seats:</label>
  <input type="number" id="seats" name="seats"><br><br>
  <button type="submit">Book Now</button>
</form>
</div>

<!-- Display booking status message -->
<?php if (isset($message)) { ?>
  <p><?php echo $message; ?></p>
<?php } ?>

<!-- cancelation code -->
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the input values
  $booking_id = $_POST["booking_id"];

  // Perform form validation
  if (empty($booking_id)) {
    $message = "Please enter a booking ID.";
  } else {
    // Connect to database (replace with your own database details)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "movie_tickets";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Delete booking from database
    $sql = "DELETE FROM bookings WHERE id='$booking_id'";
    if ($conn->query($sql) === TRUE) {
      $message = "Booking cancelled successfully.";
    } else {
      $message = "Cancellation failed. Please try again later.";
    }
}
} ?>
    <!-- // Close database connection -->

   <div  class="container">
   <h1>Cancel Movie Booking</h1>
<form method="post" action="index.php">
  <label for="booking_id">Booking ID:</label>
  <input type="text" id="booking_id" name="booking_id"><br><br>
  <button type="submit">Cancel Booking</button>
</form>
   </div>

<!-- Display cancellation status message -->
<?php if (isset($message)) { ?>
  <p><?php echo $message; ?></p>
<?php } ?>

</body>
</html>