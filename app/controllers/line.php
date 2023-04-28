<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/models/countries.php';

// Get country names
$countries = getCountryNames();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize/line.php';
?>

<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
var bmi = document.getElementById("bmi");

// Add event listeners to dropdown menus
bmi.addEventListener("change", updateLine);

function updateLine() {
    // Remove info box
    document.getElementById("info-box").style.display = "none";

    // Remove existing line chart
    d3.select("#line").select("svg").remove();

    // Create new line chart
    createLine();
}

function createLine() {
    var bmi = document.getElementById("bmi").value;
    var countriesDict = <?php echo json_encode($countries); ?>;
    var countries = [];
    var request = [];
    var response = [];
    var svg = d3.select("#line").select("svg");

    // Set the dimensions and margins of the graph
    const width = 700;
    const height = 700;
    const margin = {
        top: 20,
        right: 20,
        bottom: 50,
        left: 200
    };
    const innerWidth = width - margin.left - margin.right;
    const innerHeight = height - margin.top - margin.bottom;
    const colors = [
        "#1f77b4", "#aec7e8", "#ff7f0e", "#ffbb78", "#2ca02c",
        "#98df8a", "#d62728", "#ff9896", "#9467bd", "#c5b0d5",
        "#8c564b", "#c49c94", "#e377c2", "#f7b6d2", "#7f7f7f",
        "#c7c7c7", "#bcbd22", "#dbdb8d", "#17becf", "#9edae5",
        "#393b79", "#637939", "#8c6d31", "#b5cf6b", "#843c39",
        "#ad494a", "#d6616b", "#e7969c", "#7b4173", "#a55194",
        "#ce6dbd", "#de9ed6", "#3182bd", "#6baed6", "#9ecae1",
        "#e6550d", "#fd8d3c", "#fdae6b", "#fdd0a2", "#31a354",
        "#74c476"
    ];

    //! Working on Data

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
        url: "/obesity-visualizer/app/models/line.php",
        type: "GET",
        data: {
            bmi: bmi
        },
        async: false,
        success: function(data) {
            response = JSON.parse(data);
        },
        error: function() {
            console.log("Error retrieving BMI data for " + request[i].country);
        }
    });

    // Change from country codes to country names using countriesDict
    for (var i = 0; i < response.length; i++) {
        response[i].geo = countriesDict[response[i].geo];
    }

    // Remove null and undefined values
    response = response.filter(function(d) {
        return d["geo"] != null || d["geo"] != undefined;
    });

    // Group the data by country
    var groupedData = d3.group(response, d => d.geo);

    // Get all values
    var allValues = [];
    for (var i = 0; i < response.length; i++) {
        if (response[i].value != null && response[i].value != 0)
            allValues.push(parseFloat(response[i].value));
    }

    //! Working on Chart

    // Add the SVG element
    var svg = d3.select("#line")
        .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform",
            "translate(" + margin.left + "," + margin.top + ")");

    // Add title to the graph
    svg.append("text")
        .attr("x", (width / 2))
        .attr("y", 0 - (margin.top / 2) + 10)
        .attr("text-anchor", "middle")
        .style("font-size", "16px")
        .style("text-decoration", "underline")
        .text("Obesity Prevalence in " + bmi + " BMI");

    // Add x-axis label
    svg.append("text")
        .attr("x", width / 2)
        .attr("y", height + margin.bottom - 10)
        .style("text-anchor", "middle")
        .text("Year");

    // Add y-axis label
    svg.append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 0 - margin.left + 10)
        .attr("x", 0 - (height / 2))
        .attr("dy", "1em")
        .style("text-anchor", "middle")
        .text("% of Population");

    // Add year to x-axis
    var xAxis = d3.scaleLinear()
        .domain(["2008", "2019"])
        .range([0, width]);

    var x = svg.append("g")
        .attr("transform", "translate(0," + height + ")") // put height instead of 500
        .attr("class", "x axis")
        .call(d3.axisBottom(xAxis));

    // Add values to y-axis
    var yAxis = d3.scaleLinear()
        .domain([d3.min(allValues) - 5, d3.max(allValues) + 5])
        .range([height, 0]);

    var y = svg.append("g")
        .attr("class", "y axis")
        .call(d3.axisLeft(yAxis));

    var color = d3.scaleOrdinal()
        .domain(countries)
        .range(colors);

    // Add line for each country
    var line = d3.line()
        .x(function(d) {
            return xAxis(d.year)
        })
        .y(function(d) {
            return yAxis(d.value)
        })
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
        .style("stroke-width", 4)
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
        .attr("r", 5)
        .attr("stroke", "white")

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

    // Add zoom functionality
    var chart = document.querySelector("#line svg");
    var zoom = d3.select(chart).call(d3.zoom().on("zoom", function() {
        svg.attr("transform", d3.zoomTransform(this))
    }));
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
                    return d.geo != countryName;
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

function listClicked(itemName) {
    var svg = d3.select("#line").select("svg");
    // call click event of line that has country name
    svg.selectAll("path")
        .filter(function(d) {
            // if it is line's text
            if (typeof(d) == "object" && d != null)
                return d[0] == itemName;
        })
        .dispatch("click");

}

function listHover(itemName) {
    var svg = d3.select("#line").select("svg");
    // call mouseover event of line that has country name
    svg.selectAll("path")
        .filter(function(d) {
            // if it is line's text
            if (typeof(d) == "object" && d != null)
                return d[0] == itemName;
        })
        .dispatch("mouseover");
}

function listOut() {
    var svg = d3.select("#line").select("svg");
    // call mouseout event of all lines
    svg.selectAll("path")
        .dispatch("mouseout");
}

function labelHover() {
    var svg = d3.select("#line").select("svg");

    // get country name
    console.log(d3.select(this).data());
}

function reset() {
    var svg = d3.select("#line").select("svg");

    updateLine();

}

createLine();
</script>