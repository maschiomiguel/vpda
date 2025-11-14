import $ from "jquery";

export default class extends window.Controller {
    /**
     *
     */
    connect() {
        const selector = this.element.querySelector(".tinymce").id;
        const input = this.element.querySelector("input");

        let plugins = "table link";
        let toolbar =
            "formatselect | h2 h3 bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | ltr rtl";

        // remove cache
        tinymce.remove(`#${selector}`);

        let config = {
            branding: false,
            selector: `#${selector}`,
            theme: this.element.dataset.theme,
            language: this.element.dataset.language,
            min_height: 250,
            height: this.element.dataset.height,
            max_height: 800,
            plugins,
            toolbar,
            menubar: "format table",
            insert_toolbar: "table",
            convert_urls: false,
            image_caption: true,
            image_title: true,
            image_class_list: [
                {
                    title: "None",
                    value: "",
                },
                {
                    title: "Responsive",
                    value: "img-fluid",
                },
            ],
            setup: (element) => {
                element.on("BeforeSetContent", function (e) {
                    if (e.content.startsWith("<table")) {
                        e.content =
                            '<div class="table-responsive">' +
                            e.content +
                            "</div>";
                    }
                });
                element.on("change", () => {
                    $(input).val(element.getContent());
                });
            },
            images_upload_handler: this.upload,
            promotion: false,
        };

        tinymce.init(config);
    }

    /**
     *
     * @param blobInfo
     * @param success
     */
    upload(blobInfo, success) {
        const data = new FormData();
        data.append("file", blobInfo.blob());

        let prefix = function (path) {
            let prefix = document.head.querySelector(
                'meta[name="dashboard-prefix"]'
            );
            // Remove double slashes from url
            let pathname = `${prefix.content}${path}`.replace(/\/\/+/g, "/");
            return `${location.protocol}//${location.hostname}${
                location.port ? `:${location.port}` : ""
            }${pathname}`;
        };

        axios
            .post(prefix("/systems/files"), data)
            .then((response) => {
                success(response.data.url);
            })
            .catch((error) => {
                alert("Validation error : File upload error");
                console.warn(error);
            });
    }

    disconnect() {
        tinymce.remove(`#${this.element.querySelector(".tinymce").id}`);
    }
}
