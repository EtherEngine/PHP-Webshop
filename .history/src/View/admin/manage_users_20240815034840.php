<?php
include '../templates/header.php';
include '../templates/navigation.php';

require_once __DIR__ . '/../Controller/AdminController.php';

$admin = new AdminController();
$users = $admin->viewUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_user_status'])) {
    $admin->toggleUserStatus($_POST['user_id']);
    header("Location: manage_users.php");
    exit();
}

?>

<div class="container mt-5">
    <h1>Benutzerverwaltung</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Benutzername</th>
                <th>E-Mail</th>
                <th>Status</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['status']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" name="toggle_user_status" class="btn btn-warning">
                                <?php echo $user['status'] === 'active' ? 'Sperren' : 'Entsperren'; ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>