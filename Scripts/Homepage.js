// Storing JSX variables
const header = React.createElement(
    "header",
    {},
    React.createElement("h1", {}, "Library Management System")
);
const section = React.createElement(
    "section",
    {},
    React.createElement(
        "div",
        { id: "left" },
        React.createElement("img", { src: "./Images/Education.png" })
    ),
    React.createElement(
        "div",
        { id: "right" },
        React.createElement(
            "div",
            { id: "homeMessage" },
            "Welcome to UDM Online System"
        ),
        React.createElement(
            "div",
            { id: "notice" },
            "To use this system, you should either register or login in the system."
        ),
        React.createElement(
            "div",
            { id: "systemEntries" },
            React.createElement(
                "div",
                {},
                React.createElement("a", { href: "./Register" }, "Register")
            ),
            React.createElement(
                "div",
                {},
                React.createElement("a", { href: "./Login" }, "Login")
            )
        )
    )
);
// Rendering Homepage's Header div
ReactDOM.render(header, document.getElementById("headerHomepage"));
ReactDOM.render(section, document.getElementById("sectionHomepage"));
