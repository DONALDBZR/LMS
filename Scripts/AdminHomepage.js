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
const adminForms = [
    React.createElement(
        "div",
        { id: "report" },
        React.createElement(
            "h1",
            {},
            "To generate and send the report for the management, click on the report button below."
        ),
        React.createElement(
            "form",
            { method: "post" },
            React.createElement(
                "div",
                { id: "reportButton" },
                React.createElement("input", {
                    type: "submit",
                    value: "Report",
                    name: "generateReport",
                })
            )
        )
    ),
    React.createElement(
        "div",
        { id: "mail" },
        React.createElement("h1", {}, "Mail Form"),
        React.createElement(
            "p",
            {},
            "Please fill in this form to send a mail reminder."
        ),
        React.createElement(
            "form",
            { method: "post" },
            React.createElement("input", {
                type: "email",
                name: "mail",
                id: "mailInput",
                placeholder: "E-Mail",
                attribute: "required",
            }),
            React.createElement("input", {
                type: "text",
                name: "message",
                id: "mailMessage",
                placeholder: "Message",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "sendMailButton" },
                React.createElement("input", {
                    type: "submit",
                    value: "Send",
                    id: "sendMail",
                    name: "sendMailReminder",
                })
            )
        )
    ),
];
// Rendering Admin Homepage
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(logout, document.getElementById("logout"));
ReactDOM.render(adminForms, document.getElementById("adminForms"));
