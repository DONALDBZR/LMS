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
    React.createElement(
        "div",
        { id: "personBook" },
        React.createElement(
            "div",
            { id: "person" },
            React.createElement("h1", { id: "contents" }, "User's Mail:"),
            React.createElement("input", {
                type: "email",
                name: "person",
                id: "searchPerson",
                placeholder: "User's Mail",
                attribute: "required",
            })
        ),
        React.createElement(
            "div",
            { id: "book" },
            React.createElement("h1", { id: "contents" }, "Book's Title"),
            React.createElement("input", {
                type: "text",
                name: "book",
                id: "searchBook",
                placeholder: "Book's Title",
                attribute: "required",
            })
        )
    ),
    React.createElement(
        "div",
        { id: "search" },
        React.createElement("input", {
            type: "submit",
            name: "search",
            value: "Search",
            id: "searchButton",
        })
    )
);
// Rendering the document
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(logout, document.getElementById("logout"));
ReactDOM.render(searchBar, document.getElementById("searchBar"));
