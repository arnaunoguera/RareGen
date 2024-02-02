<?php
/*
 * index.php
 * main form
 */
// Loading global variables and DB connection

require "globals.inc.php";

// end initialization ===================================================================================
?>

<?= headerDBW("PDB Browser rev. 2021")?>
<!-- Main Form follows-->
    <div class="searchbar">
        <form action="search.php" method="get">
            <input type="text" name="query" placeholder="Search..." value="<?php echo htmlspecialchars($query); ?>">
            <select name="type">
                <option value="genes" <?php if ($type == 'genes') echo 'selected'; ?>>Genes</option>
                <option value="chromosomes">Chromosomes</option>
                <option value="diseases">Diseases</option>
                <option value="organizations">Organizations</option>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="results">
        <?php
        $query = $_GET['query'];
        $type = $_GET['type'];

        // Perform the search for the query here
        // For example, you could use a database query to search for genes that match the query
        $results = searchForGenes($query, $type);

        // Display the search results
        if (count($results) > 0) {
            echo "<h2>Search Results:</h2>";
            echo "<ul>";
            foreach ($results as $result) {
                echo "<li><a href='gene.php?id=" . $result['id'] . "'>" . htmlspecialchars($result['name']) . "</a></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No results found.</p>";
        }
        ?>
    </div>

<?= footerDBW()?>