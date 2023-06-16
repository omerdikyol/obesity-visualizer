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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.0/html2canvas.min.js"></script>

<script src="/obesity-visualizer/public-app/public/js/chartFunctions.js"></script>
<script src="/obesity-visualizer/public-app/public/js/exportChart.js"></script>


<script>
var bmi = document.getElementById("bmi");

// Hide unnecessary elements
document.getElementById("countryCountDiv").style.display = "none";
document.getElementById("yearDiv").style.display = "none";

// Add event listeners to dropdown menus
bmi.addEventListener("change", updateLine);

var xAxis = d3.scaleLinear();
var yAxis = d3.scaleLinear();

function updateLine() {
    var bmi = document.getElementById("bmi").value;

    // Set title
    document.getElementById("title").innerHTML = "BMI: " + bmi;

    // Remove info box
    document.getElementById("info-box").style.display = "none";

    // Remove existing line chart
    d3.select("#chart").select("svg").remove();

    // Create new line chart
    createLine();
}

function createLine() {
    var bmi = document.getElementById("bmi").value;
    var countriesDict = <?php echo json_encode($countries); ?>;
    var countries = [];
    var request = [];
    var response = [];

    // Insert data function to call asynchronously after data is retrieved
    function insertData(data) {
        // Change from country codes to country names using countriesDict
        for (var i = 0; i < data.length; i++) {
            data[i].country = countriesDict[data[i].country];
        }

        // Remove null and undefined values
        data = data.filter(function(d) {
            return d["country"] != null || d["country"] != undefined;
        });

        // Group the data by country
        var groupedData = d3.group(data, d => d.country);

        // Get all values
        var allValues = [];
        for (var i = 0; i < data.length; i++) {
            if (data[i].value != null && data[i].value != 0)
                allValues.push(parseFloat(data[i].value));
        }

        // Add the SVG element
        var svg = d3.select("#chart")
            .append("svg")
            .attr("id", "line-chart") // Add ID to the SVG element
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");

        // Add x-axis label
        svg.append("text")
            .attr("x", width / 2)
            .attr("y", height + margin.bottom - 10)
            .style("text-anchor", "middle")
            .text("Year");

        // Add y-axis label
        svg.append("text")
            .attr("transform", "rotate(-90)")
            .attr("y", 0 - margin.left)
            .attr("x", 0 - (height / 2))
            .attr("dy", "1em")
            .style("text-anchor", "middle")
            .text("% of Population");

        // Add year to x-axis
        xAxis.domain(["2008", "2019"])
            .range([0, width]);

        x = svg.append("g")
            .attr("transform", "translate(0," + height + ")") // put height instead of 500
            .attr("class", "x axis")
            .call(d3.axisBottom(xAxis).tickFormat(d3.format("d")));

        // Add values to y-axis
        yAxis.domain([d3.min(allValues) - 5, d3.max(allValues) + 5])
            .range([height, 0]);

        y = svg.append("g")
            .attr("class", "y axis")
            .call(d3.axisLeft(yAxis));

        var color = d3.scaleOrdinal()
            .domain(countries)
            .range(colors);

        // Add gray lines to the background
        var backgroundLines = svg.append("g")
            .attr("class", "background-lines");

        var yValues = yAxis.ticks();

        backgroundLines.selectAll("line")
            .data(yValues)
            .enter()
            .append("line")
            .attr("x1", 0)
            .attr("x2", width)
            .attr("y1", function(d) {
                return yAxis(d);
            })
            .attr("y2", function(d) {
                return yAxis(d);
            })
            .style("stroke", "#ddd")
            .style("stroke-width", 1)
            .style("stroke-dasharray", "2,2");

        // Add line for each country
        var line = d3.line()
            .x(function(d) {
                return xAxis(d.year)
            })
            .y(function(d) {
                return yAxis(d.value)
            });

        svg.selectAll("myLines")
            .data(groupedData)
            .enter()
            .append("path")
            .attr("d", function(d) {
                return line(d[1])
            })
            .attr("stroke", function(d) {
                return color(d[0])
            })
            .style("stroke-width", 1.5) // Adjust the value as needed
            .style("fill", "none")
            .on("mouseover", handleMouseOver)
            .on("mouseout", handleMouseOut)
            .on("click", handleClick);

        // Add dots for each country
        svg.selectAll("myDots")
            .data(groupedData)
            .enter()
            .append('g')
            .style("fill", function(d) {
                return color(d[0])
            })
            .selectAll("myPoints")
            .data(function(d) {
                return d[1]
            })
            .enter()
            .append("circle")
            .attr("cx", function(d) {
                return xAxis(d.year)
            })
            .attr("cy", function(d) {
                return yAxis(d.value)
            })
            .attr("r", 6) // Adjust the value as needed
            .attr("stroke", "white");

        // Add country name to the left of the line
        svg.selectAll("myLabels")
            .data(groupedData)
            .enter()
            .append('g')
            .append("text")
            .attr("x", function(d) {
                return xAxis(d[1][0].year) - 10
            })
            .attr("y", function(d) {
                return yAxis(d[1][0].value)
            })
            .text(function(d) {
                return d[0]
            })
            .style("fill", function(d) {
                return color(d[0])
            })
            .style("font-size", 15)
            .style("font-weight", "bold")
            .attr("text-anchor", "end")
            .on("click", handleClick)
            .on("mouseover", handleMouseOver)
            .on("mouseout", handleMouseOut);

        // Add a clip path to the SVG element
        svg.append("defs")
            .append("clipPath")
            .attr("id", "clip")
            .append("rect")
            .attr("width", width)
            .attr("height", height);

        // Add the line group and apply the clip path
        lineGroup = svg.append("g")
            .attr("class", "line-group")
            .attr("clip-path", "url(#clip)");

        // Add the dot group and apply the clip path
        dotGroup = svg.append("g")
            .attr("class", "dot-group")
            .attr("clip-path", "url(#clip)");
    }


    // Set the dimensions and margins of the graph
    const width = window.innerWidth * 0.6;
    const height = window.innerHeight * 0.6;
    const margin = {
        top: 20,
        right: 20,
        bottom: 50,
        left: 100
    };
    const innerWidth = width - margin.left - margin.right;
    const innerHeight = height - margin.top - margin.bottom;
    const colors = [
        "#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd",
        "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf",
        "#393b79", "#7b4173", "#a55194", "#ce6dbd", "#de9ed6",
        "#3182bd", "#6baed6", "#9ecae1", "#fd8d3c", "#fdae6b"
    ];

    // Get country names from countries array
    for (var key in countriesDict) {
        if (countriesDict.hasOwnProperty(key)) {
            countries.push(key);
        }
    }

    // Build the request array
    for (var i = 0; i < countries.length; i++) {
        request.push({
            country: countries[i],
            bmi: bmi
        });
    }

    // Make AJAX call to get the data for selected bmi
    $.ajax({
        url: "http://localhost/obesity-visualizer/chart/",
        type: "GET",
        data: {
            bmi: bmi
        }
    }).done(function(data) {
        data = JSON.parse(data);
        // call insertData function with response

        // Change geo column to country
        data = data.map(function(d) {
            d.country = d.geo;
            delete d.geo;
            return d;
        });

        insertData(data);

        // Save data to session storage (for exporting the chart as CSV)
        sessionStorage.setItem("data", JSON.stringify(data));
    }).fail(function() {
        console.log("Error retrieving BMI data for " + request[i].country);
    }).always(function() {});


}

