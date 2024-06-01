<link rel="icon" href="/../LEAF.png">
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
if (!isset($_SESSION["user"]))
{
	 header("Location: /../index.php");
}




$name_S; 
$email_S; 
$age_S; 
$country_S; 
$bio_S; 
$language_S; 
$aType_S; 
$TFA_S; 
$update_S;



function updateUserProfile($name, $email, $age, $location, $bio)
{
	$servername = "localhost";
	$username = "root";		
	$password = "";
	$db = "users";
	$conn = mysqli_connect($servername, $username, $password, $db);
	if (!$conn) 
	{
		die("ERROR PLEASE TRY AGAIN LATER... : " . mysqli_connect_error());
	}
	$sql = "UPDATE details SET name = '" . $name . "' , email = '" . $email . "' , age = '" . $age . "' , location = '" . $location . "' , bio = '" . $bio . "' WHERE username = '" . $_SESSION["user"] . "'";					   
    if ($conn->query($sql) == TRUE){}
	header("Refresh:0");
}

function updateUserSettings($lang, $aType, $updates, $TFA)
{
	$servername = "localhost";
	$username = "root";		
	$password = "";
	$db = "users";
	$conn = mysqli_connect($servername, $username, $password, $db);
	if (!$conn) 
	{
		die("ERROR PLEASE TRY AGAIN LATER... : " . mysqli_connect_error());
	}
	$sql = "UPDATE setting SET language = '" . $lang . "' , accType = '" . $aType . "' , subscribed = '" . $updates . "' , 2FA = '" . $TFA . "' WHERE username = '" . $_SESSION["user"] . "'";				   
    if ($conn->query($sql) == TRUE){}	
	
}

function getSettings()
{
	global $name_S, $email_S, $age_S, $country_S, $bio_S, $language_S, $aType_S, $TFA_S, $update_S;
	$servername = "localhost";
	$username = "root";		
	$password = "";
	$db = "users";
	$conn = mysqli_connect($servername, $username, $password, $db);
	if (!$conn) 
	{
		die("ERROR PLEASE TRY AGAIN LATER... : " . mysqli_connect_error());
	}
	$sql = "SELECT * from details WHERE username = '" . $_SESSION["user"] . "'";				
    $result = mysqli_query($conn, $sql);
	$result = mysqli_fetch_row($result);		
	$name_S = $result[1];		
	$email_S = $result[2];		
	$age_S = $result[3];		
	$country_S = $result[4];		
	$bio_S = $result[5];	
	
	$sql = "SELECT * from setting WHERE username = '" . $_SESSION["user"] . "'";				
    $result = mysqli_query($conn, $sql);
	$result = mysqli_fetch_row($result);
	$language_S = $result[1];		
	$aType_S = $result[2];		
	$TFA_S = $result[3];		
	$update_S = $result[4];
	
}


getSettings();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Hugger</title>
    <link rel="stylesheet" href="settings-style.css">
</head>
<body>
    <header>
        <img src="Tree-Hugger-Co-Logo.png" alt="Tree Hugger" id="logo">
        <div id="company-name">
            <span>Tree</span>
            <span>Hugger</span>
        </div>
        <nav>
            <button class="nav-button" onclick="location.href='/../home/home.php';">Home</button>
			<button class="nav-button" onclick="location.href='/../plants.php';">Plant List</button>
			<button class="nav-button" onclick="location.href='/../account/account.php';">My Account</button>
			<button class="nav-button" onclick="location.href='environments.php';">Garden</button>

        </nav>
    </header>
    <main>
        <!-- Can pre-load fields with current account details -->
        <form id="user-settings-form" method = "post">
            <h1>Account Details</h1>
            <div class="setting-item">
                <label for="name">Name:</label>
				<?php
				echo '<input type="text" id="name" name="name" value =' . $name_S . '>' ;
				?>       
            </div>
            <div class="setting-item">
                <label for="email">Contact:</label>
				<?php
				echo '<input type="text" id="email" name="email" value =' . $email_S . '>';
				?> 
            </div>
            <div class="setting-item">
                <label for="age">Age:</label>
				<?php
				echo '<input type="number" id="age" name="age" min="0" value =' . $age_S . '>';
				?> 
            </div>
            <div class="setting-item">
                <label for="city">Country:</label>
				<?php
				echo '<input type="text" id="city" name="city" value =' . $country_S . '>';
				?>
            </div>
            <div class="setting-item">
                <label for="bio">Account Bio:</label>
                
				<?php
				echo '<textarea id="bio" name="bio" rows="4" cols="50">'.$bio_S.'</textarea>';
				?>
            </div>
            <div class="setting-item">
            <button type="submit">UPDATE</button>
            </div>
			<?php
				if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["bio"])&& isset($_POST["age"])&& isset($_POST["city"]))
				{
					updateUserProfile($_POST["name"],$_POST["email"],$_POST["age"],$_POST["city"],$_POST["bio"]);
				}
			?>
        </form>

		<h1>Account Settings</h1>

		<form id="settings" method = "post">
		<div class="setting-item">
			<label for="languages">Language:</label>
			<select name="languages" id="languages">
			<option value="english">English</option>
			</select>
			
			<br>
			
			<label for="accType">Account Visibility:</label>
			<select name="accType" id="accType">
			<option value="public">Public</option>
			<option value="private">Private</option>
			</select>
			
			<br>
			
			<label for="eUpdate">Receive Email Updates:</label>
			<?php
			if($update_S == 1)
			{
				echo '<input type="checkbox" name="eUpdate" checked>';
			}
			else
			{
				echo '<input type="checkbox" name="eUpdate">';
			}
			?>

			
			<label for="2FA">Two Factor Authentication:</label>
			<?php
			if($TFA_S == 1)
			{
				echo '<input type="checkbox" name="2FA" checked>';
			}
			else
			{
				echo '<input type="checkbox" name="2FA">';
			}
			?>
			<br>
			
            <button type="submit">Apply</button>
		</div>
			<?php
				$check1;
				$check2;
				
				if(isset($_POST["2FA"]))
				{
					$check1 = 1;
				}
				else
				{
					$check1 = 0;
				}
				if(isset($_POST["eUpdate"]))
				{
					$check2 = 1;
				}
				else
				{
					$check2 = 0;
				}
				
				if (!isset($_POST["language"]) && !isset($_POST["accType"]))
				{
					updateUserSettings($language_S,$aType_S,$check2,$check1);
				}
				else if (!isset($_POST["language"]) && isset($_POST["accType"]))
				{
					updateUserSettings($language_S,$_POST["accType"],$check2,$check1);
				}
				else if (isset($_POST["language"]) && !isset($_POST["accType"]))
				{
					updateUserSettings($language_S,$aType_S,$check2,$check1);
				}
				else
				{
					updateUserSettings($_POST["language"],$_POST["accType"],$check2,$check1);
				}
			
			?>
		</form>
		<?php
			echo date("m/d/Y") ;
		?>
        
    </main>
</body>
</html>
