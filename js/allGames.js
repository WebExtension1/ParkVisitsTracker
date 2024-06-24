const gameSection1 = document.querySelector(".games-in-library");
const gameSection2 = document.querySelector(".all-games");
const button1 = document.querySelector(".games-view-option-1");
const button2 = document.querySelector(".games-view-option-2");
const loadMoreAllGames = document.querySelector(".load-more-all-games");

function left() {
    button1.style.backgroundColor = "gray";
    button2.style.backgroundColor = "lightGray";
    gameSection1.style.display = "block";
    gameSection2.style.display = "none";
    document.cookie = "selectedTab=left";
}

function right() {
    button1.style.backgroundColor = "lightGray";
    button2.style.backgroundColor = "gray";
    gameSection1.style.display = "none";
    gameSection2.style.display = "block";
    document.cookie = "selectedTab=right";
}

const selectedTab = document.cookie.match('(^|;)\\s*selectedTab\\s*=\\s*([^;]+)')?.pop() || '';
if (selectedTab == "left") {
    left();
} else if (selectedTab == "right") {
    right();
}

loadMoreAllGames.addEventListener("click", function() {
    const hidden = document.querySelectorAll(".all-games-hidden");
    for (const item of hidden) {
        item.style.display = "table-row";
    }
    loadMoreAllGamesRow = document.querySelector(".load-more-all-games-row");
    loadMoreAllGamesRow.remove();
})