function handleMouseOver(d) {
    // Get country name
    var countryName = d3.select(this).data()[0][0];

    // changed attributes
    var attr = ["path", "text", "circle"];

    // change opacity of all lines
    for (var i = 0; i < attr.length; i++) {
        d3.selectAll(attr[i])
            .filter(function(d) {
                // if it is line
                if (typeof(d) == "object" && d != null)
                    return d.country != countryName;
            })
            .style("opacity", 0.1);
    }

    // change opacity of selected line
    for (var i = 0; i < attr.length; i++) {
        d3.selectAll(attr[i])
            .filter(function(d) {
                // if it is line
                if (typeof(d) == "object" && d != null)
                    return d[0] == countryName;
            })
            .style("opacity", 1);
    }
}

function handleMouseOut(d) {
    // Reset everything
    d3.selectAll("path")
        .style("opacity", 1);

    d3.selectAll("text")
        .style("opacity", 1);

    d3.selectAll("circle")
        .style("opacity", 1);
}

function handleClick(d) {
    // Get clicked line's data
    var clickedData = d3.select(this).data()[0];

    var countryName = clickedData[0];

    var infoBox = document.getElementById("info-box");

    // Clear info box
    infoBox.getElementsByTagName("p")[0].innerHTML =
        "<strong>Country:</strong> " + countryName;
    infoBox.getElementsByTagName("p")[1].innerHTML = ""
    infoBox.getElementsByTagName("p")[2].innerHTML = ""
    infoBox.getElementsByTagName("p")[3].innerHTML = ""

    const years = ["2008", "2014", "2017", "2019"];

    for (var i = 0; i < clickedData[1].length; i++) {
        infoBox.getElementsByTagName("p")[1].innerHTML +=
            "<strong>Year:</strong> " + clickedData[1][i].year + "<strong> Percentage:</strong> " +
            clickedData[1][
                i
            ]
            .value + "<br>";
    }


    // Show info box
    infoBox.style.display = "block";
}

updateLine();
</script>