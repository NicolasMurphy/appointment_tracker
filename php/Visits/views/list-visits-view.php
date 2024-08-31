<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit List</title>
</head>

<body>
    <?php include './nav.php'; ?>
    <h1>Visit List</h1>
    <?php if (!empty($visits)): ?>
        <ul id="visit-list">
            <?php foreach ($visits as $visitItem): ?>
                <li data-client="<?php echo htmlspecialchars($visitItem['client_last_name']); ?>" data-caregiver="<?php echo htmlspecialchars($visitItem['caregiver_last_name']); ?>" data-date="<?php echo htmlspecialchars($visitItem['date']); ?>">
                    Client: <?php echo htmlspecialchars($visitItem['client_last_name']) . ', ' . htmlspecialchars($visitItem['client_first_name']); ?>
                    -
                    Caregiver:
                    <?php echo htmlspecialchars($visitItem['caregiver_last_name']) . ', ' . htmlspecialchars($visitItem['caregiver_first_name']); ?>
                    -
                    Service:
                    <?php echo htmlspecialchars($visitItem['service_code']) . ' - $' . htmlspecialchars($visitItem['service_bill_rate']) ?>
                    -
                    <?php echo htmlspecialchars($visitItem['date']); ?>
                    from
                    <?php echo htmlspecialchars($visitItem['start_time']); ?>
                    to
                    <?php echo htmlspecialchars($visitItem['end_time']); ?>
                    -
                    <?php echo htmlspecialchars($visitItem['notes']); ?>

                    <form method="POST" action="/php/visits.php?action=verify" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($visitItem['id']); ?>">
                        <input type="hidden" name="verified" value="0">
                        <input type="checkbox" name="verified" value="1" <?php echo $visitItem['verified'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                        Verified
                    </form>

                    <a href="?action=update&id=<?php echo htmlspecialchars($visitItem['id']); ?>">Edit</a>

                    <form method="POST" action="/php/visits.php?action=delete" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($visitItem['id']); ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No visits found.</p>
    <?php endif; ?>
    <a href="/php/visits.php?action=create">Create New Visit</a>
    <script type="module" src="../../../js/sortFunctions.js"></script>
</body>

</html>
