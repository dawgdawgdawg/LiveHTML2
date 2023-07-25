<?php
session_start();

$maxCharLimit = 400;
$maxSuggestionsPerMinute = 5;
$suggestion = $_POST['suggestion'];
$suggestion = strip_tags($suggestion);
if (strlen($suggestion) > $maxCharLimit) {
    header('Location: index.php?error=1');
    exit();
}
$currentTime = time();
if (!isset($_SESSION['suggestion_timestamps'])) {
    $_SESSION['suggestion_timestamps'] = array();
}

$suggestionTimestamps = $_SESSION['suggestion_timestamps'];
$oneMinuteAgo = $currentTime - 60;
$suggestionTimestamps = array_filter($suggestionTimestamps, function ($timestamp) use ($oneMinuteAgo) {
    return $timestamp > $oneMinuteAgo;
});
if (count($suggestionTimestamps) >= $maxSuggestionsPerMinute) {
    header('Location: index.php?error=2');
    exit();
}
$suggestionTimestamps[] = $currentTime;
$_SESSION['suggestion_timestamps'] = $suggestionTimestamps;
$suggestions = retrieveSuggestions();
if (!in_array($suggestion, $suggestions)) {
    $uniqueID = count($suggestions) + 1;
    $suggestions[] = '#' . $uniqueID . ': ' . $suggestion . '<br/>';
    storeSuggestions($suggestions);
}
header('Location: index.php');
exit();
?>




<?php
function storeSuggestions($suggestions) {
    $formattedSuggestions = implode(PHP_EOL, $suggestions);
    file_put_contents('suggestions.html', $formattedSuggestions);
}
function retrieveSuggestions() {
    $suggestionsString = file_get_contents('suggestions.html');
    $suggestions = explode(PHP_EOL, $suggestionsString);
    $suggestions = array_filter($suggestions);
    return $suggestions;
}
?>
