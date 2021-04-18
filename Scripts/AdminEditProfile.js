// Storing JSX variables
const homepageSection = React.createElement(
    "a",
    { href: "http://stormysystem.ddns.net/LibraryManagementSystem/Admin" },
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
        "In order to edit your profile, you should fill the form below completely."
    ),
];
const mailHeader = React.createElement("h1", {}, "Mail Address:");
const mailGuide = React.createElement(
    "div",
    { id: "mailNotice" },
    "This account is linked to this mail address, hence, the mail address cannot be changed!"
);
const accountHeader = React.createElement("h1", {}, "Account ID:");
const accountIdGuide = React.createElement(
    "div",
    { id: "idNotice" },
    "It is the unique identifier of this account, hence, it cannot be changed."
);
const typeHeader = React.createElement("h1", {}, "Account Type: ");
const typeGuide = React.createElement(
    "div",
    { id: "typeNotice" },
    "It is the type of the account which is limited by your position in the organization.  For any changes to be made, please contact an administrator."
);
const profilePictureHeader = React.createElement("h1", {}, "Profile Picture:");
const profilePictureGuide = React.createElement(
    "div",
    { id: "profilePictureNotice" },
    "Just for some creativity but have some restraints as NSFW files will not be accepted in this system."
);
const edit = React.createElement(
    "div",
    {},
    React.createElement("input", {
        type: "submit",
        value: "Edit",
        id: "editButton",
        name: "edit",
    })
);
// Rendering Admin's Edit Profile page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(formHeader, document.getElementById("formHeader"));
ReactDOM.render(mailHeader, document.getElementById("mailHeader"));
ReactDOM.render(mailGuide, document.getElementById("mailGuide"));
ReactDOM.render(accountHeader, document.getElementById("accountHeader"));
ReactDOM.render(accountIdGuide, document.getElementById("accountIdGuide"));
ReactDOM.render(typeHeader, document.getElementById("typeHeader"));
ReactDOM.render(typeGuide, document.getElementById("typeGuide"));
ReactDOM.render(
    profilePictureHeader,
    document.getElementById("profilePictureHeader")
);
ReactDOM.render(
    profilePictureGuide,
    document.getElementById("profilePictureGuide")
);
ReactDOM.render(edit, document.getElementById("edit"));
