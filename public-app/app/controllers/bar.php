<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/models/country.php';

// Get country names
$countries = getCountryNames();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/public-app/app/views/visualize/charts.php';
?>

<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
var year = document.getElementById("year");
var bmi = document.getElementById("bmi");

// Hide unnecessary elements
document.getElementById("countryCountDiv").style.display = "none";
document.getElementById("resetButton").style.display = "none";

// Add event listeners to dropdown menus
year.addEventListener("change", updateBar);
bmi.addEventListener("change", updateBar);

// Define the color scale for the chart
var color = d3.scaleOrdinal()
    .range(['#E53935', '#D81B60', '#8E24AA', '#5E35B1', '#3949AB', '#1E88E5', '#039BE5', '#00ACC1', '#00897B',
        '#43A047', '#7CB342', '#C0CA33', '#FDD835', '#FFB300', '#FB8C00', '#F4511E', '#6D4C41', '#757575',
        '#546E7A', '#BDBDBD'
    ]);

function getColor(d) {
    return color(d.country);
}

function updateBar() {
    var year = document.getElementById("year").value;
    var bmi = document.getElementById("bmi").value;
    var countriesDict = <?php echo json_encode($countries); ?>;

    // Set title
    document.getElementById("title").innerHTML = "Year: " + year + ", BMI: " + bmi;

    // AJAX call to get data for selected year and bmi
    $.ajax({
        url: "/obesity-visualizer/public-app/app/models/year_bmi.php",
        type: "GET",
        data: {
            year: year,
            bmi: bmi
        },
    }).done(function(data) {
        data = JSON.parse(data);
        console.log(data);
        if (data[0] == null) {
            return;
        }

        // Sort the data by BMI value (ascending)
        data.sort(function(a, b) {
            return a.value - b.value;
        });

        // Put country name instead of country code to array
        for (var i = 0; i < data.length; i++) {
            data[i].country = countriesDict[data[i].country];
        }

        // Remove the old chart
        d3.select("#chart").select("svg").remove();

        // Create the new chart
        createBar(data);

    }).fail(function(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);
    });

    // Reset the info box
    resetInfoBox();
}

function createBar(data) {
    var margin = {
            top: 20,
            right: 30,
            bottom: 30,
            left: 40
        },

        width = 960 - margin.left - margin.right,
        height = 500 - margin.top - margin.bottom;

    var x = d3.scaleBand()
        .range([0, width])
        .padding(0.1);

    var y = d3.scaleLinear()
        .range([height, 0]);


    var svg = d3.select("#chart").append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");

    x.domain(data.map(function(d) {
        return d.country;
    }));
    y.domain([0, d3.max(data, function(d) {
        return d.value;
    })]);

    svg.selectAll(".bar")
        .data(data)
        .enter().append("rect")
        .attr("class", "bar")
        .attr("x", function(d) {
            return x(d.country);
        })
        .attr("y", function(d) {
            return y(d.value);
        })
        .attr("width", x.bandwidth())
        .attr("height", function(d) {
            return height - y(d.value);
        })
        .attr("fill", "#1E5162")
        .on("mouseover", handleMouseover)
        .on("mouseout", handleMouseout)
        .on("click", handleClick);

    svg.append("g")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));

    svg.append("g")
        .call(d3.axisLeft(y));
}

function handleMouseover(d) {
    var barCountry = d3.select(this).data()[0]["country"];
    d3.selectAll(".bar") // select all bars
        .filter(function(bar) { // filter the bars to exclude the one being hovered over
            return bar.country != barCountry;
        })
        .transition()
        .duration(200)
        .style("opacity", 0.5); // set the opacity of the bars
}

function handleMouseout(d) {
    d3.selectAll(".bar") // select all bars
        .transition()
        .duration(200)
        .style("opacity", 1); // set the opacity of the bars back to 1
}

function handleClick(d) {
    // Get the information for the bar that was clicked
    var barCountry = d3.select(this).data()[0]['country'];
    var barValue = d3.select(this).data()[0]['value'];

    // Show info box
    var infoBox = document.getElementById("info-box");
    var year = document.getElementById("year").value;
    var bmi = document.getElementById("bmi").value;
    infoBox.style.display = "block";

    infoBox.getElementsByTagName("p")[0].innerHTML =
        "<strong>Country:</strong> " + barCountry;
    infoBox.getElementsByTagName("p")[1].innerHTML =
        "<strong>Year:</strong> " + year;
    infoBox.getElementsByTagName("p")[2].innerHTML =
        "<strong>BMI:</strong> " + bmi;
    infoBox.getElementsByTagName("p")[3].innerHTML =
        "<strong>Percentage:</strong> " + barValue;
}

function listClicked(itemName) {
    var svg = d3.select("#chart").select("svg");
    // call click event of line that has country name
    svg.selectAll(".bar")
        .filter(function(d) {
            console.log(d);
            return d.country == itemName;
        })
        .dispatch("click");
}

function listHover(itemName) {
    var svg = d3.select("#chart").select("svg");
    // call mouseover event of line that has country name
    svg.selectAll(".bar")
        .filter(function(d) {
            return d.country == itemName;
        })
        .dispatch("mouseover");
}

function listOut() {
    var svg = d3.select("#chart").select("svg");
    // call mouseout event of all lines
    svg.selectAll(".bar")
        .dispatch("mouseout");
}

function resetInfoBox() {
    var infoBox = document.getElementById("info-box");
    infoBox.style.display = "none";
}

function closeInfoBox() {
    document.getElementById("info-box").style.display = "none";
}

updateBar();
</script>