<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tree Hugger</title>
    <style>
        
        .animation-container {
            width: 100vw; 
            height: 100vh; 
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #e2dddd; 
            overflow: hidden; 
        }

        /* here we will style the animation */
        .animation {
            width: 100%; /* it will automatically adjusts according to the screen size*/
            height: 100%; /* it will adjust height automatically */
        }
    </style>
</head>
<body>
    
    <div class="animation-container">
        <!-- we will refer to our animation gif -->
        <img id="animation" class="animation" src="screen.gif" alt="Splash Screen Animation">
    </div>

    <script>
        // setting up a function so that splash screen goes and lands to home page after certian time
        setTimeout(function() {
            var animation = document.getElementById('animation');
            animation.parentNode.removeChild(animation);
        }, 2000); // we can adjust the length of the time for splash screen to stay
		setTimeout(function() {
		window.location.href = "home/home.php";
		}, 2000);
    </script>
</body>
</html>
