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
      <form name="MainForm" action="search.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
      <div class="search-bar">
        <div class="search-icon"><img src="images/search_icon.png" alt="Search icon"></div>
        <input type="text" placeholder="Search..." name="search" size="4000"/>
        <p id="Error" style="color: red; width: 100%;"></p> 
        <select id="searchCategory" name="searchCategory" class="search-dropdown">
          <option value="all">All Fields</option>
          <option value="gene">Gene</option>
          <option value="disease">Disease</option>
          <option value="organization">Organization</option>
        </select>
        <button type="submit" class = "custom-search-button">Search</button>
      </div>
      </form>
      <script>
        function validateForm() {
          var inputField = document.getElementsByName('search')[0];
          var inputValue = inputField.value.trim();

          if (inputValue.length < 3) {
            alert('Please enter at least 3 characters in the search field.');
            return false;
          }

          return true;
        }
      </script>

      <div class="info">
        <h3>
          <p> Welcome to Raregen! A database of rare diseases where you can find information about the symptoms, the prevalence, and the diagnosis methods, among other aspects, for each one of the illnesses.</p><br>
          <p> Moreover, this page also contains information on the related genes, if known, and detected mutations that may have been found causal to these syndromes. </p><br>
          <p> But it doesn’t end there, if you are a patient searching for information about a syndrome you have been diagnosed with, you might be glad to learn that this web page also contains information about different patient associations advocating for patients. </p><br>
          <p> To search for any topic, you can just write on the search bar. Next to it, you will see a dropdown with different options: “All fields”, “Gene”, “Disease”, and “Organization”. If you want to obtain all the information about a given illness, you can use the “All fields” option and will get all the information relating to it. However, if you are more interested in something more specific, like a given gene, you can choose that option to obtain a more selected search.</p><br>
          <p> We hope that your search proves to be informative and educative!</p>
        </h3>
      </div>

    </div>
    <!-- FOOTER -->
 <?= footerDBW()?>   
    