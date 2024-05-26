const newGuide = document.querySelector(".add-new-guide");
const newCEX = document.querySelector(".add-new-cex");
const newPSNP = document.querySelector(".add-new-psnp");

newGuide.addEventListener("click", function() {
    const newSection = document.querySelector(".guide-section").cloneNode(true);
    document.querySelector(".guide-sections").appendChild(newSection);
    const children = newSection.children;
    children[1].value = "";
    children[3].value = "";
    children[5].value = "";
})

newCEX.addEventListener("click", function() {
    const newSection = document.querySelector(".cex-section").cloneNode(true);
    document.querySelector(".cex-sections").appendChild(newSection);
    const children = newSection.children;
    children[1].value = "";
    children[3].value = 0;
    children[5].value = "";
    children[7].value = "";
})

newPSNP.addEventListener("click", function() {
    const newSection = document.querySelector(".psnp-section").cloneNode(true);
    document.querySelector(".psnp-sections").appendChild(newSection);
    const children = newSection.children;
    children[1].value = "";
    children[3].value = 0;
    children[5].value = "";
    children[7].value = "";
    children[9].checked = false;
})