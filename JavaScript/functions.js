function confirmSubmit() {
    if (confirm("Are you sure?")) {
        document.getElementById("FORM_ID").submit();
    }
    return false;
}