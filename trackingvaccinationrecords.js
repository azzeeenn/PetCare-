document.getElementById("vaccination-form").addEventListener("submit", function(event) {
    event.preventDefault();

    // Get form data
    var vaccineName = document.getElementById("vaccine-name").value;
    var vaccinationDate = document.getElementById("vaccination-date").value;
    var nextDue = document.getElementById("next-due").value;
    var vetNotes = document.getElementById("vet-notes").value;

    // Create a new row for the table
    var table = document.getElementById("vaccination-table").getElementsByTagName('tbody')[0];
    var newRow = table.insertRow();

    // Insert new data into the row
    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);
    var cell4 = newRow.insertCell(3);

    cell1.textContent = vaccineName;
    cell2.textContent = vaccinationDate;
    cell3.textContent = nextDue;
    cell4.textContent = vetNotes;

    // Clear the form
    document.getElementById("vaccination-form").reset();
});
