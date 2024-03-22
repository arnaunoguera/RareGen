<?php
/*
 * index.php
 * main form
 */
// Loading global variables and DB connection
require "globals.php";
//
// $_SESSION['queryData'] array holds data from previous forms, 
// if empty it should be initialized to avoid warnings, and set defaults
// also a ...?new=1 allows to clean it from the URL.
//

if (isset($_REQUEST['new']) or !isset($_SESSION['queryData'])) {
    $_SESSION['queryData'] = [
        'search' => ''
    ];
}

//get requested data
$sqlGene = "SELECT g.* from Gene g where g.idGene='" . $_REQUEST['idGene'] . "'";

if ($mysqli) {
    $rsGene = mysqli_query($mysqli, $sqlGene) or print errorPage("mysqli error", "The database request was unsuccessful.");
} else {
    print errorPage("Connection failed", mysqli_connect_error());
}

$data = mysqli_fetch_assoc($rsGene);

$sqlAlias = "SELECT g.* from Gene_alias g where g.Gene_idGene='" . $_REQUEST['idGene'] . "'";

if ($mysqli) {
    $rsAlias = mysqli_query($mysqli, $sqlAlias) or print errorPage("mysqli error", "The database request was unsuccessful.");
} else {
    print errorPage("Connection failed", mysqli_connect_error());
}

while ($alias = mysqli_fetch_assoc($rsAlias)) {
    $aliasIDs[] = $alias['Alias_name'];
}

?>


<?= headerDBW()?>
<div class = "content-resultstitle">
    <div class="container_resultstitle">
        <h1 class="results-title">GENE | <?= $data["Symbol"]?></h1>
    </div>
</div>
<div class="content-results">
    <div class="container_results">
        <h2 class="title_results">General information</h2>
        <?php if(isset($data["Name"]) && !empty($data["Name"])): ?>  
            <p class="result_item"><b>Gene name:</b> <?= ucfirst($data['Name']) ?></p> 
        <?php endif; ?>
        <?php if(isset($aliasIDs) && !empty($aliasIDs)): ?>  
            <p class="result_item"><b>Gene alias:</b> <?= implode(", ", $aliasIDs); ?></p> 
        <?php endif; ?>  
        <?php if(isset($data["Gene_type"]) && !empty($data["Gene_type"])): ?>  
            <p class="result_item"><b>Gene type:</b> <?= ucfirst($data['Gene_type']) ?></p> 
        <?php endif; ?>
        <?php if(isset($data["Locus"])&& !empty($data["Locus"])): ?>  
            <p class="result_item"><b>Locus:</b> <?= $data['Locus'] ?></p> 
        <?php endif; ?>
        <?php if(isset($data["Description"]) && !empty($data["Description"])): ?>  
            <p class="result_item"><b>Description:</b> <?= ucfirst($data['Description'])?></p> 
        <?php endif; ?>
    </div>
    <div class="container_results">    
        <?php if((isset($data["Ensembl_id"])&& !empty($data["Ensembl_id"])) or (isset($data["OMIM_id"]) && !empty($data["OMIM_id"])) or (isset($data["HGNC_id"]) && !empty($data["HGNC_id"])) or (isset($data["SwissProt_id"])&& !empty($data["SwissProt_id"]))): ?> 
            <h2 class="title_results">IDs</h2> 
            <table class="rounded-table">
                <tbody>
                    <?php if(isset($data["Ensembl_id"]) && !empty($data["Ensembl_id"])): ?>
                        <tr class="row clickable" onclick="window.open('https://www.ensembl.org/Homo_sapiens/Gene/Summary?db=core;g=<?php echo urlencode($data["Ensembl_id"]); ?>', '_blank');">
                            <td>Ensembl</td>
                            <td><?=$data["Ensembl_id"]?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if(isset($data["OMIM_id"]) && !empty($data["OMIM_id"])): ?>
                        <tr class="row clickable" onclick="window.open('https://www.omim.org/entry/<?php echo urlencode($data["OMIM_id"]); ?>', '_blank');">
                            <td>OMIM</td>
                            <td><?= $data['OMIM_id'] ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if(isset($data["SwissProt_id"]) && !empty($data["SwissProt_id"])): ?>
                        <tr class="row clickable" onclick="window.open('https://www.uniprot.org/uniprotkb/<?php echo urlencode($data["SwissProt_id"]); ?>', '_blank');">
                            <td>UniProtKB/Swiss-Prot</td>
                            <td><?= $data['SwissProt_id'] ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if(isset($data["HGNC_id"]) && !empty($data["HGNC_id"])): ?>
                        <tr class="row clickable" onclick="window.open('https://www.genenames.org/data/gene-symbol-report/#!/hgnc_id/HGNC:<?php echo urlencode($data["HGNC_id"]); ?>', '_blank');">
                            <td>HGNC</td>
                            <td><?= $data['HGNC_id'] ?></td>
                        </tr></a>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?> 
    </div> 
</div>

<?= footerDBW()?>