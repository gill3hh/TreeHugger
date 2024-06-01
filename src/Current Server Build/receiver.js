// Import the necessary modules
const fetch = (...args) => import('node-fetch').then(({default: fetch}) => fetch(...args));

const express = require('express');
const cookieParser = require('cookie-parser');
const { v4: uuidv4 } = require('uuid'); // Import the version 4 of uuid\
const mysql = require('mysql');
const cors = require('cors');

const app = express();  // Create an Express application

app.use(express.urlencoded({ extended: true }));    // Middleware to parse URL-encoded data (from HTML forms, for example)
app.use(cookieParser());    // Middleware to parse cookies from the HTTP Request
app.use(cors());    //allows requests from different domains

//Handles connection to mysql database (TEMP COMMENTED OUT)
/*
// Set up your MySQL connection
const db = mysql.createConnection({
    host: 'host',
    user: 'username',
    password: 'password',
    database: 'database'
});

db.connect((err) => {
    if (err) throw err;
    console.log('Connected to MySQL');
});
*/

// Endpoint to get environment page data
app.get('/environment', (req, res) => {
    const username = req.query.username; // Assuming you pass username as a query parameter
    const sql = 'SELECT * FROM plants WHERE username = ?'; // Your SQL query here
    db.query(sql, [username], (err, result) => {
        if (err) throw err;
        res.json(result); // Send back the result as JSON
    });
});

//endpont for logging in
app.post('/login', (req, res) => {
    const { username, password } = req.body;    //gets the username and password
    
    //checks to make sure that both username and password are not empty
    if(username == "" || password == ""){
        return res.json({ success: false, message: 'Login unsuccessful: Empty username or password' });    //sends an unsuccessful response to the client
    }
    
    //the disallowed characters for usernames
    const disallowedUserChars = "-!@#$%^&*()+=[]{};:'\"\\|,.<>/?`~ ";
    

    //checks to make sure there are no illegal characters for the username
    for(let i=0; i<username.length; i++){
        //if the character in username is in the disallowed character list
        if(disallowedUserChars.includes(username[i])){
            return res.json({ success: false, message: "Login unsuccessful: Username contains illegal characters \n(Disallowed Characters: -#$%^&*()+=[]{};:'\"\\|,.<>/`~ )" });    //sends an unsuccessful response to the client
        }
    }

    //the disallowed characters for passwords
    const disallowedPassChars = "-#$%^&*()+=[]{};:'\"\\|,.<>/`~ ";

    //checks to make sure there are no illegal characters for the password
    for(let i=0; i<password.length; i++){
        //if the character in username is in the disallowed character list
        if(disallowedPassChars.includes(password[i])){
            return res.json({ success: false, message: "Login unsuccessful: Password contains illegal characters \n(Disallowed Characters: -#$%^&*()+=[]{};:'\"\\|,.<>/`~ )" });    //sends an unsuccessful response to the client
        }
    }

    /*

    //check to see if the username and password match any user in the database
    fetch('http://localhost:3000/databaseManager', {
        method: 'POST',
        body: req.body
    })
    .then(response => response.json())
    .then(data => {
        //if an account with that username and password is not found
        if(data.success) {
            // Generate a unique session ID
            const sessionId = uuidv4();

            // Set a session cookie
            res.cookie('session_id', sessionId, { httpOnly: true, secure: true, sameSite: 'strict' });
            res.json({ success: true, message: 'Login successful' });
        }
        else {
            return res.json({ success: false, message: "Login unsuccessful: Username or password incorrect" });    //sends an unsuccessful response to the client
        }
    })
    .catch(error => {
        //handles error when trying to connect to the database
        console.error('Error during login:', error);
        return res.json({ success: false, message: "Login unsuccessful: Could not connect to server. Try again." });    //sends an error response to the client
    });
    */

    // Set a session cookie
    res.cookie('session_id', sessionId, { httpOnly: true, secure: true, sameSite: 'strict' });
    res.json({ success: true, message: 'Login successful' });

});

//endpoint for serving the home page back to the user
app.get('/home', (req, res) => {
    res.sendFile('home.html', { root: 'public' });
});


// Start the server on port 8080
app.listen(8080, () => {
    console.log('Server running on http://localhost:8080');
});