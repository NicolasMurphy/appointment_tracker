<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Service</title>
</head>

<body>
    <h1>Create New Service</h1>

    <?php if (!empty($errorMessage)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>

    <form method="POST" action="/php/services.php?action=create">

        <label for="code">Service Code:</label><br>
        <input type="text" id="code" name="code" required value="<?php echo htmlspecialchars($code ?? ''); ?>"><br><br>

        <label for="description">Description:</label><br>
        <input type="text" id="description" name="description" required value="<?php echo htmlspecialchars($description ?? ''); ?>"><br><br>

        <label for="bill_rate">Bill Rate:</label><br>
        <input type="text" id="bill_rate" name="bill_rate" required value="<?php echo htmlspecialchars($billRate ?? ''); ?>"><br><br>

        <button type="submit">Create Service</button>
    </form>
</body>

</html>
