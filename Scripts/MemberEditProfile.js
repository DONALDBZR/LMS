// Storing JSX variables
const homepageSection = React.createElement(
    "a",
    { href: "http://stormysystem.ddns.net/LibraryManagementSystem/Member" },
    React.createElement("img", {
        src:
            "http://stormysystem.ddns.net/LibraryManagementSystem/Images/Logo - 1.png",
        alt: "Homepage",
    })
);
const formHeader = [
    React.createElement("h1", {}, "Edit Profile"),
    React.createElement(
        "p",
        {},
        "In order to edit your profile, you should fill in the form below completely."
    ),
];
const password = React.createElement(
    "div",
    { id: "password" },
    React.createElement("h1", { id: "contents" }, "Password:"),
    React.createElement(
        "div",
        { id: "contents" },
        React.createElement("input", {
            type: "password",
            name: "oldPassword",
            id: "oldPassword",
            placeholder: "Password",
            attribute: "required",
        }),
        React.createElement("input", {
            type: "password",
            name: "newPassword",
            id: "newPassword",
            placeholder: "New Password",
            attribute: "required",
        }),
        React.createElement("input", {
            type: "password",
            name: "confirmNewPassword",
            id: "confirmNewPassword",
            placeholder: "Confirm New Password",
            attribute: "required",
        }),
        React.createElement(
            "div",
            { id: "passwordNotice" },
            "It allows you to actually get access into the system."
        )
    )
);
const editProfileButton = React.createElement("input", {
    type: "submit",
    value: "Edit",
    id: "editButton",
    name: "edit",
});
// Rendering Member's Edit Profile page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(formHeader, document.getElementById("formHeader"));
ReactDOM.render(password, document.getElementById("passwordSection"));
ReactDOM.render(
    editProfileButton,
    document.getElementById("editProfileButton")
);
