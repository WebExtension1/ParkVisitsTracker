newGuide = document.querySelector(".add-new-guide");
newCEX = document.querySelector(".add-new-cex");
newPSNP = document.querySelector(".add-new-psnp");

newGuide.addEventListener("click", function() {
    newSection = document.querySelector(".guide-section").cloneNode(true);
    document.querySelector(".guide-sections").appendChild(newSection);
    children = newSection.children;
    children[1].value = "";
    children[3].value = "";
    children[5].value = "";
})

newCEX.addEventListener("click", function() {
    sectionContainer = document.querySelector(".cex-sections");
    section = document.querySelector(".cex-section");
    sectionChildren = section.children;
    max = sectionChildren[3].childElementCount;

    if (sectionContainer.childElementCount < max) {
        newSection = section.cloneNode(true);
        sectionContainer.appendChild(newSection);
        children = newSection.children;
        children[1].value = "";
        children[3].value = 0;
        children[5].value = "";
        children[7].value = "";
    }
    if (sectionContainer.childElementCount == max) {
        newCEX.style.display = "none";
    }
})

newPSNP.addEventListener("click", function() {
    sectionContainer = document.querySelector(".psnp-sections");
    section = document.querySelector(".psnp-section");
    sectionChildren = section.children;
    max = sectionChildren[3].childElementCount;

    if (sectionContainer.childElementCount < max) {
        newSection = section.cloneNode(true);
        sectionContainer.appendChild(newSection);
        children = newSection.children;
        children[1].value = "";
        children[3].value = 0;
        children[5].value = "";
        children[7].value = "";
        children[9].checked = false;
    }
    if (sectionContainer.childElementCount == max) {
        newPSNP.style.display = "none";
    }
})