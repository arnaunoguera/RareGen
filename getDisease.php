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

// Fetch disease data
$sqlPrevalence = "SELECT d.* FROM Prevalence d WHERE d.Disease_idDiseases='" . $_REQUEST['idDisease'] . "'";
$rsPrevalence = mysqli_query($mysqli, $sqlPrevalence);

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
        
    </div>
    <div class="container_results">
        <h2 class="title_results">Prevalence</h2>
        <?php if(!empty($rsPrevalence)): ?> 
            <table class="rounded-table">
                <tbody> 
                    <tr class="row">
                        <td>Source</td>
                        <td>Prevalence Type</td>
                        <td>Prevalence</td>
                        <td>Geographic</td>
                        <td>ValMoy</td>
                        <td>Validation Status</td>
                    </tr>
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

<div class="container_end_results">
</div>
<?= footerDBW()?>