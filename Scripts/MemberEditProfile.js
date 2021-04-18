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
const editProfileButton = React.createElement("input", {
    type: "submit",
    value: "Edit",
    id: "editButton",
    name: "edit",
});
// Rendering Member's Edit Profile page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(formHeader, document.getElementById("formHeader"));
ReactDOM.render(
    editProfileButton,
    document.getElementById("editProfileButton")
);
