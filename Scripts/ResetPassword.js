// Storing JSX variables
const header = React.createElement(
    "header",
    {},
    React.createElement("h1", {}, "Library Management System")
);
const resetPasswordMessage = React.createElement(
    "div",
    { id: "homeMessage" },
    "Welcome to the page which will help you to reset your password."
);
const notice = React.createElement(
    "div",
    { id: "notice" },
    "To reset your password, you should fill this form properly."
);

// Rendering Reset Passsword page
ReactDOM.render(header, document.getElementById("header"));
ReactDOM.render(
    resetPasswordMessage,
    document.getElementById("resetPasswordMessage")
);
ReactDOM.render(notice, document.getElementById("resetPasswordNotice"));
