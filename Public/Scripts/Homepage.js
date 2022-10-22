class Application extends React.Component {
    render() {
        return [<Header />, <Main />];
    }
}
class Header extends Application {
    render() {
        return (
            <header>
                <h1>Library Management System</h1>
            </header>
        );
    }
}
class Main extends Application {
    render() {
        return (
            <main>
                <div id="left">
                    <img src="/Public/Images/Education.png" />
                </div>
                <div id="right">
                    <div id="message">Welcome to UDM Online System</div>
                    <div id="notice">To use this system, you should either register or loginr in the system!</div>
                    <div id="systemEntries">
                        <div>
                            <a href="/Register">Register</a>
                        </div>
                        <div>
                            <a href="/Login">Login</a>
                        </div>
                    </div>
                </div>
            </main>
        );
    }
}
ReactDOM.render(<Application />, document.body);