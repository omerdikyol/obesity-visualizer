// js file for avoiding code repetition in the chart controllers

// These functions are used in the most/all of chart controllers

function listClicked(itemName) {
    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    for (var i = 0; i < paths.length; i++) {
        if (paths[i].getAttribute("name") == itemName) {
            // Trigger click event
            paths[i].dispatchEvent(new MouseEvent("click"));

            // Hover over the country
            paths[i].dispatchEvent(new MouseEvent("mouseover"));
            // Wait 0.3 second
            setTimeout(function () {
                // Unhover the country
                paths[i].dispatchEvent(new MouseEvent("mouseout"));
            }, 300);

            break;
        }
    }
}

function listHover(itemName) {
    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    for (var i = 0; i < paths.length; i++) {
        if (paths[i].getAttribute("name") == itemName) {
            // Hover over the country
            paths[i].dispatchEvent(new MouseEvent("mouseover"));
            break;
        }
    }
}

function listOut() {
    var svgDoc = svgObject.contentDocument;
    // Get all paths in the SVG
    var paths = svgDoc.querySelectorAll('path');

    for (var i = 0; i < paths.length; i++) {
        // Unhover the country
        paths[i].dispatchEvent(new MouseEvent("mouseout"));
    }
}

function reset() {
    var svg = d3.select("#chart").select("svg");

    updateLine();
}

function resetInfoBox() {
    var infoBox = document.getElementById("info-box");
    infoBox.style.display = "none";
}

function closeInfoBox() {
    document.getElementById("info-box").style.display = "none";
}

// Hold and drag the info-box
// Get the info-box element
const infoBox = document.getElementById("info-box");

// Variable to store the initial position of the info-box
let initialX;
let initialY;

// Add event listener to the info-box for the mousedown event
infoBox.addEventListener("mousedown", dragStart);

function dragStart(event) {
    // Store the initial position of the info-box
    initialX = event.clientX - infoBox.offsetLeft;
    initialY = event.clientY - infoBox.offsetTop;

    // Attach event listeners for dragging and dropping
    document.addEventListener("mousemove", drag);
    document.addEventListener("mouseup", dragEnd);
}

function drag(event) {
    event.preventDefault();

    // Calculate the new position of the info-box
    const newX = event.clientX - initialX;
    const newY = event.clientY - initialY;

    // Set the new position
    infoBox.style.left = newX + "px";
    infoBox.style.top = newY + "px";
}

function dragEnd() {
    document.removeEventListener("mousemove", drag);
    document.removeEventListener("mouseup", dragEnd);
}

