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
        $geneSearch = true;
        $assocSearch = false;
        $diseaseSearch = false;
    } elseif($searchCategory == 'disease') {
        $geneSearch = false;
        $assocSearch = false;
        $diseaseSearch = true;
    } elseif($searchCategory == 'organization') {
        $geneSearch = false;
        $assocSearch = true;
        $diseaseSearch = false;
    } elseif($searchCategory == 'all') {
        $geneSearch = true;
        $assocSearch = true;
        $diseaseSearch = true;
    }
} else{
    print errorPage("Error", "Please, try again.");
    exit();
}

//  text query, adapted to use fulltext indexes, $textFields is defined in globals.inc.php and
//  lists all text fields to be searched in.
if ($_REQUEST['search']) {
    $query = $_REQUEST['search'];
    if ($geneSearch){
        $ORcondsGene = [];
        if (strlen($query) > 2){
            foreach (array_values($geneFields) as $field) {
                $ORcondsGene[] = $field." like '%".$query."%'";
                //$ORconds[] = "MATCH (" . $field . ") AGAINST ('" . $wd . "' "
                //        . "IN BOOLEAN MODE)";
            }
        }
        $ANDcondsGene[] = "(" . join(" OR ", $ORcondsGene) . ")";
    }
    if ($diseaseSearch){
        $ORcondsDis = [];
        if (strlen($query) > 2){
            foreach (array_values($diseaseFields) as $field) {
                $ORcondsDis[] = $field." like '%".$query."%'";
            }
        }
        $ANDcondsDis[] = "(" . join(" OR ", $ORcondsDis) . ")";
    }
    if ($assocSearch){
        $ORcondsAssoc = [];
        if (strlen($query) > 2){
            foreach (array_values($associationFields) as $field) {
                $ORcondsAssoc[] = $field." like '%".$query."%'";
            }
        }
        $ANDcondsAssoc[] = "(" . join(" OR ", $ORcondsAssoc) . ")";
    }
} else{
    print errorPage("No input", "Please, try again.");
    exit();
}

// SELECT columns FROM tables WHERE Conditions_from_relationships AND Conditions_from_query_Form
if ($geneSearch){
    $sqlGene = "SELECT distinct g.idGene,g.Name,g.Locus,g.Ensembl_id,g.OMIM_id,g.GenAtlas_id,g.HGNC_id,g.Symbol,g.SwissProt_id FROM 
    Gene g
    LEFT JOIN Gene_alias ga ON g.idGene=ga.Gene_idGene WHERE
    " . join(" AND ", $ANDcondsGene);
}
if ($diseaseSearch){
    $sqlDis = "SELECT distinct d.Name,d.Orphacode,d.idDiseases FROM 
    Disease d
    LEFT JOIN Disease_alias da ON d.Orphacode = da.Disease_Orphacode WHERE
    " . join(" AND ", $ANDcondsDis);
}
if ($assocSearch){
    $sqlAssoc = "SELECT distinct pa.Name,pa.Description,pa.idPatient_Associations,cpa.Patient_Association_idPatient_Associations,cpa.Country_idCountry,c.idCountry,c.Country_name FROM 
    Patient_Association pa, Country_has_Patient_Association cpa, Country c WHERE
    pa.idPatient_Associations=cpa.Patient_Association_idPatient_Associations AND
    cpa.Country_idCountry=c.idCountry AND
    " . join(" AND ", $ANDcondsAssoc);
}

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

#DEBUG
//print "<p>$sql</p>";

// if (!isset($_REQUEST['nolimit'])) {
//     $sql .= " LIMIT 5000"; // Just to avoid too long listings when testing
// }

// DB query

if ($mysqli) {
    if ($geneSearch){
        $rsGene = mysqli_query($mysqli,$sqlGene) or print errorPage("mysqli error", "The database request was unsuccessful.");
    }
    if ($diseaseSearch){
        $rsDis = mysqli_query($mysqli,$sqlDis) or print errorPage("mysqli error", "The database request was unsuccessful.");
    }
    if ($assocSearch){
        $rsAssoc = mysqli_query($mysqli,$sqlAssoc) or print errorPage("mysqli error", "The database request was unsuccessful.");
    }
} else {
    print errorPage("Connection failed", mysqli_connect_error());
}

$results = false;
if ($rsGene and mysqli_num_rows($rsGene)){
    $results = true;
    $geneResults = true;
}
if ($rsDis and mysqli_num_rows($rsDis)){
    $results = true;
    $diseaseResults = true;
}
if ($rsAssoc and mysqli_num_rows($rsAssoc)){
    $results = true;
    $assocResults = true;
}
//     We check whether there are results to show
if (!$results) {
    print errorPage("No results", "0 results match " . $query);
    exit();
}

// end controller section ====================================================================
?>

<!--  Results table formated with DataTable-->
<?= headerDBW()?>
<div class = "content-search_searchtitle">
    <div class="container_searchtitle">
        <h1 class="search-title">Search results: <?= $query ?></h1>
    </div>
</div>
<?php
if ($geneResults) {
?>
    <div class="content-search_searchresults">
    <div class="container_searchresults">
    <h2 class="title_searchresults">Results: Genes</h2>
    <p class="hits">Num Hits: <?= mysqli_num_rows($rsGene) ?></p>
            <table border="0" cellspacing="2" cellpadding="4" id="dataTableGenes" class = "rounded-table">
                <thead>
                    <tr>
                        <th>Symbol</th>
                        <th>Name</th>
                        <th>Locus</th>
                        <th>Ensembl ID</th>
                        <th>OMIM ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rsG = mysqli_fetch_assoc($rsGene)) { ?>
                    <tr>
                        <td><a href="getGene.php?idGene=<?= $rsG['idGene'] ?>"><?= $rsG['Symbol'] ?></a></td>
                        <td><?= $rsG['Name'] ?></td>
                        <td><?= $rsG['Locus'] ?></td>
                        <td><?= $rsG['Ensembl_id'] ?></td>
                        <td><?= $rsG['OMIM_id'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
?>

<?php
if ($diseaseResults) {
?>
    <div class="content-search_searchresults">
    <div class="container_searchresults">
    <h2 class="title_searchresults">Results: Diseases</h2>
    <p class="hits">Num Hits: <?= mysqli_num_rows($rsDis) ?></p>
            <table border="0" cellspacing="2" cellpadding="4" id="dataTableDiseases" class = "rounded-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>OrphaCode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rsD = mysqli_fetch_assoc($rsDis)) { ?>
                    <tr>
                        <td><a href="getDisease.php?idDisease=<?= $rsD['idDiseases'] ?>"><?= $rsD['Name'] ?></a></td>
                        <td><?= $rsD['Orphacode'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
?>

<?php
if ($assocResults) {
?>
    <div class="content-search_searchresults">
    <div class="container_searchresults">
    <h2 class="title_searchresults">Results: Patient Associations</h2>
    <p class="hits">Num Hits: <?= mysqli_num_rows($rsAssoc) ?></p>
            <table border="0" cellspacing="2" cellpadding="4" id="dataTableAssociations" class = "rounded-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rsA = mysqli_fetch_assoc($rsAssoc)) { ?>
                    <tr>
                        <td><a href="getAssoc.php?idCode=<?= $rsA['idPatient_Associations'] ?>"><?= $rsA['Name'] ?></a></td>
                        <td><?= $rsA['Country_name'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
?>

<div class="container_end_searchresults">
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTableGenes').DataTable();
        $('#dataTableDiseases').DataTable();
        $('#dataTableAssociations').DataTable();
    });
</script>

<?= footerDBW() ?>