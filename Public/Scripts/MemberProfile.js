// Storing JSX variables
const homepageSection = React.createElement(
    "a",
    { href: "../" },
    React.createElement("img", {
        src: "http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo - 1.png",
        alt: "Homepage",
    })
);
const activities = React.createElement(
    "div",
    { id: "activities" },
    React.createElement(
        "div",
        { id: "links" },
        React.createElement(
            "a",
            { href: "./Borrowed_Books" },
            "View Borrowed Books"
        )
    ),
    React.createElement(
        "div",
        { id: "links" },
        React.createElement("a", { href: "./Edit_Profile" }, "Edit Profile")
    ),
    React.createElement(
        "div",
        { id: "links" },
        React.createElement(
            "a",
            { href: "./Reserved_Books" },
            "View Reserved Books"
        )
    )
);
const profilePictureLabel = React.createElement(
    "div",
    {},
    React.createElement("h1", {}, "Profile Picture:")
);
const mailAddressLabel = React.createElement(
    "div",
    {},
    React.createElement("h1", {}, "Mail Address:")
);
const typeLabel = React.createElement(
    "div",
    {},
    React.createElement("h1", {}, "Account Type:")
);
// Rendering Member's profile page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(activities, document.getElementById("actions"));
ReactDOM.render(
    profilePictureLabel,
    document.getElementById("profilePictureLabel")
);
ReactDOM.render(mailAddressLabel, document.getElementById("mailAddressLabel"));
ReactDOM.render(typeLabel, document.getElementById("typeLabel"));
