<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wonder Pro</title>
    <link rel="stylesheet" href="src/bootstrap/vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/bootstrap/vendor/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="src/bootstrap/vendor/css/datatables.min.css">
</head>
<body>
    <h2 class="mb-4">
    Toutes les entreprises
</h2>

<table id="tableEntreprises" class="table table-bordered">
    <thead>
        <tr>
            <th>Entreprise</th>
            <th>Domaine(s)</th>
            <th>Quartier</th>
            <th>Statut</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($entreprises as $e): ?>
        <tr>
            <td>
                <?= htmlspecialchars(
                    $e->nom_entreprise
                ) ?>
            </td>
            <td>
                <?= htmlspecialchars(
                    $e->domaines ?? "-"
                ) ?>
            </td>
            <td>
                <?= htmlspecialchars(
                    $e->quartier
                ) ?>
            </td>
            <td>
                <?php if($e->statut == "valide"): ?>
                    <span class="badge bg-success">
                        Validée
                    </span>
                <?php elseif($e->statut == "rejete"): ?>
                    <span class="badge bg-danger">
                        Refusée
                    </span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark">
                        En attente
                    </span>
                <?php endif; ?>
            </td>
            <td>
                <?= date(
                    "d/m/Y",
                    strtotime($e->created_at)
                ) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="src/bootstrap/vendor/js/jquery.min.js"></script>
<script src="src/bootstrap/vendor/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
    $('#tableEntreprises').DataTable();
});
</script>
</body>
</html>