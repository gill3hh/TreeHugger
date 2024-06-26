<link rel="icon" href="/../LEAF.png">
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
if (!isset($_SESSION["user"]))
{
	header("Location: /../index.php");
}
function logout()
{
	if (isset($_SESSION["user"]))
	{
		session_destroy();
	}
	header("Location: /../index.php");
}
if (isset($_GET['logout']))
{
	logout();
}

function insert($pName,$date,$description)
{
	//CONNECT TO DATABASE
    $servername = "localhost";
	$username = "root";		
	$password = "";
	$db = "users";
	$conn = mysqli_connect($servername, $username, $password, $db);
	if (!$conn) 
	{
		die("ERROR PLEASE TRY AGAIN LATER... : " . mysqli_connect_error());
	}
			
	$sql = "INSERT INTO `identified`(`username`, `Plantname`, `Date`, `description`) VALUES ('". $_SESSION["user"] . "','". $pName. "','". $date. "','" . $description. "')";				
		   

	//CREATES ACCOUNT IF IT IS AVAILABLE
    if ($conn->query($sql) == TRUE) 
	{
	
	}
	else 
	{
		echo "ERROR SAVING PLANT";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="sass/style.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <title>Plant Identification Tool</title>
    <style>
        #loadingIndicator {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
        .align-centre{text-align: center;}

        

        #cameraButton{
            margin-top: 320px;
            display: block;
            width: 50%;
            height: 50px;
            border: none;
            outline: none;
            border-radius: 25px;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            background: linear-gradient(135deg,green 0%,orange 100%); 
         }
         #captureButton{
            margin-top: 320px;
            display: block;
            width: 150%;
            height: 50px;
            border: none;
            outline: none;
            border-radius: 25px;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            background: linear-gradient(135deg,green 0%,orange 100%);

         }

         
         
         
         

         #cameraFeed{
            position: absolute;
            margin-top: 40px;
            margin-left:385px;
            width: 250px;
            height: 350px;
            top:0;
            left:0;
            display: none;
         }
         
         
        
        
            
         



        
      </style>
