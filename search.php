<?php

// load global vars and includes
require "globals.php";

// Store input data in $_SESSION to reload initial form if necessary
$_SESSION['queryData'] = $_REQUEST;


//  normal search, Building SQL SELECT from the input form
//     $ANDConds will contain all SQL conditions found in the form
$ANDconds = ["True"]; // required to fulfill SQL syntax if form is empty

// searchCategory
if (isset($_REQUEST['searchCategory'])){
    $searchCategory = $_REQUEST['searchCategory'];
    if ($searchCategory == 'gene'){
        $textFields = $geneFields;
    } elseif($searchCategory == 'disease') {
        $textFields = $diseaseFields;
    } elseif($searchCategory == 'organization') {
        $textFields = $associationFields;
    } elseif($searchCategory == 'all') {
        $textFields = array_merge($geneFields, $diseaseFields, $associationFields);
    }
} else{
    print errorPage("Error", "Please, try again.");
    exit();
}

//  text query, adapted to use fulltext indexes, $textFields is defined in globals.inc.php and
//  lists all text fields to be searched in.
if ($_REQUEST['search']) {
    $ORconds = [];
    foreach (array_merge([$_REQUEST['search']], explode(' ',$_REQUEST['search'])) as $wd){
        foreach (array_values($textFields) as $field) {
            $ORconds[] = $field." like '%".$wd."%'";
            //$ORconds[] = "MATCH (" . $field . ") AGAINST ('" . $wd . "' "
            //        . "IN BOOLEAN MODE)";
        }
    }
    $ANDconds[] = "(" . join(" OR ", $ORconds) . ")";
} else{
    print errorPage("No input", "Please, try again.");
    exit();
}

//  main SQL string, make sure that all tables are joint, and relationships included
// SELECT columns FROM tables WHERE Conditions_from_relationships AND Conditions_from_query_Form
$sql = "SELECT distinct g.idGene,g.Name,g.Locus,g.Ensembl_id,g.OMIM_id,g.GenAtlas_id,g.HGNC_id,g.Symbol,g.SwissProt_id,ga.Alias_name,ga.Gene_idGene FROM 
    Gene g, Gene_alias ga WHERE
    g.idGene=ga.Gene_idGene AND
    " . join(" AND ", $ANDconds);


//    Ordering will be done by the DataTable element using JQuery, if not available can also be done from the SQL 
//    switch ($order) {
//        case 'idCode':
//        case 'header':
//        case 'compound':
//        case 'resolution':
//            $sql .= " ORDER BY e." . $order;
//            break;
//        case 'source':
//            $sql .= " ORDER BY s.source";
//            break;
//        case 'expType':
//            $sql .= " ORDER BY et.expType";
//            break;
//    }
if (!isset($_REQUEST['nolimit'])) {
    $sql .= " LIMIT 5000"; // Just to avoid too long listings when testing
}
#DEBUG
//print "<p>$sql</p>";

// DB query
if ($mysqli) {
    $rs = mysqli_query($mysqli,$sql) or print errorPage("mysqli error", "The database request was unsuccessful.");
} else {
    print errorPage("Connection failed", mysqli_connect_error());
}

//     We check whether there are results to show
if (!mysqli_num_rows($rs)) {
    print errorPage("Not Found", "No results found.");
    exit();
}

// end controller section ====================================================================
?>

<!--  Results table formated with DataTable-->
<?= headerDBW()?>
<div class="content-search">
  <div class="container">
  <h2 class="title">Results: Genes</h2>
  <p>Num Hits: <?= mysqli_num_rows($rs) ?></p>
        <table border="0" cellspacing="2" cellpadding="4" id="dataTable" class = "rounded-table">
            <thead>
                <tr>
                    <th>Symbol</th>
                    <th>Name</th>
                    <th>Locus</th>
                    <th>Ensembl ID</th>
                    <th>OMIM ID</th>
                    <th>GenAtlas ID</th>
                    <th>HGNC ID</th>
                    <th>SwissProt ID</th>
                    <th>Alias</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($rsF = mysqli_fetch_assoc($rs)) { ?>
                <tr>
                    <td><a href="getGene.php?idCode=<?= $rsF['idGene'] ?>"><?= $rsF['Symbol'] ?></a></td>
                    <td><?= $rsF['Name'] ?></td>
                    <td><?= $rsF['Locus'] ?></td>
                    <td><?= $rsF['Ensembl_id'] ?></td>
                    <td><?= $rsF['OMIM_id'] ?></td>
                    <td><?= $rsF['GenAtlas_id'] ?></td>
                    <td><?= $rsF['HGNC_id'] ?></td>
                    <td><?= $rsF['SwissProt_id'] ?></td>
                    <td><?= $rsF['Alias_name'] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<p class="button"><a href="index.php?new=1">New Search</a></p>
<script type="text/javascript">
<!-- this activates the DataTable element when page is loaded-->
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>
<?= footerDBW() ?>