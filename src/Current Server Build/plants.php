<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="LEAF.png">
    <meta http-equiv="Cache-control" content="public">
    <style>
        body {
            background-color: lightgreen;
            border-radius: 20px; /* Add border-radius to make edges round/curved */
        }
        .green-text {
            color: green;
        }
        /* Style for rounded input box */
        .rounded-input {
            border-radius: 20px; /* Adjust the border-radius for the desired roundness */
            padding: 10px; /* Adjust padding for spacing inside the input box */
            border: 2px solid #008000; /* Green border */
            background-color: #f0fff0; /* Light green background */
            outline: none; /* Remove outline */
            transition: border-color 0.3s ease; /* Smooth transition for border color change */
        }
        /* Hover effect for rounded input box */
        .rounded-input:hover {
            border-color: #00ff00; /* Darker green border on hover */
        }
        /* Focus effect for rounded input box */
        .rounded-input:focus {
            border-color: #006400; /* Dark green border on focus */
        }
        /* Style for rounded button */
        .rounded-button {
            border-radius: 20px; /* Adjust the border-radius for the desired roundness */
            padding: 10px 20px; /* Adjust padding for spacing inside the button */
            border: 2px solid #008000; /* Green border */
            background-color: #f0fff0; /* Light green background */
            color: #008000; /* Green text color */
            cursor: pointer; /* Change cursor to pointer on hover */
            outline: none; /* Remove outline */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition for background color and text color change */
        }
        /* Hover effect for rounded button */
        .rounded-button:hover {
            background-color: #00ff00; /* Darker green background on hover */
            color: #ffffff; /* White text color on hover */
        }
        /* Style for rounded table headers */
        th {
            border-radius: 20px; /* Adjust the border-radius for the desired roundness */
            background-color: #4dff4d; /* Light green background */
            padding: 10px; /* Adjust padding for spacing inside the table header */
            text-align: center; /* Center-align text */
        }
		
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
  position: fixed;
  top: 0;
  width: 100%;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover:not(.active) {
  background-color: #111;
}



		
		
    </style>
</head>
<body>
		
	<ul>
		<li><a href="/../home/home.php">Home</a></li>
		<li><a href="/../plants.php">PlantList</a></li>
		<li><a href="/../account/account.php" >My Account</a></li>
		<li><a href="/../environments/environments.php" >Garden</a></li>
		<li><a href="/../environments/settings.php">Settings</a></li>
	</ul>



<?php
ini_set('session.cache_limiter', 'public');
session_cache_limiter(false);
session_start();
if (!isset($_GET['page'])) 
{
    $_GET['page'] = 1;
}
error_reporting(E_ERROR | E_PARSE);



