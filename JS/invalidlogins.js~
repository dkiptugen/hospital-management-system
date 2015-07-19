function reloadNames() {
    var url = "../../INCLUDES/MODULES/accounts.php?t=" + (new Date()).getTime(); //kills browser cache
    // This will make a request to names.php (code above) and put the resulting
    // text (which happens to be valid html) into the names div.
    jQuery("#invalid_log").load(url);
}
jQuery(function() {
    // Schedule the reloadNames function to run every 5 seconds.
    // So, the list of names will be updated every 5 seconds.
    setInterval(reloadNames, 3000);
});
