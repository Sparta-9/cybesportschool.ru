if (typeof(Storage) !== "undefined") {
  console.log('HTML5 Storage is supported')
} else {
   console.log('Sorry! No Web Storage support..')
}
(() => {
  const tabs = document.querySelectorAll(".tab");
  const contents = document.querySelectorAll(".tab-content");
  const tabsWrap = document.querySelector(".tabs-titles-wrap");
  const activeClass = "active";

  tabsWrap.addEventListener("click", e => {
    if (e.target.classList.contains("tab")) {
      [...tabs].forEach((tab, tabIndex) => {
        tab.classList.remove(activeClass);
        contents[tabIndex].classList.remove(activeClass);
        if (e.target === tab) {
          tab.classList.add(activeClass);
          contents[tabIndex].classList.add(activeClass);
          localStorage.setItem("activetab", tabIndex.toString());
          console.log(localStorage.getItem("activetab"));
        }
      });
    }
  });
})();
