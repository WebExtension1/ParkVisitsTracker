SetupSection("guide");
SetupSection("cex");
SetupSection("psnp");

function SetupSection(sectionName) {
    document.querySelector(".add-new-" + sectionName).addEventListener("click", function() {
        sectionContainer = document.querySelector("." + sectionName + "-sections");
        newSection = document.querySelector("." + sectionName + "-section").cloneNode(true);
        sectionContainer.appendChild(newSection);
        children = newSection.children;
        resetValues(children);

        removeButtons = document.querySelectorAll("." + sectionName + "-remove");
        for (let i = 0; i < removeButtons.length; i++) {
            removeButtons[i].style.display = "inline";
        }

        children[children.length - 1].addEventListener("click", function (event) {
            removeButton(event.target, sectionName);
        })
        
        if (sectionContainer.childElementCount == 8) {
            document.querySelector(".add-new-" + sectionName).style.display = "none";
        }
    })
}

removeButtons = document.querySelectorAll(".remove");
for (let i = 0; i < 3; i++) {
    removeButtons[i].addEventListener("click", function(event) {
        removeButton(event.target, "");
    });
}

function removeButton(caller, section) {
    caller.parentNode.remove();
    if (section != "") {
        remaining = document.querySelectorAll("." + section + "-section");
        if (remaining.length == 1) {
            remainingChildren = remaining[0].children;
            remainingChildren[remainingChildren.length - 1].style.display = "none";
        }
    }
    document.querySelector(".add-new-" + section).style.display = "block";
}

function resetValues(children) {
    for (i = 0; i < children.length; i++) {
        if (children[i].type == "text") {
            children[i].value = "";
        }
        children[i].checked = false;
    }
}