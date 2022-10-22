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
const logout = React.createElement(
    "a",
    {
        href:
            "http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Logout",
    },
    React.createElement("i", { className: "fa fa-sign-out faLogout" })
);
const searchBar = React.createElement(
    "form",
    { method: "get" },
    React.createElement("input", {
        type: "search",
        name: "search",
        id: "searchBarText",
        placeholder: "Search",
    }),
    React.createElement("button", {
        type: "submit",
        className: "fa fa-search faSearch",
    })
);
// Rendering the page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(logout, document.getElementById("logout"));
ReactDOM.render(searchBar, document.getElementById("searchBar"));
