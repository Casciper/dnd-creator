import Cropper from 'cropperjs';
import tingle from 'tingle.js'

export default class CropperRocont extends window.Controller {

    static targets = [
        "source",
        "upload"
    ];

    /**
     *
     */
    connect() {
        let image = this.data.get('url') ? this.data.get('url') : this.data.get(`value`);

        if (image) {
            this.element.querySelector('.cropper-preview').src = image;
        } else {
            this.element.querySelector('.cropper-preview').classList.add('none');
            this.element.querySelector('.cropper-remove').classList.add('none');
        }
    }

    /**
     *
     * @returns {Modal}
     */
    getModal() {
        let width = this.data.get('width');
        let height = this.data.get('height');

        let html = `<div class="modal-to-clone" role="dialog">
                                <div class="modal-dialog modal-fullscreen-md-down modal-lg">
                                    <div class="modal-content-wrapper">
                                        <div class="modal-content">
                                            <div class="position-relative">
                                                <img class="upload-panel">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`

        this.modal = new tingle.modal({
            footer: true,
            stickyFooter: false,
            closeMethods: ['overlay'],
            closeLabel: "Close",
            cssClass: ['custom-class-1', 'custom-class-2'],
            onOpen: function () {
                this.setContent(html);
                let cropPanel = document.querySelector('.upload-panel');

                cropPanel.width = width;
                cropPanel.height = height;

                window.cropper = new Cropper(cropPanel, {
                    viewMode: 2,
                    aspectRatio: width / height,
                    minContainerHeight: 500,
                });

            },
            onClose: function () {
                this.destroy();
            },
            beforeClose: function () {
                return true;
            }
        });

        this.modal.addFooterBtn('Закрыть', 'btn btn-link', () => {
            this.modal.close()
        });

        this.modal.addFooterBtn('Обрезать', 'btn btn-default', () => {
            this.crop(this.modal)
        });

        return this.modal;
    }

    /**
     * Event for uploading image
     *
     * @param event
     */
    upload(event) {
        let maxFileSize = this.data.get('max-file-size');
        if (maxFileSize !== null && event.target.files[0].size / 1024 / 1024 > maxFileSize) {
            this.alert('Validation error', `The download file is too large. Max size: ${maxFileSize} MB`);
            event.target.value = null;
            return;
        }
        event.target.classList.add('selectedCropper')

        this.getModal().open();

        let reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);
        reader.onloadend = () => {
            window.cropper.replace(reader.result)
        };

        document.querySelector('.cropper-path').dispatchEvent(new Event("change"));
    }


    /**
     * Action on click button "Crop"
     */
    crop(modal) {
        let data = window.cropper.getData();

        window.cropper.getCroppedCanvas( {fillColor: '#fff'}).toBlob((blob) => {
            const formData = new FormData();
            formData.append('file', blob);
            formData.append('storage', this.data.get('storage'));
            formData.append('group', this.data.get('groups'));
            formData.append('path', this.data.get('path'));
            formData.append('acceptedFiles', this.data.get('accepted-files'));
            formData.append('width', this.data.get('width'));
            formData.append('height', this.data.get('height'));

            let parent = document.querySelector('.selectedCropper').closest('.cropper-parent');

            window.axios.post(this.prefix('/systems/files'), formData)
                .then((response) => {
                    let image = response.data.url;
                    let targetValue = this.data.get('target');

                    parent.querySelector('.cropper-preview').src = image;
                    parent.querySelector('.cropper-preview').classList.remove('none');
                    parent.querySelector('.cropper-remove').classList.remove('none');
                    parent.querySelector('.cropper-path').value = response.data[targetValue];

                    // add event for listener
                    parent.querySelector('.cropper-path').dispatchEvent(new Event("change"));

                    modal.close();
                    document.querySelector('.selectedCropper').classList.remove('selectedCropper')
                })
                .catch((error) => {
                    this.alert('Validation error', 'File upload error');
                    console.warn(error);
                });
        }, 'image/jpeg');

    }

    /**
     *
     */
    clear(event) {
        event.target.classList.add('selectedCropper')
        let parent = document.querySelector('.selectedCropper').closest('.cropper-parent');

        parent.querySelector('.cropper-path').value = '';
        parent.querySelector('.cropper-preview').src = '';
        parent.querySelector('.cropper-preview').classList.add('none');
        parent.querySelector('.cropper-remove').classList.add('none');

        event.target.classList.remove('selectedCropper')
    }

    /**
     * Action on click buttons
     */
    moveleft() {
        this.cropper.move(-10, 0);
    }

    moveright() {
        this.cropper.move(10, 0);
    }

    moveup() {
        this.cropper.move(0, -10);
    }

    movedown() {
        this.cropper.move(0, 10);
    }

    zoomin() {
        this.cropper.zoom(0.1);
    }

    zoomout() {
        this.cropper.zoom(-0.1);
    }

    rotateleft() {
        this.cropper.rotate(-5);
    }

    rotateright() {
        this.cropper.rotate(5);
    }

    scalex() {
        const dataScaleX = this.element.querySelector('.cropper-dataScaleX');
        this.cropper.scaleX(-dataScaleX.value);
    }

    scaley() {
        const dataScaleY = this.element.querySelector('.cropper-dataScaleY');
        this.cropper.scaleY(-dataScaleY.value)
    }

    aspectratiowh() {
        this.cropper.setAspectRatio(this.data.get('width') / this.data.get('height'));
    }

    aspectratiofree() {
        this.cropper.setAspectRatio(NaN);
    }

}
