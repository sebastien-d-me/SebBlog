// Manage the sidebar
const iconSidebarOpen = document.querySelector(".icon__sidebar--open");
const iconSidebarClose = document.querySelector(".icon__sidebar--close");
const main = document.querySelector(".main__block");
const sidebar = document.querySelector(".sidebar__block");

const manageSidebar = () => {
    sidebar.classList.toggle("show");
    iconSidebarOpen.classList.toggle("show");
    iconSidebarClose.classList.toggle("show");
    main.classList.toggle("hide");
}

iconSidebarOpen.addEventListener("click", manageSidebar);
iconSidebarClose.addEventListener("click", manageSidebar);