<link rel="icon" href="/../LEAF.png">
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
if (!isset($_SESSION["user"]))
{
	 header("Location: /../index.php");
}

global $tData;

function getIdentified()
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
	$sql = "SELECT * from identified WHERE username = '" . $_SESSION["user"] . "'";				
    $result = mysqli_query($conn, $sql);
	
	$tableData = array();
	$x =0;
	while($row = mysqli_fetch_array($result))
	{
		$tableData[(int)$x][0] = $row['Plantname'];
		$tableData[(int)$x][2] = $row['Date'];
		$tableData[(int)$x][1] = $row['description'];
		$tableData[(int)$x][3] = 'placeholder.jpg';	
		$x += 1;
	}
	return $tableData;
}



//GETS IDENTIFIED PLANT AND TURNS IT INTO 2D ARRAY
$tData = getIdentified();


?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garden</title>
    <link rel="stylesheet" href="environments-style.css">
</head>
<body>

	<div class="topnav">
        <a href="/../home/home.php">Home</a>
        <a href="/../plants.php">PlantList</a>
		<a href="/../account/account.php" >My Account</a>
		<a href="environments.php" class="active">Garden</a>
		<a href="settings.php">Settings</a>
        <!-- Add more navigation links as needed -->
    </div>

    <div class="image-container">
        <!-- Placeholder for a large image -->
        <img src="meadow.jpg" alt="Nature Background">
    </div>

    <div class="plant-container">
        <!-- Plant items will be generated and inserted here by JavaScript -->
    </div>
<script>


	
	//discovered plants example
	const plants = <?php echo json_encode($tData);?>;
   
	//create the dim overlay
const overlay = document.createElement('div');  //the overlay that dims the screen when the popup window is active
overlay.className = 'dim-overlay';
document.body.appendChild(overlay);


const popup = document.createElement('div');    //the popup for plant details

const plantContainer = document.querySelector('.plant-container');

plants.forEach((plant) => {
    const plantItem = document.createElement('div');
    plantItem.classList.add('plant-item');

    //Create an image element
    const plantImage = document.createElement('img');
    plantImage.src = plant[3]; // The image file for the plant
    plantImage.alt = plant[0]; // Alt text as the plant's name
    plantImage.style.width = '100%'; // Make image fill the container
    plantImage.style.height = 'auto'; // Maintain aspect ratio

    //Create a span for plant name, displayed over the image
    const plantName = document.createElement('span');
    plantName.textContent = plant[0];
    plantName.style.position = 'absolute';
    plantName.style.bottom = '5px';
    plantName.style.left = '5px';
    plantName.style.color = 'white';
    plantName.style.fontWeight = 'bold';
    plantName.style.textShadow = '2px 2px 4px #000';

    //Append image and name to the plant item
    plantItem.appendChild(plantImage);
    plantItem.appendChild(plantName);

    plantItem.onclick = () => showPlantDetails(plant[0], 'This is a plant',plant[2], plant[3]);
    plantContainer.appendChild(plantItem);
});


//This function generates a popup window that displays a plant's details
function showPlantDetails(name, description, date, imageUrl) {
    overlay.style.display = 'block';    //shows the overlay that dims the body 
    document.body.style.overflow = 'hidden';    //prevent scrolling on the body
    
    popup.innerHTML = ''; //resets the content for the popup window

    // Create and set up the close button
    const closeButton = document.createElement('button');
    closeButton.className = 'close-btn';
    closeButton.innerHTML = '&times;';
    closeButton.onclick = closePlantDetails;

    popup.className = 'plant-popup';
    popup.innerHTML = `
        <div class="popup-content">
            <button class="close-btn" onclick="closePlantDetails()">&times;</button>
            <h2>${name}</h2>
            <p>${description}</p>
            <p>Discovery Date: ${date}</p>
            <img src="${imageUrl}" alt="${name}" style="width:100%;">
        </div>
    `;
    popup.style.width = '80vw'; //80% of the viewport width
    popup.style.height = '70vh'; //60% of the viewport height
    popup.style.overflow = 'auto';  //makes the popup content scrollable if it is too much for the popup size
    document.body.appendChild(popup);
}

//This function closes the popup window that displays a plant's details
function closePlantDetails(){
    popup.remove(); //deletes the popup window
    overlay.style.display = 'none';    //hides the overlay that dims the body
    document.body.style.overflow = 'auto';    //allows scrolling on the body
}


</script>
</body>
</html>
