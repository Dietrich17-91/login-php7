<?php
// core configuration
include_once "../config/core.php";
 
// check if logged in as admin
include_once "login_checker.php";
 
// include classes
include_once '../config/database.php';
include_once '../objects/user.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$user = new User($db);
 
// set page title
$page_title = "Фильтр";
 
// include page header HTML
include_once "layout_head.php";

include_once "filter_form.php";

echo "<div class='col-md-12'>";
    $search_value = $_POST['search_value'];
    // read all users from the database
    $stmt = $user->filterAll($from_record_num, $records_per_page, $search_value);

    // count retrieved users
    $num = $stmt->rowCount();
 
    // to identify page for paging
    $page_url="read_users_filter.php?";
 
    // include products table HTML template
    include_once "read_users_template_filter.php";

echo "</div>";
 
// include page footer HTML
include_once "layout_foot.php";
?>