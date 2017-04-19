// URL String
//rootURL     = "http://csis.svsu.edu/";
rootURL     = "http://csis.svsu.edu/";
//userNameURL = "~alpero";
userNameURL = "~ajcoldwe/cis355WI17";
ScheduleAppURL = "/ScheduleApp/";
URL         = rootURL + userNameURL + ScheduleAppURL;

// Get ID from URL
function getID() {
    id = window.location.search.substring(1);
    id = id.split("=");
    return id[1];
}