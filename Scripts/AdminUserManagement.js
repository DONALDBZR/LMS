// Storing JSX variables
const homepageSection = React.createElement(
    "a",
    { href: "http://stormysystem.ddns.net/LibraryManagementSystem/Admin" },
    React.createElement("img", {
        src:
            "http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo - 1.png",
        alt: "Homepage",
    })
);
const searchBar = React.createElement(
    "form",
    { method: "get" },
    React.createElement("input", {
        type: "search",
        name: "search",
        id: "searchBarText",
    }),
    React.createElement("button", {
        type: "submit",
        className: "fa fa-search faSearch",
    })
);
const logout = React.createElement(
    "a",
    {
        href:
            "http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Logout",
    },
    React.createElement("i", { className: "fa fa-sign-out faLogout" })
);
// Rendering Admin's User Management page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(searchBar, document.getElementById("searchBar"));
ReactDOM.render(logout, document.getElementById("logout"));
