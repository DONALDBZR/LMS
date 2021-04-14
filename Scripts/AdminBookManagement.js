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
const logout = React.createElement(
    "a",
    {
        href:
            "http://stormysystem.ddns.net/LibraryManagementSystem/Admin/Logout",
    },
    React.createElement("i", { className: "fa fa-sign-out faLogout" })
);
const searchBar = React.createElement(
    "form",
    { method: "get" },
    React.createElement("input", {
        type: "search",
        name: "search",
        id: "searchBarText",
        placeholder: "Search",
    }),
    React.createElement("button", {
        type: "submit",
        className: "fa fa-search faSearch",
    })
);
const addForm = React.createElement(
    "form",
    {
        method: "post",
        enctype: "multipart/form-data",
    },
    React.createElement("h1", {}, "Add Book"),
    React.createElement(
        "p",
        {},
        "In order to add a new book, you should fill the form below completely."
    ),
    React.createElement(
        "div",
        { id: "addIsbnStock" },
        React.createElement(
            "div",
            { id: "addIsbn" },
            React.createElement("input", {
                type: "number",
                name: "inputAddIsbn",
                placeholder: "ISBN",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "addIsbnNotice" },
                "It is the International Standard Book Number which also serves as the identifier of the book."
            )
        ),
        React.createElement(
            "div",
            { id: "addStock" },
            React.createElement("input", {
                type: "number",
                name: "inputAddStock",
                id: "inputaddStock",
                placeholder: "Stock",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "addStockNotice" },
                "It is the amount of book copies that will be in the store in the library."
            )
        )
    ),
    React.createElement(
        "div",
        { id: "addAuthorTitle" },
        React.createElement(
            "div",
            { id: "addAuthor" },
            React.createElement("input", {
                type: "text",
                name: "inputAddAuthor",
                id: "inputAddAuthor",
                placeholder: "Author",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "addAuthorNotice" },
                "The writer of the book"
            )
        ),
        React.createElement(
            "div",
            { id: "addTitle" },
            React.createElement("input", {
                type: "text",
                name: "inputAddTitle",
                id: "inputAddTitle",
                placeholder: "Title",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "addTitleNotice" },
                "The title of the book"
            )
        )
    ),
    React.createElement(
        "div",
        { id: "addPublisherCover" },
        React.createElement(
            "div",
            { id: "addPublisher" },
            React.createElement("input", {
                type: "text",
                name: "inputAddPublisher",
                id: "inputAddPublisher",
                placeholder: "Publisher",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "addPublisherNotice" },
                "The publisher of the book"
            )
        ),
        React.createElement(
            "div",
            { id: "addCover" },
            React.createElement("input", {
                type: "file",
                name: "image",
                id: "inputAddCover",
                accept: "image/*",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "addCoverNotice" },
                "The cover of the book"
            )
        )
    ),
    React.createElement(
        "div",
        { id: "addBookLocationCategory" },
        React.createElement(
            "div",
            { id: "addBookLocation" },
            React.createElement("input", {
                type: "text",
                name: "inputAddBookLocation",
                id: "inputAddBookLocation",
                placeholder: "Book Location",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "addBookLocationNotice" },
                "The location of the book in the library"
            )
        ),
        React.createElement(
            "div",
            { id: "addCategory" },
            React.createElement("input", {
                type: "text",
                name: "inputAddCategory",
                id: "inputAddCategory",
                placeholder: "Category",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "addCategoryNotice" },
                "The category of the book"
            )
        )
    ),
    React.createElement(
        "div",
        { id: "addButton" },
        React.createElement("input", {
            type: "submit",
            value: "Add Book",
            name: "addBook",
        })
    )
);
const updateForm = React.createElement(
    "form",
    {
        method: "post",
        enctype: "multipart/form-data",
    },
    React.createElement("h1", {}, "Update Book"),
    React.createElement(
        "p",
        {},
        "In order to update a book, you should fill the form below completely."
    ),
    React.createElement(
        "div",
        { id: "updateIsbnStock" },
        React.createElement(
            "div",
            { id: "updateIsbn" },
            React.createElement("input", {
                type: "number",
                name: "inputUpdateIsbn",
                id: "inputUpdateIsbn",
                placeholder: "ISBN",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "updateIsbnNotice" },
                "It is the International Standard Book Number which also serves as the identifier of the book."
            )
        ),
        React.createElement(
            "div",
            { id: "updateStock" },
            React.createElement("input", {
                type: "number",
                name: "inputUpdateStock",
                id: "inputUpdateStock",
                placeholder: "Stock",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "updateStockNotice" },
                "It is the amount of book copies that will be in the store of the library."
            )
        )
    ),
    React.createElement(
        "div",
        { id: "updateAuthorTitle" },
        React.createElement(
            "div",
            { id: "updateAuthor" },
            React.createElement("input", {
                type: "text",
                name: "inputUpdateAuthor",
                id: "inputUpdateAuthor",
                placeholder: "Author",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "updateAuthorNotice" },
                "The writer of the book"
            )
        ),
        React.createElement(
            "div",
            { id: "updateTitle" },
            React.createElement("input", {
                type: "text",
                name: "inputUpdateTitle",
                id: "inputUpdateTitle",
                placeholder: "Title",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "updateTitleNotice" },
                "The tileof the book"
            )
        )
    ),
    React.createElement(
        "div",
        { id: "updatePublisherCover" },
        React.createElement(
            "div",
            { id: "updatePubliher" },
            React.createElement("input", {
                type: "text",
                name: "inputUpdatePublisher",
                id: "inputUpdatePublisher",
                placeholder: "Publisher",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "updatePublisherNotice" },
                "The publisher of the book"
            )
        ),
        React.createElement(
            "div",
            { id: "updateCover" },
            React.createElement("input", {
                type: "file",
                name: "image",
                id: "inputUpdateCover",
                accept: "image/*",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "updateCoverNotice" },
                "The cover of the book"
            )
        )
    ),
    React.createElement(
        "div",
        { id: "updateBookLocationCategory" },
        React.createElement(
            "div",
            { id: "updateBookLocation" },
            React.createElement("input", {
                type: "text",
                name: "inputUpdtaeBookLocation",
                id: "inputUpdateBookLocation",
                placeholder: "Book Location",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "updateBookLocationNotice" },
                "The location of the book in the library"
            )
        ),
        React.createElement(
            "div",
            { id: "updateCategory" },
            React.createElement("input", {
                type: "text",
                name: "inputUpdateCategory",
                id: "inputUpdateCategory",
                placeholder: "Category",
                attribute: "required",
            }),
            React.createElement(
                "div",
                { id: "updateCategoryNotice" },
                "The category of the book"
            )
        )
    ),
    React.createElement(
        "div",
        { id: "updatestate" },
        React.createElement(
            "label",
            { for: "inputUpdateState" },
            "What is the state of the book:"
        ),
        React.createElement(
            "select",
            {
                name: "inputUpdateState",
                id: "inputUpdateState",
            },
            React.createElement("option", { value: "damaged" }, "Damaged"),
            React.createElement(
                "option",
                { value: "not-damaged" },
                "Not-Damaged"
            )
        ),
        React.createElement(
            "div",
            { id: "updateStateNotice" },
            "The state of the book"
        )
    ),
    React.createElement(
        "div",
        { id: "updateButton" },
        React.createElement("input", {
            type: "submit",
            value: "Update Book",
            name: "updateBook",
        })
    )
);
// Rendering the page
ReactDOM.render(homepageSection, document.getElementById("homepageSection"));
ReactDOM.render(logout, document.getElementById("logout"));
ReactDOM.render(searchBar, document.getElementById("searchBar"));
ReactDOM.render(addForm, document.getElementById("addForm"));
ReactDOM.render(updateForm, document.getElementById("updateForm"));
