<?php
require '../../db_config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['truncate_table'])) {
       
        $truncateQuery = "TRUNCATE TABLE user_info"; 
        $pdo->exec($truncateQuery);
    }

    $query = "SELECT id, ip, device, os, browser, date, username FROM user_info"; 
    $statement = $pdo->prepare($query);
    $statement->execute();

    
    $records = $statement->fetchAll(PDO::FETCH_ASSOC);
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
                    <h4>Felhasználói adatok</h4>
                    <form method="post" style="display:inline;">
                        <button type="submit" name="truncate_table" class="btn btn-danger btn-sm" onclick="return confirm('Biztosan törli az összes adatot?');">
                            Adatok törlése
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>IP</th>
                                <th>Eszköz</th>
                                <th>Operációs Rendszer</th>
                                <th>Böngésző</th>
                                <th>Dátum</th>
                                <th>Felhasználónév</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            <?php if ($records): ?>
                                <?php foreach ($records as $record): ?>
                                    <tr id="record-<?php echo htmlspecialchars($record['id']); ?>">
                                        <td><?php echo htmlspecialchars($record['id']); ?></td>
                                        <td><?php echo htmlspecialchars($record['ip']); ?></td>
                                        <td><?php echo htmlspecialchars($record['device']); ?></td>
                                        <td><?php echo htmlspecialchars($record['os']); ?></td>
                                        <td><?php echo htmlspecialchars($record['browser']); ?></td>
                                        <td><?php echo htmlspecialchars($record['date']); ?></td>
                                        <td><?php echo htmlspecialchars($record['username']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Nincs megjeleníthető adat.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>       
            </div>        
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
