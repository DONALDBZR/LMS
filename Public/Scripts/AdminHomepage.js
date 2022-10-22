// Storing JSX variables
const homepageSection = React.createElement(
    "a",
    { href: "./" },
    React.createElement("img", {
        src: "../Images/Logo - 1.png",
        alt: "Homepage",
    })
);
const logout = React.createElement(
    "a",
    { href: "./Logout" },
    React.createElement("i", { className: "fa fa-sign-out faLogoutCustom" })
);
const user = [
    React.createElement(
        "div",
        { id: "logo" },
        React.createElement("i", { className: "fa fa-user faUser" })
    ),
    React.createElement("div", { id: "description" }, "Registered Users"),
];
const book = [
    React.createElement(
        "div",
        { id: "logo" },
        React.createElement("i", { className: "fa fa-book faBook" })
    ),
    React.createElement("div", { id: "description" }, "Books Offered"),
];
const loan = [
    React.createElement(
        "div",
        { id: "logo" },
        React.createElement("i", { className: "fa fa-file faFile" })
    ),
    React.createElement("div", { id: "description" }, "Loans taken"),
];
const bannedUser = [
    React.createElement(
        "div",
        { id: "logo" },
        React.createElement("i", { className: "fa fa-user-times faBannedUser" })
    ),
    React.createElement("div", { id: "description" }, "Banned Users"),
];
const damagedBook = [
    React.createElement(
        "div",
        { id: "logo" },
        React.createElement("i", { className: "fa fa-ban faDamagedBook" })
    ),
    React.createElement("div", { id: "description" }, "Damaged Books"),
];
const overdue = [
    React.createElement(
        "div",
        { id: "logo" },
        React.createElement("i", {
            className: "fa fa-exclamation-triangle faOverdue",
        })
    ),
    React.createElement("div", { id: "description" }, "Overdued Loans"),
];
const generateReport = React.createElement("form", { method: "get" }, [
    React.createElement("button", {
        type: "submit",
        className: "fa fa-file faReport",
        name: "report",
    }),
    React.createElement("div", null, "Report"),
]);
// Rendering Admin Homepage
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(logout, document.getElementById("logout"));
ReactDOM.render(user, document.getElementById("user"));
ReactDOM.render(book, document.getElementById("book"));
ReactDOM.render(loan, document.getElementById("loan"));
ReactDOM.render(bannedUser, document.getElementById("bannedUser"));
ReactDOM.render(damagedBook, document.getElementById("damagedBook"));
ReactDOM.render(overdue, document.getElementById("overdue"));
ReactDOM.render(generateReport, document.getElementById("generateReport"));
