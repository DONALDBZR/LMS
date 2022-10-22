// Storing JSX variables
const header = React.createElement(
    "header",
    {},
    React.createElement("img", {
        src:
            "http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo - 1.png",
        alt: "Logo",
    })
);
const message = React.createElement(
    "h1",
    { id: "success" },
    "You have been successfully logged out from the system!"
);
// Rendering Member's Logout page
ReactDOM.render(header, document.getElementById("header"));
ReactDOM.render(message, document.getElementById("message"));
