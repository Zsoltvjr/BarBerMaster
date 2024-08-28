<?php
require '../../db_config.php';

// Initialize variables
$userIdFilter = '';
$dateFilter = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search'])) {
        $userIdFilter = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
        $dateFilter = isset($_POST['date']) ? trim($_POST['date']) : '';
    } elseif (isset($_POST['truncate'])) {
        try {
            $truncateQuery = "TRUNCATE TABLE activity_logs";
            $pdo->exec($truncateQuery);
            $message = "Aktivitások sikeresen törölve";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['export_csv'])) {
        // Handle CSV export
        $userIdFilter = isset($_POST['user_id']) ? trim($_POST['user_id']) : '';
        $dateFilter = isset($_POST['date']) ? trim($_POST['date']) : '';

        try {
            $query = "SELECT user_id, action, timestamp FROM activity_logs WHERE 1=1";
            
            if ($userIdFilter) {
                $query .= " AND user_id = :user_id";
            }
            
            if ($dateFilter) {
                $query .= " AND DATE(timestamp) = :date";
            }
            
            $statement = $pdo->prepare($query);
            
            if ($userIdFilter) {
                $statement->bindParam(':user_id', $userIdFilter, PDO::PARAM_INT);
            }
            
            if ($dateFilter) {
                $statement->bindParam(':date', $dateFilter);
            }
            
            $statement->execute();
            $logs = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Set CSV headers
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="activity_logs.csv"');
            $output = fopen('php://output', 'w');

            // Add CSV column headers
            fputcsv($output, ['User ID', 'Action', 'Timestamp']);

            // Add CSV rows
            foreach ($logs as $log) {
                fputcsv($output, $log);
            }

            fclose($output);
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

try {
    // Prepare the query with filters
    $query = "SELECT user_id, action, timestamp FROM activity_logs WHERE 1=1";
    
    if ($userIdFilter) {
        $query .= " AND user_id = :user_id";
    }
    
    if ($dateFilter) {
        $query .= " AND DATE(timestamp) = :date";
    }
    
    $statement = $pdo->prepare($query);

    // Bind parameters if they are set
    if ($userIdFilter) {
        $statement->bindParam(':user_id', $userIdFilter, PDO::PARAM_INT);
    }
    
    if ($dateFilter) {
        $statement->bindParam(':date', $dateFilter);
    }
    
    $statement->execute();

    // Fetch all the results
    $logs = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

include('includes/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Aktivitások</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($message)): ?>
                        <div class="alert alert-info">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="user_id">Azonosító</label>
                                <input type="number" id="user_id" name="user_id" class="form-control" value="<?php echo htmlspecialchars($userIdFilter); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="date">Dátum</label>
                                <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($dateFilter); ?>">
                            </div>
                            <div class="form-group col-md-4">
                                <label>&nbsp;</label>
                                <button type="submit" name="search" class="btn btn-primary form-control">Keresés</button>
                                <button type="submit" name="truncate" class="btn btn-danger form-control">Aktivitások törlése</button>
                                <button type="submit" name="export_csv" class="btn btn-primary form-control">Exportálás CSV</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Felhasználó azonosítója</th>
                                <th>Akció</th>
                                <th>Időtartam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($logs): ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($log['user_id']); ?></td>
                                        <td><?php echo htmlspecialchars($log['action']); ?></td>
                                        <td><?php echo htmlspecialchars($log['timestamp']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">Nincs megjeleníthető adat</td>
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
