<?php
require '../../db_config.php';

try {
    // Prepare and execute the query
    $query = "SELECT salon_owner_id, owner_name FROM salon_owner";
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
                    Tulajok listája
                    <div class="d-flex float-end">
                        <a href="user_add.php" class="btn btn-primary">Tulaj hozzáadása</a>
                        <a href="user_delete.php" class="btn btn-danger ms-2">Tulaj törlése</a>
                    </div>
                </h4>
                
            </div>  
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Szalon tulaj ID</th>
                            <th>Szalon tulajok nevei</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($owners): ?>
                            <?php foreach ($owners as $owner): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($owner['salon_owner_id']); ?></td>
                                    <td><?php echo htmlspecialchars($owner['owner_name']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>       
        </div>        
    </div>
</div>

<?php include('includes/footer.php');      ?>