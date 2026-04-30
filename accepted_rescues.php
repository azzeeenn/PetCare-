<?php
$conn = new mysqli("localhost", "root", "", "petcare1");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch accepted rescues
$sql = "SELECT * FROM accepted_rescues";
$result = $conn->query($sql);

// Fetch available rescue teams
$teams_sql = "SELECT * FROM rescue_teams";
$teams_result = $conn->query($teams_sql);
$teams = [];
while ($team = $teams_result->fetch_assoc()) {
    $teams[] = $team;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accepted Rescue Requests</title>
    <link rel="stylesheet" href="css/petrescuemanagament.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="shortcut icon" href="http://localhost/PetCareProject/favicon.ico" type="image/x-icon">
p
</head>
<body>

<header>
    <h1>Accepted Rescue Requests</h1>
</header>

<nav class="navigation">
    <a href="../adminside/rescueform.php">Pet Rescue Form Details Management</a>
</nav><br><br><br>

<table id="acceptedRescueTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Location</th>
            <th>Pet Type</th>
            <th>Condition</th>
            <th>Urgency</th>
            <th>Additional Notes</th>
            <th>Image</th>
            <th>Assigned Team</th>
            <th>Actions</th>
        </tr>
    </thead>
    
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr data-id="<?= $row['id'] ?>">
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['location'] ?></td>
                    <td><?= $row['pet_type'] ?></td>
                    <td><?= $row['pet_condition'] ?></td>
                    <td><?= $row['urgency'] ?></td>
                    <td><?= $row['additional_notes'] ?></td>
                    <td>
    <?php if (!empty($row['pet_image'])): ?>
        <img src="/PetCareProject/uploads/<?= htmlspecialchars($row['pet_image']) ?>" 
             alt="Pet Image" 
             class="pet-img">
    <?php else: ?>
        No Image
    <?php endif; ?>
</td>

                    <td>
                        <select class="assign-team" data-id="<?= $row['id'] ?>">
                            <option value="">Select Team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= $team['team_name'] ?>"><?= $team['team_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <button class="styled-button assign-btn" data-id="<?= $row['id'] ?>">Assign</button><br><br>
                        <button class="styled-button rescue-complete-btn" data-id="<?= $row['id'] ?>">Mark as Rescued</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="9">No accepted rescues yet.</td></tr>
        <?php endif; ?>
    </tbody>
</table>


<script src="js/accepted_rescues.js"></script>

</body>
</html>

<?php $conn->close(); ?>
