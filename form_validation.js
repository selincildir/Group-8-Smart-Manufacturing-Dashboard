function validateForm() {
    let machineName = document.forms["machineForm"]["machine_name"].value;
    if (machineName == "") {
        alert("Machine name must be filled out");
        return false;
    }
}
