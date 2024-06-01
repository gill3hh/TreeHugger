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