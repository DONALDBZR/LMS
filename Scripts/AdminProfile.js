// Storing JSX variables
const homepageSection = React.createElement(
    "a",
    {},
    React.createElement("img", {
        src: "http://stormysystem.ddns.net/LibrarySystem/Images/Logo - 1.png",
        alt: "Homepage",
    })
);
const activities = [
    React.createElement(
        "div",
        { id: "links" },
        React.createElement("a", { href: "./Book_Management" }, "Manage Books")
    ),
    React.createElement(
        "div",
        { id: "links" },
        React.createElement("a", { href: "./Edit_Profile" }, "Edit Profile")
    ),
    React.createElement(
        "div",
        { id: "links" },
        React.createElement("a", { href: "./User_Management" }, "Manage User")
    ),
    React.createElement(
        "div",
        { id: "links" },
        React.createElement("a", { href: "./Loan_Management" }, "Manage Loan")
    ),
];
// Rendering Admin's Profile page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(activities, document.getElementById("activities"));
