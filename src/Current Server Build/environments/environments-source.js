//discovered plants example
const plants = [
    ["Rose", "A beautiful flower with thorns.", "01-01-2020", "rose.jpg"],
];

//create the dim overlay
const overlay = document.createElement('div');  //the overlay that dims the screen when the popup window is active
overlay.className = 'dim-overlay';
document.body.appendChild(overlay);


const popup = document.createElement('div');    //the popup for plant details

const plantContainer = document.querySelector('.plant-container');

plants.forEach((plant) => 
{
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

    plantItem.onclick = () => showPlantDetails(...plant);
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
