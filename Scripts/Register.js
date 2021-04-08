// Storing JSX Variables
const studentRegistrationForm = React.createElement(
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
        placeholder: "Student ID",
        attribute: "required",
        id: "studentId",
    }),
    React.createElement(
        "div",
        { id: "studentIdNotice" },
        "You need to use either your NTA bus pass or your UDM Student ID to register into the system."
    ),
    React.createElement("input", {
        type: "submit",
        value: "Register",
        id: "registerButton",
        name: "register",
        className: "student",
        onClick: requestServerAttention(this.className),
    })
);
const staffRegistrationForm = React.createElement(
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
    React.createElement("label", { for: "type" }, "Staff's Type:"),
    React.createElement(
        "select",
        {
            name: "type",
            id: "type",
            attribute: "required",
        },
        [
            React.createElement("option", { value: "" }, null),
            React.createElement("option", { value: "academics" }, "Academics"),
            React.createElement(
                "option",
                { value: "non-academics" },
                "Non-Academics"
            ),
        ]
    ),
    React.createElement(
        "div",
        { id: "typeNotice" },
        "You need to chooose according to the role that you occupy in the organization"
    ),
    React.createElement("input", {
        type: "submit",
        value: "Register",
        id: "registerButton",
        name: "register",
        className: "staff",
        onClick: requestServerAttention(this.className),
    })
);
// Rendering Register page
ReactDOM.render(
    studentRegistrationForm,
    document.getElementById("studentRegistrationForm")
);
ReactDOM.render(
    staffRegistrationForm,
    document.getElementById("staffRegistrationForm")
);
