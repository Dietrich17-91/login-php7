<div class="col-md-12">
  <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"])  ?>' method='post' id='filter'>
    <div class="form-group">
    	<input type='text' name='search_value' class='form-control' placeholder='Что будем искать?'>
    </div>
    <div class="form-group">
    	<input type='submit' name='search' class='btn btn-lg btn-primary btn-block' value='Фильтровать'>
    </div>
  </form>
</div>