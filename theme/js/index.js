async function fetchDataAndDisplayTable() {
  try {
    const response = await fetch("formsubmit.php/newcertficatenotifcation"); // Replace with your PHP script URL
    const data = await response.json();
    console.log(data);

    // Get table body element
    const tableBody = document.getElementById("data-table-body");
    tableBody.innerHTML = "";

    // Populate table rows
    data.forEach((entry, index) => {
      const row = `
                <tr>
                    <td>${index + 1}</td>
                    <td>${entry.name}</td>
                    <td>${entry.product}</td>
                    <td>${entry.status}</td>
                </tr>
            `;
      tableBody.innerHTML += row;
    });
  } catch (error) {
    console.error("Error fetching or parsing data:", error);
  }
}

// Call function to fetch data and display table
// fetchDataAndDisplayTable();
setInterval(fetchDataAndDisplayTable, 1000);
