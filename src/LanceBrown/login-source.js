//runs javascript after page has loaded completely
document.addEventListener('DOMContentLoaded', (event) => {
    const signInFormInputs = document.getElementsByClassName("signInInput");        //all interactive elements available when using the sign in option (including Sign Up tab)
    const signUpFormInputs = document.getElementsByClassName("signUpInput");        //all interactive elements available when using the sign up option (including Sign In tab)
    const securityFormInputs = document.getElementsByClassName("securityInput");    //all interactive elements available on the security form

    var mainResponse = document.getElementById('mainResponse');               //response text for the main login container
    var securityResponse = document.getElementById('securityResponse');       //response text for the security container

    //const verEmail = document.getElementById();

    var username;
    var password;
    var email;
    var code;

    initializeForm()

    //switches the given inputs on or off (inputs = input elements, value = true or flase)
    function disableInputs(inputs, value){
        for (var i = 0; i < inputs.length; i++) {
            
            if(value && inputs[i].tagName === 'INPUT') inputs[i].value = "";

            inputs[i].disabled = value;
        }   //toggles the functionality of the input elements 
    }

    //disables all elements on the page other than the ones available in the login portion of the form
    function initializeForm(){
        switchToSignIn();                                   //enables the sign in features and disables the sign up features
        disableInputs(securityFormInputs, true);        //disables the security form features
        //disableInputs(passwordResetFormInputs, true);    //disables the passwordReset form features                
    }

    //disables the elements for the sign in functions and enables the functions for the sign up functions
    function switchToSignUp(){
        disableInputs(signInFormInputs, true);      //disables the sign in form features
        disableInputs(signUpFormInputs, false);     //enables the sign up form features
    }   

    //disables the elements for the sign up functions and enables the functions for the sign in functions
    function switchToSignIn(){
        disableInputs(signUpFormInputs, true);     //disables the sign up form features
        disableInputs(signInFormInputs, false);      //enables the sign in form features
    }   

    //NOTE: Might want to consider making a seperate page for this
    //disables the elements for the login container and enables the recovery container elements
    function switchToRecoverPassword(){
        disableInputs(signUpFormInputs, true);     //disables the sign up form features
    }   

    //disables the elements for the login container and enables the security container elements
    function switchToSecurity(){
        disableInputs(signUpFormInputs, true);                          //disables the sign up form features
        document.getElementById('security').style.display = 'block';    //makes the security container elements visible
        document.getElementById('main').style.display = 'none';         //hides the main login container elements
    }   

    //adds an event listener to the forgot password button
    document.getElementById('forgotPassword').addEventListener('click', function(event) {
        
    });

    //adds an event listener to the sign in button
    document.getElementById('signInBtn').addEventListener('click', function() {
        mainResponse.textContent = "";                                      //clears the main response field
        document.getElementById('signInForm').style.display = 'block';      //makes the sign in elements visible
        document.getElementById('signUpForm').style.display = 'none';       //hides the sign up elements
        switchToSignIn();                                                   //disables the input elements' functionality for the sign up section
        mainResponse.textContent = "";                                      //resets the main login container's response message content
    });

    //adds an event listener to the sign up button
    document.getElementById('signUpBtn').addEventListener('click', function() {
        mainResponse.textContent = "";                                      //clears the main response field
        document.getElementById('signUpForm').style.display = 'block';      //makes the sign up elements visible
        document.getElementById('signInForm').style.display = 'none';       //hides the sign in elements
        switchToSignUp();                                                   //disables the input elements' functionality for the sign in section
        mainResponse.textContent = "";                                      //resets the main login container's response message content
    });

    //adds an event listener to the login button
    document.getElementById('login').addEventListener('click', function() {
        
        mainResponse.textContent = ""; // Clears the main response field

        // Gets the login credentials from the input fields on the sign-in page
        username = document.getElementById('signInUsernameInput').value;
        password = document.getElementById('signInPasswordInput').value;
        
        // Checks if the fields are empty
        if(username === "" || password === ""){
            mainResponse.textContent = "Please ensure that all fields are filled.";
            return;
        }

        // Prepare data to be sent to the server
        const loginData = new FormData();
        loginData.append('username', username);
        loginData.append('password', password);

        
        // Send a request with the login information
        fetch('http://localhost:8080/login', {
            method: 'POST',
            body: loginData
        })
        .then(response => response.json())
        .then(data => {
            // Process the response from the server
            if(data.success) {
                // Redirect the user to the home page or update UI accordingly
                window.location.href = 'http://localhost:8080/index.html';
            } else {
                // Display error message
                mainResponse.textContent = data.message || "Login failed. Please try again.";
            }
        })
        .catch(error => {
            console.error('Error during login:', error);
            mainResponse.textContent = "An error occurred. Please try again.";
        });

    });

    //adds an event listener to the register button
    document.getElementById('register').addEventListener('click', function() {
        
        /*
        Need to send a request to the server to send a security code to the user via email.

        If the request comes back without error (email was sent successfully) continue to 
        switch to the security container.

        If email was not sent successfully (invalid email address, timeout error, lost connection, etc.)
        display a message indicating so with the response text body.

        [Should have a session key/cookie to verify that a user is logged in]
        */
        
        mainResponse.textContent = ""   //clears the main response field

        //gets the login credentials from the input fileds on the sign in page
        username = document.getElementById('signUpUsernameInput').value;
        password = document.getElementById('signUpPasswordInput').value;
        email = document.getElementById('signUpEmailInput').value;
        
        //checks if the fields are empty, cancels registration if any are
        if(username == "" || password == "" || email == ""){
            mainResponse.textContent = "Please ensure that all fields are filled."
            return;
        }

        // Prepare data to be sent to the server
        const registerData = new FormData();
        registerData.append('username', username);
        registerData.append('password', password);
        registerData.append('email', email);

        // Send a request to register the new user
        fetch('http://localhost:8080/register', {
            method: 'POST',
            body: registerData
        })
        .then(response => response.json())
        .then(data => {
            // Process the response from the server
            if(data.success) {
                // If registration is successful, you might want to switch to the security container
                // or inform the user to verify their email, etc.
                switchToSecurity();
            } else {
                // Display error message
                mainResponse.textContent = data.message || "Registration failed. Please try again.";
            }
        })
        .catch(error => {
            console.error('Error during registration:', error);
            mainResponse.textContent = "An error occurred. Please try again.";
        });
    });

    //adds an event listener to the sign in tab button
    document.getElementById('signUpTogglePassword').addEventListener('click', function (e) {
        const passwordInput = document.getElementById('signUpPasswordInput');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁️‍🗨️' : '👁️'; // Change the icon or text accordingly
    });

    //adds an event listener to the sign up tab button
    document.getElementById('signInTogglePassword').addEventListener('click', function (e) {
        const passwordInput = document.getElementById('signInPasswordInput');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁️‍🗨️' : '👁️'; // Change the icon or text accordingly
    });
});