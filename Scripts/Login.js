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
const loginForm = React.createElement(
    "div",
    { id: "loginForm" },
    React.createElement(
        "form",
        { method: "post" },
        React.createElement("input", {
            type: "email",
            name: "mailAddress",
            placeholder: "Mail Address",
            attribute: "required",
            id: "mailAddress",
        }),
        React.createElement(
            "div",
            { id: "mailAddressNotice" },
            "You need to use your UDM Mail to log into this system."
        ),
        React.createElement("input", {
            type: "password",
            name: "password",
            id: "password",
            placeholder: "Password",
            attribute: "required",
        }),
        React.createElement(
            "div",
            { id: "passwordNotice" },
            "You need to use your password to log into the system."
        ),
        React.createElement("input", {
            type: "submit",
            value: "Log In",
            id: "loginButton",
            name: "login",
        })
    )
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
ReactDOM.render(loginForm, document.getElementById("form"));
ReactDOM.render(passwordSection, document.getElementById("loginReset"));
