<?php
// display the table if the number of users retrieved was greater than zero
if($num>0){
 
    echo "<table class='table table-hover table-responsive table-bordered'>";
 
    // table headers
    echo "<tr>";
        echo "<th>Имя</th>";
        echo "<th>Фамилия</th>";
        echo "<th>Email</th>";
        echo "<th>Номер телефона</th>";
  		echo "<th>Адрес</th>";
        echo "<th>Уровень доступа</th>";
  		echo "<th>Дата регистрации</th>";
    echo "</tr>";
 
    // loop through the user records
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        // display user details
        echo "<tr>";
            echo "<td>{$firstname}</td>";
            echo "<td>{$lastname}</td>";
            echo "<td>{$email}</td>";
            echo "<td>{$contact_number}</td>";
            echo "<td>{$address}</td>";
            echo "<td>{$access_level}</td>";
          	echo "<td>{$created}</td>";
        echo "</tr>";
        }
 
    echo "</table>";
  	 
    $page_url="read_users.php?";
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