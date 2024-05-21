const gameSection1 = document.querySelector(".games-in-library");
const gameSection2 = document.querySelector(".all-games");
const button1 = document.querySelector(".games-view-option-1");
const button2 = document.querySelector(".games-view-option-2");

gameSection2.style.display = "none";

button1.addEventListener("click", function() {button1.style.backgroundColor = "gray"; button2.style.backgroundColor = "lightGray"; gameSection1.style.display = "block"; gameSection2.style.display = "none";})
button2.addEventListener("click", function() {button1.style.backgroundColor = "lightGray"; button2.style.backgroundColor = "gray"; gameSection1.style.display = "none"; gameSection2.style.display = "block";})