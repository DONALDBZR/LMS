class LibraryManagementSystem {
    constructor() {
        /**
         * @type {string}
         */
        this.__requestUniformRequestInformation;
        /**
         * @type {string}
         */
        this.__bodyId;
        /**
         * @type {string[]}
         */
        this._stylesheets = [
            "/Public/Stylesheets/lms.css",
            "/Public/Stylesheets/desktop.css",
            "/Public/Stylesheets/mobile.css",
            "/Public/Stylesheets/tablet.css"
        ];
        /**
         * @type {string}
         */
        this.__relationship;
        /**
         * @type {string}
         */
        this.__mimeType;
        /**
         * @type {string[]}
         */
        this._mediaQueries = [
            "screen and (min-width: 1024px)",
            "screen and (min-width: 640px) and (max-width: 1023px)",
            "screen and (max-width: 639px)"
        ];
        /**
         * @type {number}
         */
        this.__httpStatusCode;
        this.init();
    }
    /**
     * @returns {string}
     */
    getRequestUniformRequestInformation() {
        return this.__requestUniformRequestInformation;
    }
    /**
     * @param {string} request_uniform_information 
     */
    setRequestUniformRequestInformation(request_uniform_information) {
        this.__requestUniformRequestInformation = request_uniform_information;
    }
    /**
     * @returns {string}
     */
    getBodyId() {
        return this.__bodyId;
    }
    /**
     * @param {string} body_id 
     */
    setBodyId(body_id) {
        this.__bodyId = body_id;
    }
    /**
     * @returns {string}
     */
    getRelationship() {
        return this.__relationship;
    }
    /**
     * @param {string} relationship 
     */
    setRelationship(relationship) {
        this.__relationship = relationship;
    }
    /**
     * @returns {string}
     */
    getMimeType() {
        return this.__mimeType;
    }
    /**
     * @param {string} mime_type 
     */
    setMimeType(mime_type) {
        this.__mimeType = mime_type;
    }
    /**
     * @returns {int}
     */
    getHttpStatusCode() {
        return this.__httpStatusCode;
    }
    /**
     * @param {int} http_status_code 
     */
    setHttpStatusCode(http_status_code) {
        this.__httpStatusCode = http_status_code;
    }
    init() {
        const body = document.body;
        this.setHttpStatusCode(parseInt(document.getElementsByTagName("title")[0].innerHTML));
        this.setRequestUniformRequestInformation(window.location.pathname);
        if (!isNaN(this.getHttpStatusCode())) {
            switch (this.getHttpStatusCode()) {
                case 404:
                    this.setBodyId(this.getHttpStatusCode());
                    break;
            }
        } else {
            if (this.getRequestUniformRequestInformation() == "/") {
                this.setBodyId("Homepage");
            } else {
                this.setBodyId(this.getRequestUniformRequestInformation().replaceAll("/", ""));
            }
        }
        body.id = this.getBodyId();
        this.style();
    }
    style() {
        this.setRelationship("stylesheet");
        this.setMimeType("text/css");
        for (let index = 0; index < this._stylesheets.length; index++) {
            const link = document.createElement("link");
            link.href = this._stylesheets[index];
            if (link.href.includes("desktop")) {
                link.media = this._mediaQueries[0];
            } else if (link.href.includes("mobile")) {
                link.media = this._mediaQueries[2];
            } else if (link.href.includes("tablet")) {
                link.media = this._mediaQueries[1];
            }
            link.rel = this.getRelationship();
            link.type = this.getMimeType();
            document.head.appendChild(link);
        }
    }
}
const application = new LibraryManagementSystem();