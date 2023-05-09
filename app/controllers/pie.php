<?php

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/models/countries.php';

// Get country names
$countries = getCountryNames();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize/pie.php';
?>


<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
var year = document.getElementById("year");
var bmi = document.getElementById("bmi");
var count = document.getElementById("country_count");

// Add event listeners to dropdown menus
year.addEventListener("change", updateChart);
bmi.addEventListener("change", updateChart);
count.addEventListener("change", updateChart);

// Define the dimensions of the SVG container
var width = 450;
var height = 450;
var margin = 40;
var radius = Math.min(width,
    height) / 2 - margin;

// Define the color scale for the pie chart
var color = d3.scaleOrdinal()
    .range(['#E53935', '#D81B60', '#8E24AA', '#5E35B1', '#3949AB', '#1E88E5', '#039BE5', '#00ACC1', '#00897B',
        '#43A047', '#7CB342', '#C0CA33', '#FDD835', '#FFB300', '#FB8C00', '#F4511E', '#6D4C41', '#757575',
        '#546E7A', '#BDBDBD'
    ]);

function createChart(data) {
    // Define the arc for each slice of the pie chart
    var arc = d3.arc()
        .outerRadius(radius)
        .innerRadius(0);

    // Define the pie layout for the data
    var pie = d3.pie()
        .sort(null)
        .value(function(d) {
            return d.value;
        });

    // Create the SVG container
    var svg = d3.select("#chart").append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    // Generate the pie chart slices
    var g = svg.selectAll(".arc")
        .data(pie(data))
        .enter().append("g")
        .attr("class", "arc")
        .on("load", handleLoad)
        .on("click", handleClick)
        .on("mouseover", handleMouseOver)
        .on("mouseout", handleMouseOut);


    // Add the path and fill color for each slice
    g.append("path")
        .attr("d", arc)
        .style("fill", function(d) {
            return color(d.data.country);
        })
        .attr("stroke", "white")
        .style("stroke-width", "2px")
        .style("opacity", 1)
        .attr("class", "slice")

    // Add the country name
    g.append("text")
        .attr("transform", function(d) {
            return "translate(" + arc.centroid(d) + ")";
        })
        .attr("dy", ".35em")
        .text(function(d) {
            return d.data.country;
        })
        .attr("class", "arc text");


    function handleLoad(d) {
        console.log("Loaded");
    }

    function handleClick(d) {
        // Toggle the clicked state of the slice
        d3.select(this).classed("slice-clicked", !d3.select(this).classed("slice-clicked"));

        // Get the information for the slice that was clicked
        var sliceName = d3.select(this).data()[0]['data']['country'];
        var sliceValue = d3.select(this).data()[0]['data']['value'];

        // Show info box
        var infoBox = document.getElementById("info-box");
        var year = document.getElementById("year").value;
        var bmi = document.getElementById("bmi").value;
        infoBox.style.display = "block";

        infoBox.getElementsByTagName("p")[0].innerHTML =
            "<strong>Country:</strong> " + sliceName;
        infoBox.getElementsByTagName("p")[1].innerHTML =
            "<strong>Year:</strong> " + year;
        infoBox.getElementsByTagName("p")[2].innerHTML =
            "<strong>BMI:</strong> " + bmi;
        infoBox.getElementsByTagName("p")[3].innerHTML =
            "<strong>Percentage:</strong> " + sliceValue;
    }

    function handleMouseOver(d) {
        // Highlight the slice that is being hovered over
        d3.select(this).transition().duration(200).style("opacity", 1);

        var sliceName = d3.select(this).data()[0]['data']['country'];

        // Dim the opacity of all other slices
        var slices = svg.selectAll(".slice")
            .filter(function(d) {
                return d.data.country != sliceName;
            })
            .transition()
            .duration(200)
            .style("opacity", 0.5);

        // Dim the opacity of all other countrys
        var countrys = svg.selectAll(".arc text")
            .filter(function(d) {
                return d.data.country != sliceName;
            })
            .transition()
            .duration(200)
            .style("opacity", 0);

    }

    function handleMouseOut(d) {
        // Restore the opacity of all slices
        var slices = svg.selectAll(".slice")
            .transition()
            .duration(200)
            .style("opacity", 1);

        // Restore the opacity of all countrys
        var countrys = svg.selectAll(".arc text")
            .transition()
            .duration(200)
            .style("opacity", 1);
    }
}

function countryClicked(itemName) {
    var svg = d3.select("#chart").select("svg");
    // call click event of slice that has country name
    svg.selectAll(".arc")
        .filter(function(d) {
            return d.data.country == itemName;
        })
        .dispatch("click");
}

function updateChart() {
    var year = document.getElementById("year").value;
    var bmi = document.getElementById("bmi").value;
    var count = document.getElementById("country_count").value;
    var countriesDict = <?php echo json_encode($countries); ?>;
    var request = [];
    var countries = [];
    var finalData = [];

    // Get country names from countries array
    for (var key in countriesDict) {
        if (countriesDict.hasOwnProperty(key)) {
            countries.push(key);
        }
    }

    request = {
        year: year,
        bmi: bmi
    }

    // Make AJAX call to get the BMI data for each country and build the final data array
    $.ajax({
        url: "/obesity-visualizer/app/models/pie.php",
        type: "GET",
        data: request,
    }).done(function(data) {
        data = JSON.parse(data);
        console.log(data);
        if (data[0] == null) {
            return;
        }

        for (var i = 0; i < data.length; i++) {
            finalData.push({
                country: countriesDict[data[i].country],
                value: parseFloat(data[i].value)
            });
        }

        // Sort the data by BMI value
        finalData.sort(function(a, b) {
            return b.value - a.value;
        });
        console.log(finalData);

        // Create others category if there are more than "count" countries
        if (count < finalData.length) {
            console.log("count: " + count);
            // put rest to Others
            var others = {
                country: "Others",
                value: 0
            };

            for (var i = count; i < finalData.length; i++) {
                others.value += finalData[i].value;
            }

            // Get the top N countries
            finalData = finalData.slice(0, count);

            // Add the "Others" category
            finalData.push(others);
        }

        // Remove the old chart
        d3.select("#chart").select("svg").remove();

        // Create the new chart
        createChart(finalData);

    }).fail(function(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus);
    });

    // Reset the info box
    resetInfoBox();
}

function listClicked(itemName) {
    var svg = d3.select("#chart").select("svg");
    // call click event of line that has country name
    svg.selectAll(".arc")
        .filter(function(d) {
            return d["data"].country == itemName;
        })
        .dispatch("click");
}

function listHover(itemName) {
    var svg = d3.select("#chart").select("svg");
    // call mouseover event of line that has country name
    svg.selectAll(".arc")
        .filter(function(d) {
            return d["data"].country == itemName;
        })
        .dispatch("mouseover");
}

function listOut() {
    var svg = d3.select("#chart").select("svg");
    // call mouseout event of all lines
    svg.selectAll(".arc")
        .dispatch("mouseout");
}

function resetInfoBox() {
    var infoBox = document.getElementById("info-box");
    infoBox.style.display = "none";
}

updateChart();
</script>