// js file for avoiding code repetition in the chart controllers

// These functions are used in the most/all of chart controllers

function listClicked(itemName) {
    var svg = d3.select("#chart").select("svg");
    // call click event of line that has country name
    svg.selectAll("path")
        .filter(function (d) {
            // if it is line's text
            if (typeof (d) == "object" && d != null)
                return d[0] == itemName;
        })
        .dispatch("click");
}

function listHover(itemName) {
    var svg = d3.select("#chart").select("svg");
    // call mouseover event of line that has country name
    svg.selectAll("path")
        .filter(function (d) {
            // if it is line's text
            if (typeof (d) == "object" && d != null)
                return d[0] == itemName;
        })
        .dispatch("mouseover");
}

function listOut() {
    var svg = d3.select("#chart").select("svg");
    // call mouseout event of all lines
    svg.selectAll("path")
        .dispatch("mouseout");
}

function labelHover() {
    var svg = d3.select("#chart").select("svg");

    // get country name
    console.log(d3.select(this).data());
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
