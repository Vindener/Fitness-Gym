function loadHour() {
    var classId = document.getElementById("class_id").value;
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../include/get_hour.php?class_id=" + classId, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("class_hour").innerText = xhr.responseText;
        }
    };
    xhr.send();
}