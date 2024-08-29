<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Caregiver</title>
</head>

<body>
    <h1>Create New Caregiver</h1>

    <?php if (!empty($errorMessage)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>

    <form method="POST" action="/php/caregivers.php?action=create">

        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required value="<?php echo htmlspecialchars($firstName ?? ''); ?>"><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required value="<?php echo htmlspecialchars($lastName ?? ''); ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email ?? ''); ?>"><br><br>

        <label for="phone_number">Phone Number:</label><br>
        <input type="tel" id="phone_number" name="phone_number" required value="<?php echo htmlspecialchars($phoneNumber ?? ''); ?>"><br><br>

        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" required value="<?php echo htmlspecialchars($address ?? ''); ?>"><br><br>

        <label for="pay_rate">Pay Rate:</label><br>
        <input type="text" id="pay_rate" name="pay_rate" required value="<?php echo htmlspecialchars($payRate ?? ''); ?>"><br><br>

        <button type="submit">Create Caregiver</button>
    </form>
</body>

</html>
