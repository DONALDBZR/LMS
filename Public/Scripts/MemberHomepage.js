// Storing JSX variables
const homepageSection = React.createElement(
    "a",
    { href: "../Member" },
    React.createElement("img", {
        src: "../Images/Logo - 1.png",
        alt: "Homepage",
    })
);
const logout = React.createElement(
    "a",
    { href: "./Logout" },
    React.createElement("i", { className: "fa fa-sign-out faLogout" })
);
// Rendering Member's Homepage page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(logout, document.getElementById("logout"));
