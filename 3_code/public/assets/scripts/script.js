// Manage the sidebar
const iconOpenSidebar = document.querySelector(".icon--open_sidebar");
const iconCloseSidebar = document.querySelector(".icon--close_sidebar");
const main = document.querySelector(".main__block");
const sidebar = document.querySelector(".sidebar__block");

const manageSidebar = () => {
    sidebar.classList.toggle("show");
    iconOpenSidebar.classList.toggle("show");
    iconCloseSidebar.classList.toggle("show");
    main.classList.toggle("hide");
}

iconOpenSidebar.addEventListener("click", manageSidebar);
iconCloseSidebar.addEventListener("click", manageSidebar);