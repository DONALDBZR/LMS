// Storing JSX Variables
const header = React.createElement(
    "header",
    {},
    React.createElement("h1", {}, "Library Management System")
);
const homeMessage = React.createElement(
    "div",
    { id: "homeMessage" },
    "Welcome to UDM Online System's Registration page"
);
const notice = React.createElement(
    "div",
    { id: "notice" },
    "To register in this system, you should fill this form properly."
);
const registrationForm = React.createElement(
    "form",
    { method: "post" },
    React.createElement("input", {
        type: "email",
        name: "mailAddress",
        id: "mailAddress",
        placeholder: "Mail Address",
        attribute: "required",
    }),
    React.createElement(
        "div",
        { id: "mailAddressNotice" },
        "You need to use your UDM Mail to register into this system."
    ),
    React.createElement("input", {
        type: "text",
        name: "studentId",
        id: "studentId",
        placeholder: "Student ID",
    }),
    React.createElement(
        "div",
        { id: "studentIdNotice" },
        "You need to use either your NTA bus pass or your UDM Student ID to register into the system, if you are a student. Staff members do not need to fill this field."
    ),
    React.createElement("input", {
        type: "submit",
        value: "Register",
        id: "registerButton",
        name: "register",
    })
);
const loginSection = React.createElement(
    "div",
    { id: "loginSection" },
    "Already have an account? ",
    React.createElement("a", { href: "../Login" }, "Login Here")
);
// Rendering Register page
ReactDOM.render(header, document.getElementById("header"));
ReactDOM.render(homeMessage, document.getElementById("registerMessage"));
ReactDOM.render(notice, document.getElementById("registerNotice"));
ReactDOM.render(registrationForm, document.getElementById("registerForm"));
ReactDOM.render(loginSection, document.getElementById("registerLoginSection"));
