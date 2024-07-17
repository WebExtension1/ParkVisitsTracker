const format = document.getElementById("format");

format.addEventListener("change", function(){
    holder = document.getElementById("format-holder-div");
    if (format.options[0].selected == 1) {
        holder.style.display = "block";
    } else {
        holder.style.display = "none";
    }
})