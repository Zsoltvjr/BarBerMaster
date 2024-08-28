<?php
require '../../db_config.php';

try {
    // Prepare and execute the query
    $query = "SELECT user_id, username, is_blocked FROM users";
    $statement = $pdo->prepare($query);
    $statement->execute();

    // Fetch all the results
    $owners = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

include('includes/header.php');      
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>
                   Banned List
                </h4>
            </div>  
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($owners): ?>
                            <?php foreach ($owners as $owner): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($owner['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($owner['username']); ?></td>
                                    <td>
                                        <?php if ($owner['is_blocked']): ?>
                                            <a href="unban_user.php?id=<?php echo urlencode($owner['user_id']); ?>&name=<?php echo urlencode($owner['username']); ?>" class="btn btn-success">Unban User</a>
                                        <?php else: ?>
                                            <a href="ban_user.php?id=<?php echo urlencode($owner['user_id']); ?>&name=<?php echo urlencode($owner['username']); ?>" class="btn btn-danger">Ban User</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>       
        </div>        
    </div>
</div>

<?php include('includes/footer.php'); ?>
