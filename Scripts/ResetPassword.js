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
const resetPasswordForm = React.createElement(
    "div",
    { id: "resetPasswordForm" },
    React.createElement(
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
            "You need to use your UDM Mail to reset your password."
        ),
        React.createElement("input", {
            type: "submit",
            value: "Reset",
            id: "resetPasswordButton",
            name: "resetPassword",
        })
    )
);
// Rendering Reset Passsword page
ReactDOM.render(header, document.getElementById("header"));
ReactDOM.render(
    resetPasswordMessage,
    document.getElementById("resetPasswordMessage")
);
ReactDOM.render(notice, document.getElementById("resetPasswordNotice"));
ReactDOM.render(resetPasswordForm, document.getElementById("form"));
