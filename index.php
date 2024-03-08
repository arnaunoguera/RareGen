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
// end initialization ===================================================================================
?>

<?= headerDBW()?>
    <!-- BODY -->
    <div class="content">
      <form name="MainForm" action="search.php" method="POST" enctype="multipart/form-data">
      <div class="search-bar">
        <div class="search-icon"><img src="images/search_icon.png" alt="Search icon"></div>
        <input type="text" placeholder="Search..." name="search" size="4000"/>
        <select id="searchCategory" name="searchCategory" class="search-dropdown">
          <option value="all">All Fields</option>
          <option value="gene">Gene</option>
          <option value="disease">Disease</option>
          <option value="organization">Organization</option>
        </select>
        <button type="submit" class = "custom-search-button">Search</button>
      </div>
      </form>
      <div class="info">
        <h3>
          <p>To search for a specific gene, type its name in the search bar and click on the GENE button.</p><br>
          <p> To search for a specific disease, type its name in the search bar and click on the DISEASE button.</p><br>
          <p> To search for a specific organization, type its name in the search bar and click on the ORGANIZATION button.</p>
        </h3>
      </div>
      <!-- Link to another page -->
      <!-- <a href="/html/search.html">Go to SEARCH</a>-->

    </div>
    <!-- FOOTER -->
 <?= footerDBW()?>   
    