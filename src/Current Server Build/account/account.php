<link rel="icon" href="/../LEAF.png">

<!DOCTYPE html>
<html lang="en">


<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
if (!isset($_SESSION["user"]))
{
	 header("Location: /../index.php");
}
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

function getUserData()
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
	
}
getUserData();

?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>User Account- Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header">
    <div class="d-flex flex-column">

      <div class="profile">
        <img src="assets/img/placeholder.jpg" alt="" class="img-fluid rounded-circle">
        <?php echo '<h1 class="text-light"><a href="index.html">' . $_SESSION["user"] . '</a></h1>';?>
		
      </div>

      <nav id="navbar" class="nav-menu navbar">
        <ul>
          <li><a href="/../home/home.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Home</span></a></li>
          <li><a href="#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>About</span></a></li>
          <li><a href="#Achievement" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Achievement</span></a></li>
		  <li><a href="/../plants.php" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Plant List</span></a></li>
          <li><a href="/../environments/environments.php" class="nav-link scrollto"><i class="bx bx-file-blank"></i> <span>Garden</span></a></li>
		  <li><a href="/../environments/settings.php" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Settings</span></a></li>
        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header><!-- End Header -->

  <!-- ======= User Profile Section ======= -->
  <section id="profile" class="d-flex flex-column justify-content-center align-items-center">
    <div class="hero-container" data-aos="fade-in">
      <?php echo '<h1>' . $_SESSION["user"] . '</h1>'; ?>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>About</h2>
        </div>

        <div class="row">
          <div class="col-lg-4" data-aos="fade-right">
            <img src="assets/img/placeholder.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
            <h3>User Info: </h3>

            <div class="row">
              <div class="col-lg-6">
                <ul>
				  <?php
				  echo '<li><i class="bi bi-chevron-right"></i> <strong>Name:</strong> <span>' . $name_S . '</span></li>';
                  echo '<li><i class="bi bi-chevron-right"></i> <strong>Contact:</strong> <span>' . $email_S . '</span></li>';
                  echo '<li><i class="bi bi-chevron-right"></i> <strong>City:</strong> <span>' . $country_S . '</span></li>';
				  ?>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul>
				  <?php
                  echo '<li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span>' . $age_S . '</span></li>'
				  ?>
				</ul>
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Facts Section ======= -->
    <section id="facts" class="facts">
      <div class="container">

        <div class="section-title">
          <h2>About Me</h2>
          <?php echo '<p>' . $bio_S . '</p>' ?>
        </div>

      </div>
    </section><!-- End Facts Section -->

    <!-- ======= achievement Section ======= -->
    <section id="Achievement" class="Achievement">
      <div class="container">
        <div class="section-title">
          <h2>Achievement</h2>
          <p>Upload 10 plants to unlock a special achivement background or medal </p>
          <div class="row gy-4">

            <div class="col-lg-8">
              <div class="Achievement-slider swiper">
                <div class="swiper-wrapper align-items-center">

                  <div class="swiper-slide">
                    <img src="assets/img/img/leaf6.jpg" alt="">
                  </div>

                  <div class="swiper-slide">
                    <img src="assets/img/img/leaf3.jpg" alt="">
                  </div>

                  <div class="swiper-slide">
                    <img src="assets/img/img/leaf2.jpg" alt="">
                  </div>

                </div>
                <div class="swiper-pagination"></div>
              </div>
            </div>
          </div>
          <button onclick="unlockAchievementBackground()">Unlock Achievement</button>
        </div>
      </div>
    </section><!-- End achievement Section -->

	<section id="testing" class=" Environment section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Recently Identified</h2>
        </div>
		
		<?php
			error_reporting(E_ERROR | E_PARSE);
			$tData = getIdentified();
			echo '<table style="width:100%">';
			echo '<tr>';
			echo '<td><h2>Plant Name</h2></td> <td><h2>Date Identified</h2></td>';
			echo '</tr>';
			for ($x = 0; $x <= sizeof($tData); $x++)
			{
				echo '<tr>';
				echo '<td>' . $tData[$x][0] . '</td> <td>' . $tData[$x][2] . '</td>';
				echo '</tr>';
			}
			echo '</table>';
			
			echo '<pre>';
			
				
			
			echo '</pre>';
		?>

        </div>

      </div>
	</section><!-- End environment Section -->

    <!-- ======= Environment Section ======= -->
    <section id="testing" class=" Environment section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Garden</h2>
        </div>

        <div class="row" data-aos="fade-up">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="Environment-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">GARDEN</li>
              <li data-filter=".filter-card">MEADOW</li>
              <li data-filter=".filter-web">FOREST</li>
            </ul>
          </div>
        </div>

        <div class="row surrounding-container" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-4 col-md-6 Environment-item filter-app">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf1.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf1.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Garden 1"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 Environment-item filter-app">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf3.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf3.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Garden 2"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 Environment-item filter-app">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf6.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf6.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Garden 3"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 Environment-item filter-card">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf4.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf4.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Meadow 1"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 Environment-item filter-card">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf7.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf7.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Meadow 2"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 Environment-item filter-card">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf8.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf8.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Meadow 3"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 Environment-item filter-web">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf2.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf2.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Forest 1"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 Environment-item filter-web">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf5.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf5.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Forest 2"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 Environment-item filter-web">
            <div class="Environment-wrap">
              <img src="assets/img/img/leaf9.jpg" class="img-fluid" alt="">
              <div class="Environment-links">
                <a href="assets/img/img/leaf9.jpg" data-gallery="portfolioGallery" class="Environment-lightbox" title="Forest 3"><i class="bx bx-plus"></i></a>
                <a href="Environment.html" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End environment Section -->



  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.umd.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  </main>
</body>

</html>
