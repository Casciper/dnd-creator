export default class extends window.Controller {
    connect() {
        const selector = "#" + this.element.querySelector('.tinymce').id;

        // For Cache
        tinymce.remove(selector);

        tinymce.init({
            selector: selector,
            language: this.element.dataset.language,
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
            toolbar: 'undo redo bold italic underline strikethrough fontfamily fontsize blocks alignleft aligncenter alignright alignjustify outdent indent  numlist bullist forecolor backcolor removeformat pagebreak charmap emoticons fullscreen code preview print insertfile image media link anchor codesample ltr rtl',
            menubar: false,
            //content_css: '/app/css/content-style.css',
            //importcss_append: true,
            table_header_type: 'section',
            images_upload_handler: this.example_image_upload_handler
        });
    }

    example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();

        let prefix = function (path) {
            let prefix = document.head.querySelector('meta[name="dashboard-prefix"]');
            let pathname = `${prefix.content}${path}`.replace(/\/\/+/g, '/')
            return `${location.protocol}//${location.hostname}${location.port ? `:${location.port}` : ''}${pathname}`;
        };
        let csrf_token = document.head.querySelector('meta[name="csrf_token"]').getAttribute("content");

        xhr.withCredentials = false;
        xhr.open('POST', prefix('/systems/files'));

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            if (xhr.status === 403) {
                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                return;
            }

            if (xhr.status < 200 || xhr.status >= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
            }

            const json = JSON.parse(xhr.responseText);
            json.location = json.relativeUrl;

            if (!json || typeof json.location != 'string') {
                reject('Invalid JSON: ' + xhr.responseText);
                return;
            }

            resolve(json.location);
        };

        xhr.onerror = () => {
            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };

        const formData = new FormData();
        formData.append('_token', csrf_token);
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    });

    disconnect(selector) {
        tinymce.remove(selector);
    }
}
