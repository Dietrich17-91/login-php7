<?php
// display the table if the number of users retrieved was greater than zero
if($num>0){
 
    echo "<table class='table table-hover table-responsive table-bordered'>";
 
    // table headers
    echo "<tr>";
        echo "<th>Имя</th>";
        echo "<th>Фамилия</th>";
        echo "<th>Страна</th>";
        echo "<th>Регион</th>";
  		echo "<th>Город</th>";
        echo "<th>Район</th>";
  		echo "<th>Населённый пункт</th>";
  		echo "<th>Улица</th>";
  		echo "<th>Дом</th>";
    echo "</tr>";
 
    // loop through the user records
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        // display user details
        echo "<tr>";
            echo "<td>{$firstname}</td>";
            echo "<td>{$lastname}</td>";
            echo "<td>{$country}</td>";
            echo "<td>{$region}</td>";
            echo "<td>{$city}</td>";
            echo "<td>{$city_region}</td>";
          	echo "<td>{$city_little}</td>";
          	echo "<td>{$street}</td>";
          	echo "<td>{$house}</td>";
        echo "</tr>";
        }
 
    echo "</table>";
  	 
    $page_url="read_users_filter.php?";
    $total_rows = $user->countAll();
 
    // actual paging buttons
    include_once 'paging.php';
}
 
// tell the user there are no selfies
else{
    echo "<div class='alert alert-danger'>
        <strong>Пользователи не найдены.</strong>
    </div>";
}
?>