</head>
<body>
    <main>
        <nav>
            <div class="logo">
                <embed src="Tree Hugger.png" alt="Logo" class="logo-image" style="margin-left: -10%">
                <span>Tree<br>Hugger</span>
            </div>
            <a href="home.php" class="active">Home</a>
            <a href="/../plants.php"> PlantList </a>
            <a href="/../Account/account.php"> User Account </a>
            <a href="/../environments/environments.php">Garden </a>
            <a href="environments.php" target="_parent">Environments</a>
            <a href="/../environments/settings.php"> Settings</a>
			<a href="home.php?logout=1">Logout</a>
        </nav>
        <aside class="plant-gallery">
            <embed src="plant1.png" alt="Plant 1" class="plant-left">
            <embed src="plant2.png" alt="Plant 2" class="plant-right">
        </aside>
        <section class="newitementry">
            <form id="entryForm">
                <input id="myInput" type="text" name="plantSearch" placeholder="search plants" size="40">
                <button id="search button" type = "submit" class="button" title="search new plants" aria-label="search for plants" tabindex="0">⌕</button>  
				<?php
				if (isset($_GET['plantSearch']))
				{
					if ($_GET['plantSearch'] != '')
					{
						header("Location: /../plants.php?sBox='0'&search=" . $_GET['plantSearch']);
					}
				}
				
				?>
            </form>
            <section class="listcontainer">
                <div class="listTitle">
                    <h1 class ="align-centre">Upload your image</h1>
                </div>
                <hr />
                <div id="listItems">
                    <div class="item">
                        <div class="container">
                            <div class="wrapper">
                                <div class="image"> 
                                    <img src="" alt="">
                                </div>
                                <div class="content">
                                    <div class="icon">
                                        <embed src="plant-icon.png" class="fas fa-cloud-upload-alt" height="80px" color="green"></i>
                                    </div>
                                    <div class="text">
                                        No file chosen, yet!
                                    </div>
                                </div>
                                <div id="cancel-btn">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="file-name">
                                    File name here
                                </div>
                            </div>
                            
                            <button onclick="defaultBtnActive()" id="custom-btn">Choose a file</button>
                            <input id="default-btn" type="file" hidden>
                            
                        </div>
                        <button id ="cameraButton">Open Camera</button>
                        <div id ="videoContainer" style="display:none;">
                           <video id ="cameraFeed" autoplay style = "display:none;"></video>
                           <button id ="captureButton" >Capture Image</button>
                        
                        </div>
                        
                        <div class="loading-circle" id="loadingCircle"></div>
                        <div id="predictions">
                            <div id="plantInfo" style="display: none;"></div>
                            <div id="identificationMessage"></div>
                            <div id ="plantCommonName"></div>
                            
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </main>
    <script>
		
      document.addEventListener("DOMContentLoaded", function() {
          const defaultBtn = document.getElementById("default-btn");
          const customBtn = document.getElementById("custom-btn");
          const img = document.querySelector(".wrapper img");
          const wrapper = document.querySelector(".wrapper");
          const filename = document.querySelector(".file-name");
          const cancelBtn = document.getElementById("cancel-btn");
          const plantInfoDiv = document.getElementById("plantInfo");
          const loadingCircle = document.getElementById("loadingCircle");
          const identificationMessage = document.getElementById("identificationMessage");
          const retryButton = document.getElementById("retrybutton");
          const plantCommonName = document.getElementById("plantCommonName");
          document.getElementById("cameraButton").addEventListener("click", function() {
            var plantInfoDiv = document.getElementById('plantInfo');
            var identificationMessagediv = document.getElementById('identificationMessage');
            var plantCommonNameDiv = document.getElementById('plantCommonName');

            plantInfoDiv.innerText = '';
            plantCommonNameDiv.innerText = '';
            plantInfoDiv.style.display = 'none';

            identificationMessagediv.innerText = '';
            identificationMessagediv.style.display = 'none';

            
              document.getElementById("videoContainer").style.display = "block";
              document.getElementById("cameraFeed").style.display = "block";
              document.getElementById("captureButton").style.display = "block";
              

              navigator.mediaDevices.getUserMedia({ video: true })
              .then(function(stream) {
                  var video = document.getElementById('cameraFeed');
                  video.srcObject = stream;
                  video.play();
              })
              .catch(function(error) {
                  console.error('Error accessing camera:', error);
                  document.getElementById("identificationMessage").innerText = 'Error accessing camera: ' + error.message;
                  identificationMessagediv.innerText = 'Error accessing camera:' + error.message;
                  identificationMessagediv.style.display = 'block';
              });
              this.style.display = 'none';
              document.getElementById('captureButton').style.display = 'inline-block';
          });

          document.getElementById("captureButton").addEventListener("click", function() {
              var video = document.getElementById('cameraFeed');
              var canvas = document.createElement('canvas');
              canvas.width = video.videoWidth;
              canvas.height = video.videoHeight;
              var context = canvas.getContext('2d');
              context.drawImage(video, 0, 0, canvas.width, canvas.height);

              video.pause();
              video.srcObject.getTracks().forEach(function(track) {
                  track.stop();
              });
              video.style.display = 'none';
              this.style.display = 'none';
              document.getElementById('cameraButton').style.display = 'inline-block';

              var imageUrl = canvas.toDataURL('image/jpeg');
              identifyPlant(imageUrl);
			  <?php
			   if (isset($_COOKIE["pCook"])) 
			   {
				 insert($_COOKIE["pCook"], date("m/d/Y"), "This is a plant");
			   }
			  ?>
          });





          
      
          customBtn.addEventListener("click", function(event) {
              event.preventDefault();
              defaultBtn.click();
          });
      
          defaultBtn.addEventListener("change", function() {
              const file = this.files[0];
              if (file) {
                  const reader = new FileReader();
                  reader.onload = function() {
                      img.src = reader.result;
                      wrapper.classList.add("active");
                      filename.textContent = file.name;
                      identifyPlant(file); // Update to send the file directly
                  };
                  reader.readAsDataURL(file);
              }
          });
      
          cancelBtn.addEventListener("click", function() {
              img.src = "";
              wrapper.classList.remove("active");
              filename.textContent = "No file chosen, yet!";
              defaultBtn.value = "";
              plantInfoDiv.style.display = "none";
              loadingCircle.style.display = "none";
              identificationMessage.innerText = "";
          });
      
          function identifyPlant(file) {
              loadingCircle.style.display = "block";
              identificationMessage.innerText = "";
              const formData = new FormData();
              formData.append("images", file); // Ensure the field matches the API expectation, typically 'images'
      
              fetch("https://plant.id/api/v3/identification", {
                  method: 'POST',
                  headers: {
                      "Api-Key": "AmMB3jE61y72gumlOmAxOmBTo1lJ3rsOEFAAuX72h9tQMKKmU3"
                  },
                  body: formData
              }).then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not ok ' + response.statusText);
                  }
                  return response.json();
              }).then(result => {
                  loadingCircle.style.display = "none";
                  if (result && result.result && result.result.classification) {
                      const name = result.result.classification.suggestions[0].name;
                      const probability = result.result.classification.suggestions[0].probability;
                      const plantInfo = `${name} (Match: ${(probability * 100).toFixed(2)}%)`;
                      var accessToken = result.access_token;
                      plantInfoDiv.innerText = plantInfo;
                      plantInfoDiv.style.display = "block";
                      fetchPlantCommonNames(accessToken);
                  } else {
                      identificationMessage.innerText = "No results found.";
                  }
              }).catch(error => {
                  console.error('Error identifying plant:', error);
                  loadingCircle.style.display = "none";
                  identificationMessage.innerText = 'Error identifying plant: ' + error.message;
                  retryButton.style.display = "block";
              });
          }
          function fetchPlantCommonNames(accessToken){
            var myHeaders = new Headers();
            myHeaders.append("Api-Key", "AmMB3jE61y72gumlOmAxOmBTo1lJ3rsOEFAAuX72h9tQMKKmU3");

            var requestOptions = {
               method: 'GET',
               headers: myHeaders,
               redirect: 'follow'
            };

            fetch(`https://plant.id/api/v3/identification/${accessToken}?details=common_names&language=en`, requestOptions)
            .then(response => response.json())
            .then(result => {
               var commonNames = result.result.classification.suggestions[0].details.common_names;
               var commonName = commonNames[0];
               document.getElementById("plantCommonName").innerHTML = commonName;
               document.getElementById("loadingCircle").style.display = "none";
			  
			   document.cookie='pCook='+commonName; 
			   
			   
			   
            })
            .catch(error =>{
               console.error('Error fetching plant common names:', error);
               document.getElementById("identificationMessage").innerText = 'Error fetching plant common name: ' + error.message;
               document.getElementById("loadingCircle").style.display = "none";
               
            })
          }
      
          retryButton.addEventListener("click", function() {
              document.getElementById("default-btn").click();
          });
      });
      </script>
      </div>
   </div>
</section>     
<div class="right-images" style="background-color: transparent;right: 0px;">
   <img src="plant3.png" alt="Image 1">
</div>
</body>
</html>
