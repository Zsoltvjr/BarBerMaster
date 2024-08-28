<?php
require '../../db_config.php';

try {
    // Prepare and execute the query to fetch all users
    $query = "SELECT user_id, username, last_name, first_name, email, mobile, active, is_blocked FROM users";
    $statement = $pdo->prepare($query);
    $statement->execute();

    // Fetch all the results
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

include('includes/header.php');
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Felhasználók listája</h4>
                </div>
                <div class="card-body">
                    <!-- Add table-responsive class to make table responsive -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Felhasználó ID</th>
                                    <th>Felhasználónév</th>
                                    <th>Vezetéknév</th>
                                    <th>Keresztnév</th>
                                    <th>Email</th>
                                    <th>Mobil</th>
                                    <th>Aktív</th>
                                    <th>Blokkolva</th>
                                    <th>Akciók</th>
                                </tr>
                            </thead>
                            <tbody id="user-table-body">
                                <?php if ($users): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr id="user-<?php echo htmlspecialchars($user['user_id']); ?>">
                                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                                            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['mobile']); ?></td>
                                            <td><?php echo $user['active'] ? '<span class="badge bg-success">Igen</span>' : '<span class="badge bg-secondary">Nem</span>'; ?></td>
                                            <td><?php echo $user['is_blocked'] ? '<span class="badge bg-danger">Igen</span>' : '<span class="badge bg-secondary">Nem</span>'; ?></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm delete-btn" data-user-id="<?php echo htmlspecialchars($user['user_id']); ?>">Törlés</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Nincs megjeleníthető adat.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div> <!-- End of table-responsive -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.delete-btn').click(function() {
        var userId = $(this).data('user-id');
        var row = $(this).closest('tr');
        
        if (confirm('Biztosan törölni szeretnéd ezt a felhasználót?')) {
            $.ajax({
                url: 'delete_user.php',
                type: 'POST',
                data: { user_id: userId },
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    if (response.status === 'success') {
                        row.remove();
                    } else {
                        alert('Hiba történt a törlés során: ' + (response.message || 'Ismeretlen hiba'));
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Részletesebb hibaüzenet a konzolon
                    alert('AJAX hiba: ' + error);
                }
            });
        }
    });
});
</script>
