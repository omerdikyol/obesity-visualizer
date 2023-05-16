<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/models/countries.php';

// Get country names
$countries = getCountryNames();

include $_SERVER['DOCUMENT_ROOT'] . '/obesity-visualizer/app/views/visualize/charts.php';
?>

<script src="https://d3js.org/d3.v7.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Hide unnecessary elements
document.getElementById("countryCountDiv").style.display = "none";
document.getElementById("yearDiv").style.display = "none";
document.getElementById("resetButton").style.display = "none";
document.getElementById("rightOverlay").style.display = "none";

// Add event listener to BMI select
document.getElementById("bmi").addEventListener("change", updateTable);

var bmi_asc = true;
var country_asc = true;
var y2008_asc = true;
var y2014_asc = true;
var y2017_asc = true;
var y2019_asc = true;

function updateTable(header) {
    // AJAX call to get all data from db
    $.ajax({
        url: "/obesity-visualizer/app/models/table.php",
        type: "GET",
    }).done(function(data) {
        data = JSON.parse(data);
        data = Object.entries(data);

        var bmi = document.getElementById("bmi").value;

        // Convert data to a more suitable format
        var finalData = [];
        for (var i = 0; i < data.length; i++) {
            data[i][1] = Object.entries(data[i][1]);

            // for only one bmi
            if (data[i][0] != bmi && data[i][0] != "All") continue;
            for (var j = 0; j < data[i][1].length; j++) {
                var temp = {};
                temp.bmi = data[i][0];
                temp.country = data[i][1][j][0];
                temp["2008"] = data[i][1][j][1]["2008"];
                temp["2014"] = data[i][1][j][1]["2014"];
                temp["2017"] = data[i][1][j][1]["2017"];
                temp["2019"] = data[i][1][j][1]["2019"];
                // if there is undefined value, make it '-'
                for (var k = 0; k < Object.keys(temp).length; k++) {
                    if (temp[Object.keys(temp)[k]] == undefined)
                        temp[Object.keys(temp)[k]] = "-";
                }
                finalData.push(temp);
            }
        }


        var countriesDict = <?php echo json_encode($countries); ?>;
        // Change country codes to country names
        for (var i = 0; i < finalData.length; i++) {
            if (finalData[i].country in countriesDict)
                finalData[i].country = countriesDict[finalData[i].country];
            else {
                finalData.splice(i, 1); // Remove country if it is not in the list
                i--;
            }
        }

        if (header != undefined) {
            // Sort data by header (both ascending and descending)
            if (header == 0) {
                finalData.sort(function(a, b) {
                    if (bmi_asc) return a["bmi"].localeCompare(b["bmi"]);
                    else return b["bmi"].localeCompare(a["bmi"]);
                });
                bmi_asc = !bmi_asc;
            } else if (header == 1) {
                finalData.sort(function(a, b) {
                    if (country_asc) return a.country.localeCompare(b.country);
                    else return b.country.localeCompare(a.country);
                });
                country_asc = !country_asc;
            } else if (header == 2) {
                finalData.sort(function(a, b) {
                    // If there is no data for a year, assume it is 0
                    if (a["2008"] == "-") var a = 0;
                    else var a = a["2008"];
                    if (b["2008"] == "-") var b = 0;
                    else var b = b["2008"];
                    if (y2008_asc) return a - b;
                    else return b - a;
                });
                y2008_asc = !y2008_asc;
            } else if (header == 3) {
                finalData.sort(function(a, b) {
                    if (a["2014"] == "-") var a = 0;
                    else var a = a["2014"];
                    if (b["2014"] == "-") var b = 0;
                    else var b = b["2014"];
                    if (y2014_asc) return a - b;
                    else return b - a;
                });
                y2014_asc = !y2014_asc;
            } else if (header == 4) {
                finalData.sort(function(a, b) {
                    if (a["2017"] == "-") var a = 0;
                    else var a = a["2017"];
                    if (b["2017"] == "-") var b = 0;
                    else var b = b["2017"];
                    if (y2017_asc) return a - b;
                    else return b - a;
                });
                y2017_asc = !y2017_asc;
            } else if (header == 5) {
                finalData.sort(function(a, b) {
                    if (a["2019"] == "-") var a = 0;
                    else var a = a["2019"];
                    if (b["2019"] == "-") var b = 0;
                    else var b = b["2019"];
                    if (y2019_asc) return a - b;
                    else return b - a;
                });
                y2019_asc = !y2019_asc;
            }
        }

        // Remove old table
        d3.select("table").remove();

        createTable(finalData);
    });
}

function createTable(data) {
    var headers = ["BMI", "Country", "2008", "2014", "2017", "2019"];

    // Set title
    var bmi = document.getElementById("bmi").value;
    document.getElementById("title").innerHTML = " BMI: " +
        bmi;

    // Create table
    var table = d3.select("#chart").append("table").attr("class",
        "table table-striped table-bordered table-hover");
    var thead = table.append("thead");
    var tbody = table.append("tbody");

    // Append the header row
    thead.append("tr")
        .selectAll("th")
        .data(headers)
        .enter()
        .append("th")
        .text(function(column) {
            return column;
        })
        .style("border", "1px black solid")
        .style("padding", "5px")
        .style("background-color", "lightgray")
        .style("font-weight", "bold")
        .style("text-transform", "uppercase")
        .style("cursor", "pointer")
        .on("click", function(d, i) {
            // Call updateTable function with index
            var index = headers.indexOf(i);
            updateTable(index);
        })
        .on("mouseover", function() {
            d3.select(this).style("background-color", "darkgray");
        })
        .on("mouseout", function() {
            d3.select(this).style("background-color", "lightgray");
        });

    // Create a row for each object in the data
    var rows = tbody.selectAll("tr")
        .data(data)
        .enter()
        .append("tr")
    ""

    // Create a cell in each row for each country
    var cells = rows.selectAll("td")
        .data(function(row) {
            return [row.bmi, row.country, row["2008"], row["2014"], row["2017"], row["2019"]];
        })
        .enter()
        .append("td")
        .text(function(d) {
            return d;
        })
        .style("border", "1px black solid")
        .style("padding", "5px")
        .style("text-align", "center");

    /*
    // Add scroll bar to table
    d3.select("#chart")
        .style("overflow", "auto")
        .style("max-height", window.innerHeight * 9 / 10 + "px");

    // Make chart's width same as table's width + 10px (for scrollbar)
    d3.select("#chart")
        .style("width", table.node().getBoundingClientRect().width + 20 + "px");
        */
}

updateTable();
</script>