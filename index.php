<!DOCTYPE html>
<html>
<head>
  <title>Suggestion Submitter</title>
</head>
<body>
  <h1>Suggestion Submitter</h1>
  <a href="/thesite.html">A site out of the suggestions</a>
  <a href="/archive">Archive</a>
  <form id="suggestionForm" action="submit_suggestion.php" method="POST">
    <label for="suggestion">Suggestion:</label>
    <input type="text" id="suggestion" name="suggestion" required>
    <button type="submit">Submit</button>
  </form>
  <a href="/suggestions.html">Check if your suggestion has been approved</a>
  <?php
    if (isset($_GET['error']) && $_GET['error'] == 1) {
      echo '<p style="color: red;">Your suggestion cannot exceed 400 characters.</p>';
    } else if (isset($_GET['error']) && $_GET['error'] == 2) {
      echo '<p style="color: red;">You have exceeded the rate limit. Please wait a minute before submitting another suggestion.</p>';
    }
  ?>
</body>
</html>
