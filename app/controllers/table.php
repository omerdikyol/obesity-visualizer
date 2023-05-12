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
document.getElementById("countryCount").style.display = "none";
document.getElementById("year").style.display = "none";
document.getElementById("bmi").style.display = "none";
document.getElementById("resetButton").style.display = "none";
document.getElementById("countryList").style.display = "none";

var bmi_asc = true;
var country_asc = true;
var year_asc = true;
var value_asc = true;

function updateTable(header) {
    // AJAX call to get all data from db
    $.ajax({
        url: "/obesity-visualizer/app/models/table.php",
        type: "GET",
    }).done(function(data) {
        data = JSON.parse(data);

        if (header != undefined) {
            // Sort data by header (both ascending and descending)
            if (header == 0) {
                data.sort(function(a, b) {
                    if (bmi_asc) return a.bmi.localeCompare(b.bmi);
                    else return b.bmi.localeCompare(a.bmi);
                });
                bmi_asc = !bmi_asc;
            } else if (header == 1) {
                data.sort(function(a, b) {
                    if (country_asc) return a.country.localeCompare(b.country);
                    else return b.country.localeCompare(a.country);
                });
                country_asc = !country_asc;
            } else if (header == 2) {
                data.sort(function(a, b) {
                    if (year_asc) return a.year - b.year;
                    else return b.year - a.year;
                });
                year_asc = !year_asc;
            } else if (header == 3) {
                data.sort(function(a, b) {
                    if (value_asc) return a.value - b.value;
                    else return b.value - a.value;
                });
                value_asc = !value_asc;
            }
        }

        // Remove old table
        d3.select("table").remove();

        createTable(data);
    });
}

function createTable(data) {
    var countriesDict = <?php echo json_encode($countries); ?>;
    var headers = ["BMI", "Country", "Year", "Value"];

    // Change country codes to country names
    for (var i = 0; i < data.length; i++) {
        if (data[i].country in countriesDict)
            data[i].country = countriesDict[data[i].country];
        else {
            data.splice(i, 1); // Remove country if it is not in the list
            i--;
        }
    }


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

    // Create a cell in each row for each column
    var cells = rows.selectAll("td")
        .data(function(row) {
            return [row.bmi, row.country, row.year, row.value];
        })
        .enter()
        .append("td")
        .text(function(d) {
            return d;
        })
        .style("border", "1px black solid")
        .style("padding", "5px")
        .on("mouseover", function() {
            d3.select(this).style("background-color", "powderblue");
        })
        .on("mouseout", function() {
            d3.select(this).style("background-color", "white");
        })
        .text(function(d) {
            return d;
        })
        .style("font-size", "12px");

    // Add scroll bar to table
    d3.select("#chart")
        .style("overflow", "auto")
        .style("max-height", window.innerHeight * 2 / 3 + "px");

    // Make chart's width same as table's width + 10px (for scrollbar)
    d3.select("#chart")
        .style("width", table.node().getBoundingClientRect().width + 20 + "px");
}

updateTable();
</script>