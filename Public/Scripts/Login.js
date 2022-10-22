// Storing JSX variables
const header = React.createElement(
    "header",
    {},
    React.createElement("h1", {}, "Library Management System")
);
const loginMessage = React.createElement(
    "div",
    { id: "homeMessage" },
    "Welcome to UDM Online System's Login page"
);
const notice = React.createElement(
    "div",
    { id: "notice" },
    "To log into this system, you should fill this form properly."
);

const passwordSection = React.createElement(
    "div",
    { id: "passwordSection" },
    "You have forgot your password?  Reset it ",
    React.createElement("a", { href: "../Reset_Password" }, "Here")
);
// Rendering Login page
ReactDOM.render(header, document.getElementById("header"));
ReactDOM.render(loginMessage, document.getElementById("loginMessage"));
ReactDOM.render(notice, document.getElementById("loginNotice"));
ReactDOM.render(passwordSection, document.getElementById("loginReset"));
