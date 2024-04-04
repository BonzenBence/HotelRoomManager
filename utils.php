function displayTableFromQuery($server, $query, $columnNames) {
    $result = mysqli_query($server, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($server));
    }
    echo "<table class='table'>";
    echo "<thead><tr>";
    foreach ($columnNames as $columnName) {
        echo "<th>" . htmlspecialchars($columnName) . "</th>";
    }
    echo "</tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        foreach ($columnNames as $columnName) {
            echo "<td>" . htmlspecialchars($row[$columnName]) . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}