function searchPlant($url, $plantName)
{
    $url .= $plantName;

    if (array_key_exists('next', $_POST)) {
        $_GET['page'] += 1;
    }
    if (array_key_exists('previous', $_POST)) {
        $_GET['page'] -= 1;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "my_password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    $output = curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $info = curl_getinfo($ch);
    curl_close($ch);
    $array = json_decode($output, true);
    $vals = $array['data'];

    echo '<h1>SHOWING RESULTS FOR: "' . $_POST["sBox"] . '"<br> </h1>';
    if (sizeof($vals) < 1) {
        echo "<br>NO RESULTS FOUND!<br>";
    } else {
        echo "FOUND A TOTAL OF " . sizeof($vals) . " RESULTS<br>";
    }
	
    echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
    echo '<input type="submit" name="previous" value="PREVIOUS PAGE" class="rounded-button">';
    echo '<input type="submit" name="next" value="NEXT PAGE" class="rounded-button">';
    echo "</form>";

   echo "<center><table cellspacing='3' bgcolor='#90EE90'>";
    echo "<tr><th><h2>IMAGE</h2></th><th><h2>COMMON NAME</h2></th><th><h2>SCIENTIFIC NAME</h2></th></tr>";


    for ($x = 0; $x < sizeof($vals); $x++) {
        echo "<tr bgcolor='#90EE90'>";

        if (isset($vals[$x]['default_image']['original_url'])) {
            echo "<td><img src=" . $vals[$x]['default_image']['original_url'] . " style='width:512px;height:512px;'></td>";
        } else {
            echo "<td>NO IMAGE AVAILABLE!</td>";
        }
        echo "<td align='center'><h1>" . $vals[$x]['common_name'] . "</h1></td>";
        echo "<td align='center'><h1>" . $vals[$x]['scientific_name'][0] . "</h1></td>";
        echo "</tr>";
    }
    echo "</table></center>";

    echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
    echo '<input type="submit" name="previous" value="PREVIOUS PAGE" class="rounded-button">';
    echo '<input type="submit" name="next" value="NEXT PAGE" class="rounded-button">';
    echo "</form>";
}

function call($url)
{
    if ($_GET['page'] < 1 && isset($_GET['page'])) {
        $_GET['page'] = 1;
    }
    if (array_key_exists('next', $_POST)) {
        $_GET['page'] += 1;
    }
    if (array_key_exists('previous', $_POST)) {
        $_GET['page'] -= 1;
    }

    $url .= $_GET['page'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "my_password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    $output = curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $info = curl_getinfo($ch);
    curl_close($ch);
    $array = json_decode($output, true);
    $vals = $array['data'];
    $cName = $vals[0];

    echo "<h1>LIST OF PLANT SPECIES: </h1>";

    echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
    echo '<input type="submit" name="previous" value="PREVIOUS PAGE" class="rounded-button">';
    echo '<input type="submit" name="next" value="NEXT PAGE" class="rounded-button">';
    echo "</form>";


    echo "<center><table cellspacing='3' bgcolor='#ffffff'>";
    echo "<tr><th><h2>IMAGE</h2></th><th><h2>COMMON NAME</h2></th><th><h2>SCIENTIFIC NAME</h2></th></tr>";

    for ($x = 0; $x < sizeof($vals); $x++) {
        echo "<tr bgcolor='#90EE90'>";

        if (isset($vals[$x]['default_image']['original_url'])) {
            echo "<td><img src=" . $vals[$x]['default_image']['original_url'] . " style='width:512px;height:512px;'></td>";
        } else {
            echo "<td>NO IMAGE AVAILABLE!</td>";
        }
        echo "<td align='center'><h1>" . $vals[$x]['common_name'] . "</h1></td>";
        echo "<td align='center'><h1>" . $vals[$x]['scientific_name'][0] . "</h1></td>";
        echo "</tr>";
    }
    echo "</table></center>";

    echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
    echo '<input type="submit" name="previous" value="PREVIOUS PAGE" class="rounded-button">';
    echo '<input type="submit" name="next" value="NEXT PAGE" class="rounded-button">';
    echo "</form>";


}
echo '<br><br><br><br>';
echo "<form action='plants.php?page=" . $_GET['page'] . "'method='post'>";
echo '<input type="text" name="sBox" class="rounded-input">'; // Change input type and add class for styling
echo '<input type="submit" name="SEARCH" value="SEARCH PLANT" class="rounded-button">'; // Change input type and add class for styling
echo "</form>";

if (isset($_POST["sBox"])) {
    if ($_POST["sBox"] != "") {
        searchPlant("https://perenual.com/api/species-list?key=sk-69p865beb721925be4020&q=", $_POST["sBox"]);
        echo "<br>";
    } 
	else 
	{
        header("Location: plants.php?page=1");
    }
    echo "<a href='plants.php?page=1'> RETURN TO LIST </a>";
} 
else if(isset($_GET['search']))
{
	if($_GET['search'] != "")
	{
		searchPlant("https://perenual.com/api/species-list?key=sk-69p865beb721925be4020&q=", $_GET['search']);
		echo "<br>";
	}
	else
	{
		header("Location: plants.php?page=1");
	}
	echo "<a href='plants.php?page=1'> RETURN TO LIST </a>";
}
else 
{
    //alphabetical
    //call("https://perenual.com/api/species-list?key=sk-69p865beb721925be4020&order=asc&page=", 1);

    //default
    call("https://perenual.com/api/species-list?key=sk-69p865beb721925be4020&page=", 1);
}
?>
</body>
</html>
