<?php

session_start();

// Connect to the MariaDB database
$db = mysqli_connect('localhost', 'root', '', 'users');

// Check if the connection was successful
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the values from the form
  $identifier = mysqli_real_escape_string($db, $_POST['identifier']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  // Check if the login button was clicked
  if (isset($_POST['login'])) {
    // Check if the user exists in the database
    $result = mysqli_query($db, "SELECT * FROM users WHERE identifier = '$identifier'");

    // Check if the user is locked out
    if (isset($_SESSION['locked_out']) && time() < $_SESSION['locked_out']) {
      echo "Your account is temporarily locked out. Please try again later.";
    } else {
      // If the user exists, verify the password
      if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
          echo "Login successful for user $identifier";
        } else {
          echo "Login failed: incorrect password";
          // Lock the user out for 5 minutes after 5 failed attempts
          if (!isset($_SESSION['failed_attempts'])) {
            $_SESSION['failed_attempts'] = 1;
          } else {
            $_SESSION['failed_attempts']++;
          }
          // Lock the user out for 5 minutes after 5 failed attempts
          if ($_SESSION['failed_attempts'] >= 5) {
            $_SESSION['locked_out'] = time() + 300;
            echo "Your account has been temporarily locked out for 5 minutes.";
            $_SESSION['failed_attempts'] = 0;
          }
        }
      } else {
        echo "Login failed: user not found";
      }
    }
    // Check if the add account button was clicked
  } elseif (isset($_POST['add_account'])) {
    if (empty($identifier) || empty($password)) {
      echo "Login failed: identifier and password cannot be empty";
    } else {
      // Check if the password meets the length requirement
      if (strlen($password) < 8) {
        echo "Login failed: password must be at least 8 characters long";
      } else {
        // Check if the password meets the pattern requirement
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+-=,.<>?])/', $password)) {
          echo "Login failed: password must contain at least one uppercase letter, one lowercase letter, one number, and one special character";
        }
      }
    }
    // Create the users table if it doesn't already exist
    mysqli_query($db, "CREATE TABLE IF NOT EXISTS users (identifier VARCHAR(100) PRIMARY KEY NOT NULL, password VARCHAR(100) NOT NULL)");
    // Check if the user already exists in the database
    $query = "SELECT * FROM users WHERE identifier = '$identifier'";
    $result = mysqli_query($db, $query);
    if (mysqli_num_rows($result) == 1) {
      echo "Login failed: user already exists";
    }else{
      // Add the user to the database with a hashed password
      $password = password_hash($password, PASSWORD_DEFAULT);
      $query = "INSERT INTO users (identifier, password) VALUES ('$identifier', '$password')";
      mysqli_query($db, $query);
      echo "User added successfully";
    }
  } elseif (isset($_POST['reset'])) {
    // Reset the form fields
    $identifier = "";
    $password = "";
  }

  // Close the database connection
  mysqli_close($db);
}

?>
