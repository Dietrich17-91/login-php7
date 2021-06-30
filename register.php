<?php
// core configuration
include_once "config/core.php";
 
// set page title
$page_title = "Зарегистрироваться";
 
// include login checker
include_once "login_checker.php";
 
// include classes
include_once 'config/database.php';
include_once 'objects/user.php';
include_once "libs/php/utils.php";
 
// include page header HTML
include_once "layout_head.php";
 
echo "<div class='col-md-12'>";
 
    // registration form HTML will be here
    // code when form was submitted will be here
    // if form was posted
if($_POST){
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // initialize objects
    $user = new User($db);
    $utils = new Utils();
 
    // set user email to detect if it already exists
    $user->email=$_POST['email'];
 
    // check if email already exists
    if($user->emailExists()){
        echo "<div class='alert alert-danger'>";
            echo "Указанный адрес электронной почты уже зарегистрирован. Пожалуйста, попробуйте еще раз или <a href='{$home_url}login'>войдите.</a>";
        echo "</div>";
    }
 
    else{
        // create user will be here
        // set values to object properties
$user->firstname=$_POST['firstname'];
$user->lastname=$_POST['lastname'];
$user->contact_number=$_POST['contact_number'];
$user->address=$_POST['address'];
$user->password=$_POST['password'];
      
$user->country=$_POST['country'];
$user->region=$_POST['region'];
$user->city=$_POST['city'];
$user->city_region=$_POST['city-region'];
$user->city_little=$_POST['city-little'];
$user->street=$_POST['street'];
$user->house=$_POST['house'];
      
$user->access_level='Admin'; // Customer or Admin
$user->status=0;

// access code for email verification
$access_code=$utils->getToken();
$user->access_code=$access_code;
 
// create the user
if($user->create()){
 
    // send confimation email
    $send_to_email=$_POST['email'];
    $body="Привет {$send_to_email}.<br /><br />";
    $body.="Кликните по ссылке, чтобы подтвердить свой адрес электронной почты и войти в систему: {$home_url}verify?access_code={$access_code}";
    $subject="Подтверждение Email";
 
    if($utils->sendEmailViaPhpMail($send_to_email, $subject, $body)){
        echo "<div class='alert alert-success'>
            Ссылка для подтверждения была отправлена на вашу электронную почту. Кликните по ссылке, чтобы войти.
        </div>";
    }
 
    else{
        echo "<div class='alert alert-danger'>
            Пользователь был создан, но не получилось отправить письмо с подтверждением. Пожалуйста, свяжитесь с администратором.
        </div>";
    }
 
    // empty posted values
    $_POST=array();
 
}else{
    echo "<div class='alert alert-danger' role='alert'>Невозможно зарегистрироваться. Пожалуйста, попробуйте еще раз.</div>";
}
    }
}
?>
<form action='register.php' method='post' id='register'>
 	<input id="country" name="country" type="hidden" value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country'], ENT_QUOTES) : "";  ?>">
    <input id="region" name="region" type="hidden" value="<?php echo isset($_POST['region']) ? htmlspecialchars($_POST['region'], ENT_QUOTES) : "";  ?>">
    <input id="city" name="city" type="hidden" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city'], ENT_QUOTES) : "";  ?>">
    <input id="city-region" name="city-region" type="hidden" value="<?php echo isset($_POST['city-region']) ? htmlspecialchars($_POST['city-region'], ENT_QUOTES) : "";  ?>">
    <input id="city-little" name="city-little" type="hidden" value="<?php echo isset($_POST['city-little']) ? htmlspecialchars($_POST['city-little'], ENT_QUOTES) : "";  ?>">
    <input id="street" name="street" type="hidden" value="<?php echo isset($_POST['street']) ? htmlspecialchars($_POST['street'], ENT_QUOTES) : "";  ?>">
    <input id="house" name="house" type="hidden" value="<?php echo isset($_POST['house']) ? htmlspecialchars($_POST['house'], ENT_QUOTES) : "";  ?>">
    <table class='table table-responsive'>
 
        <tr>
            <td class='width-30-percent'>Имя</td>
            <td><input type='text' name='firstname' class='form-control' required value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
 
        <tr>
            <td>Фамилия</td>
            <td><input type='text' name='lastname' class='form-control' required value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
 
        <tr>
            <td>Номер телефона</td>
            <td><input type='text' name='contact_number' class='form-control' required value="<?php echo isset($_POST['contact_number']) ? htmlspecialchars($_POST['contact_number'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
 
        <tr>
            <td>Адрес</td>
            <td><input id="suggest" type='text' name='address' class='form-control' required value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address'], ENT_QUOTES) : "";  ?>" /><br><p id="notice">Адрес не найден</p><a href="javascript:void(0)" id="address-btn">Проверка адреса</a><div id="map"></div></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type='email' name='email' class='form-control' required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : "";  ?>" /></td>
        </tr>
 
        <tr>
            <td>Пароль</td>
            <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button id="reg-btn" type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span> Зарегистрироваться
                </button>
            </td>
        </tr>
 
    </table>
</form>

<?php
echo "</div>";
// include page footer HTML
include_once "layout_foot.php";
?>