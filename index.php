<?php
require_once 'SimplePaginator.php';

$Paginator = SimplePaginator::getInstance('posts.json');

$numberOfLinks = $Paginator->getNumberOfPages();
$k = isset($_GET['k']) ? $_GET['k'] : 1;
$k = is_numeric($k) ? $k : 1;
$k = in_array($k, range(1,$numberOfLinks)) ? $k : 1;


$results = $Paginator->getDataRows($k);

?>

<!DOCTYPE html>
<head>
    <title>PHP Pagination</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">

</head>

<style>
    .table-striped > tbody > tr:nth-child(even) > td,
    .table-striped > tbody > tr:nth-child(even) > th {
        background-color: limegreen;
    }
</style>

<body>

<?php

?>

<div class="container-fluid">
    <nav aria-label="...">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item"><a class="page-link" href="?k=<?= $k<=1 ? 1 : $k-1 ?>">Previos</a></li>
            <?php for ($i = 1; $i <= $numberOfLinks; $i++) :?>
                <li class="page-item <?= $i == $k ? 'active' : '' ?>">
                    <a class="page-link" href="?k=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item"><a class="page-link" href="?k=<?= $k>=$numberOfLinks ? $numberOfLinks : $k+1 ?>">Next</a></li>
        </ul>
    </nav>
</div>

<div class="container-fluid">
    <br>
    <table class="table table-striped table-condensed table-bordered table-rounded">
        <tbody>
        <?php for ($i = 0; $i < count($results->rows); $i++) : ?>
            <tr>
                <td><?php echo $results->rows[$i]['title']; ?></td>
                <td><?php echo $results->rows[$i]['author']; ?></td>
                <td><?php echo $results->rows[$i]['content']; ?></td>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>
</body>
</html>



