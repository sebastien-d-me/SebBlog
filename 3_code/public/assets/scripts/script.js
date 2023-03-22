// Manage the sidebar
const sidebar = document.querySelector(".sidebar__block");
const iconOpenSidebar = document.querySelector(".icon--open_sidebar");
const iconCloseSidebar = document.querySelector(".icon--close_sidebar");
const main = document.querySelector(".main__block");

iconOpenSidebar.addEventListener("click", function () {
    sidebar.classList.add("show");
    iconOpenSidebar.classList.remove("show");
    iconCloseSidebar.classList.add("show");
    main.classList.add("hide");
});

iconCloseSidebar.addEventListener("click", function () {
    sidebar.classList.remove("show");
    iconOpenSidebar.classList.add("show");
    iconCloseSidebar.classList.remove("show");
    main.classList.remove("hide");
});