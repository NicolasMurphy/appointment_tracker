<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Service</title>
</head>

<body>
    <h1>Update Service</h1>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($serviceData['id']); ?>">

        <label for="code">Service Code:</label><br>
        <input type="text" id="code" name="code" required value="<?php echo htmlspecialchars($serviceData['code']); ?>"><br><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" required value="<?php echo htmlspecialchars($serviceData['description']); ?>"><br><br>

        <label for="bill_rate">Bill Rate:</label><br>
        <input type="text" id="bill_rate" name="bill_rate" required value="<?php echo htmlspecialchars($serviceData['bill_rate']); ?>"><br><br>

        <button type="submit">Update Service</button>
    </form>
</body>

</html>
