<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Form</title>
  <link rel="stylesheet" type="text/css" href="./style.css">
</head>
<body>
  <div id="logo">
    <img src="./logo.png" alt="logo">
  </div>
  <form action="form.php" method="post">
    <label for="identifier">Identifier:</label>
    <input type="text" id="identifier" name="identifier">
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password">
    <br><br>
    <input type="reset" value="Reset">
    <input type="submit" name="login" value="Login">
    <input type="submit" name="add_account" value="Add Account">
  </form>
</body>
</html>
