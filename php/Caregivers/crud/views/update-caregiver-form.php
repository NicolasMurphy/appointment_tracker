<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Caregiver</title>
</head>

<body>
    <h1>Update Caregiver</h1>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($caregiverData['id']); ?>">

        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required value="<?php echo htmlspecialchars($caregiverData['first_name']); ?>"><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required value="<?php echo htmlspecialchars($caregiverData['last_name']); ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($caregiverData['email']); ?>"><br><br>

        <label for="phone_number">Phone Number:</label><br>
        <input type="tel" id="phone_number" name="phone_number" required value="<?php echo htmlspecialchars($caregiverData['phone_number']); ?>"><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required value="<?php echo htmlspecialchars($caregiverData['address']); ?>"><br><br>

        <label for="pay_rate">Pay Rate:</label><br>
        <input type="text" id="pay_rate" name="pay_rate" required value="<?php echo htmlspecialchars($caregiverData['pay_rate']); ?>"><br><br>

        <button type="submit">Update Caregiver</button>
    </form>
</body>

</html>
