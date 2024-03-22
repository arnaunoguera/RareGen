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

// Ensure that mysqli is available
if (!$mysqli) {
    print errorPage("Connection failed", mysqli_connect_error());
    exit(); // Exit script to avoid further execution
}

// Fetch disease data
$sqlDisease = "SELECT d.* FROM Disease d WHERE d.idDiseases='" . $_REQUEST['idDisease'] . "'";
$rsDisease = mysqli_query($mysqli, $sqlDisease);

// Fetch data from result set
$data = mysqli_fetch_assoc($rsDisease);

// Fetch disease aliases
if(!empty($data["Orphacode"])){
    $sqlAlias = "SELECT d.* FROM Disease_alias d WHERE d.Disease_Orphacode='" . $data["Orphacode"] . "'";
    $rsAlias = mysqli_query($mysqli, $sqlAlias);

    $aliasIDs = [];
    // Fetch aliases and store them in $aliasIDs array
    while ($alias = mysqli_fetch_assoc($rsAlias)) {
        $aliasIDs[] = $alias['Alias_name'];
    }
}

// Fetch prevalence data
$sqlPrevalence = "SELECT d.* FROM Prevalence d WHERE d.Disease_idDiseases='" . $_REQUEST['idDisease'] . "'";
$rsPrevalence = mysqli_query($mysqli, $sqlPrevalence);

// Fetch symptoms data
$sqlSymptom = "SELECT d.* FROM Symptom d WHERE d.Disease_idDiseases='" . $_REQUEST['idDisease'] . "'";
$rsSymptom = mysqli_query($mysqli, $sqlSymptom);

// Fetch gene data
$sqlGene = "SELECT DISTINCT g.idGene,g.Name FROM Gene_has_Disease d, Gene g 
    WHERE d.Disease_idDiseases='" . $_REQUEST['idDisease'] . "'" .
    " AND g.idGene = d.Gene_idGene";
$rsGene = mysqli_query($mysqli, $sqlGene);

//Fetch association data
$sqlAssoc = "SELECT a.Name, c.Country_name FROM Disease_has_Patient_Association d, Patient_Association a,  Country_has_Patient_Association h, Country c
    WHERE d.Diseases_idDiseases='" . $_REQUEST['idDisease'] . "' " .
    "AND a.idPatient_Associations= d.Patient_Associations_idPatient_Associations ". 
    "AND h.Patient_Association_idPatient_Associations = a.idPatient_Associations ".
    "AND c.idCountry = h.Country_idCountry";
$rsAssoc = mysqli_query($mysqli, $sqlAssoc);


?>

<?= headerDBW() ?>
<div class="content-resultstitle">
    <div class="container_resultstitle">
        <h1 class="results-title">DISEASE | <?= $data["Name"] ?></h1>
    </div>
</div>
<div class="content-results">
    <div class="container_results">
        <h2 class="title_results">General information</h2>
        <?php if(!empty($data["Name"])): ?>  
            <p class="result_item clickable" onclick="window.open('https://www.orpha.net/es/disease/detail/<?php echo urlencode($data["Orphacode"]); ?>', '_blank');">
                <b>OrphaCode:</b> <?= $data["Orphacode"]?>
            </p> 
        <?php endif; ?>
        <?php if(!empty($aliasIDs)): ?>  
            <p class="result_item"><b>Disease alias:</b> <?= implode(", ", $aliasIDs); ?></p> 
        <?php endif; ?>  
        <?php if(!empty($data["Description"])): ?>  
            <p class="result_item"><b>Description:</b> <?=$data["Description"]?></p> 
        <?php endif; ?>  
    </div>
    <div class="container_results">
        <h2 class="title_results">Prevalence</h2>
        <?php if(!empty($rsPrevalence)): ?> 
            <table class="rounded-table" id="dataTablePrevalence">
                <thead>
                    <tr class="row">
                        <th>Source</th>
                        <th>Prevalence Type</th>
                        <th>Prevalence</th>
                        <th>Geographic</th>
                        <th>ValMoy</th>
                        <th>Validation Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($rsPrevalence)): ?>
                        <tr class="row">
                            <td><?=$row["Source"]?></td>
                            <td><?=$row["PrevalenceType"]?></td>
                            <td><?=$row["Prevalence"]?></td>
                            <td><?=$row["Geographic"]?></td>
                            <td><?=$row["ValMoy"]?></td>
                            <td><?=$row["ValidationStatus"]?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div class="container_results">
        <h2 class="title_results">Symptoms</h2>
        <?php if(!empty($rsSymptom)): ?>
            <table class="rounded-table" id="dataTableSymptoms">
                <thead>
                    <tr class="row">
                        <th>Symptom</th>
                        <th>Frequency</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($symptom = mysqli_fetch_assoc($rsSymptom)): ?>
                        <tr class="row">
                            <td><?=ucfirst($symptom["Name"])?></td>
                            <td><?=ucfirst($symptom["Frequency"])?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="container_results">
        <h2 class="title_results">Causal genes</h2>
        <?php if (!empty($rsGene)): ?>
            <?php while ($gene = mysqli_fetch_assoc($rsGene)): ?>
                <p><b><a href="getGene.php?idGene=<?= $gene['idGene'] ?>" target="_blank"><?= ucfirst($gene['Name']) ?></a></b></p>
                <?php
                    $sqlMutation = "SELECT g.* FROM Gene_has_Disease g WHERE g.Disease_idDiseases='" . $_REQUEST['idDisease'] . "'". "AND g.Gene_idGene='" . $gene["idGene"] . "'" . "AND g.idMutation != 0";
                    $rsMutation = mysqli_query($mysqli, $sqlMutation);
                ?>
                <?php if ($rsMutation && mysqli_num_rows($rsMutation) > 0):?>
                    <table class="rounded-table">
                        <thead>
                            <th>Mutation name</th>
                            <th>Mutation type</th>
                            <th>Gene position</th>
                            <th>Protein position</th>
                            <th>Effect</th>
                        </thead>
                        <tbody>
                            <?php while ($mutation = mysqli_fetch_assoc($rsMutation)): ?>
                            <tr class="row">
                                <td><?=$mutation["Mutation_name"]?></td>
                                <td><?=$mutation["Mutation_type"]?></td>
                                <td><?=$mutation["Gene_position"]?></td>
                                <td><?=$mutation["Protein_position"]?></td>
                                <td><?=$mutation["Effect"]?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>


    
    <div class="container_coments">
        <h2 class="title_coments">Comments</h2>
        <form class="comment_item" action="save_comment.php" method="post">
            <input type="hidden" name="idDisease" value="YOUR_PAGE_URL">
            <textarea name="Comment" placeholder="Write your comment referring to <?= $data["Name"] ?> here" required></textarea>
            <button type="submit">Save Comment</button>
        </form>
        <p style="text-align: center;">__________________________________</p>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#dataTablePrevalence').DataTable();
        $('#dataTableSymptoms').DataTable();
    });
</script>
<?= footerDBW()?>