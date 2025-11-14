import { Dropzone } from 'dropzone';
import Sortable from 'sortablejs';
import Compressor from 'compressorjs';
import $ from "jquery";

export default class extends window.Controller {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        'search',
        'name',
        'original',
        'alt',
        'description',
        'url',
        'loadmore',
    ];

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.attachments = {};
        this.mediaList = [];
        this.allMediaList = {};
    }

    initialize() {
        this.page = 1
    }

    /**
     *
     * @returns {string}
     */
    get dropname() {
        return this.element.querySelector('#' + this.data.get('id'));
    }

    /**
     *
     * @returns {string|{id: *}}
     */
    get activeAttachment() {
        return {
            id: this.activeAchivmentId,
            name: this[this.getAttachmentTargetKey('name')].value || '',
            alt: this[this.getAttachmentTargetKey('alt')].value || '',
            description: this[this.getAttachmentTargetKey('description')].value || '',
            original_name: this[this.getAttachmentTargetKey('original')].value || '',
        };
    }

    /**
     *
     * @param data
     */
    set activeAttachment(data) {
        this.activeAchivmentId = data.id;

        this[this.getAttachmentTargetKey('name')].value = data.name || '';
        this[this.getAttachmentTargetKey('original')].value = data.original_name || '';
        this[this.getAttachmentTargetKey('alt')].value = data.alt || '';
        this[this.getAttachmentTargetKey('description')].value = data.description || '';

        this.data.set('url', data.url);
    }

    /**
     *
     */
    openLink(event) {
        event.preventDefault();
        window.open(this.data.get('url'));
    }

    /**
     *
     */
    connect() {
        this.initDropZone();
        this.initSortable();
    }

    /**
     *
     */
    save() {
        const attach = this.activeAttachment;
        const dropname = this.dropname;

        let loadMediaModal = Bootstrap.Modal.getOrCreateInstance(dropname.querySelector(`.attachment.modal`));
        loadMediaModal.toggle();

        const name = attach.name + attach.id;

        if (this.attachments.hasOwnProperty(name)) {
            this.attachments[name].name = attach.name;
            this.attachments[name].alt = attach.alt;
            this.attachments[name].description = attach.description;
            this.attachments[name].original_name = attach.original_name;
        }

        axios
            .put(this.prefix(`/systems/files/post/${attach.id}`), attach)
            .then();
    }

    /**
     *
     * @param dataKey
     * @returns {string}
     */
    getAttachmentTargetKey(dataKey) {
        return `${dataKey}Target`;
    }

    /**
     *
     * @param data
     */
    loadInfo(data) {
        const name = data.name + data.id;

        if (!this.attachments.hasOwnProperty(name)) {
            this.attachments[name] = data;
        }
        this.activeAttachment = data;
    }

    /**
     *
     */
    resortElement() {
        const items = {};
        const self = this;
        const dropname = this.dropname;
        const CancelToken = axios.CancelToken;

        if (typeof this.cancelRequest === 'function') {
            this.cancelRequest();
        }

        let elements = dropname.querySelectorAll(`:scope .file-sort`);
        elements.forEach((value, index) => {
            const id = value.getAttribute('data-file-id');
            items[id] = index;
        });

        axios
            .post(this.prefix('/systems/files/sort'), {
                files: items,
            }, {
                cancelToken: new CancelToken(function executor(c) {
                    self.cancelRequest = c;
                }),
            })
            .then();
    }

    /**
     *
     */
    initSortable() {
        new Sortable(this.element.querySelector('.sortable-dropzone'), {
            animation: 150,
            onEnd: () => {
                this.resortElement();
            },
        });
    }

    /**
     *
     * @param dropname
     * @param name
     * @param file
     */
    addSortDataAtributes(dropname, name, file, fileData) {

        // se existe um elemento preview, dá pra inserir a classe diretamente
        // assim, o arquivo inserido não precisa ser necessariamente o ultimo
        if (fileData) {
            let preview = fileData.previewElement;
            preview.setAttribute('data-file-id', file.id);
            preview.classList.add('file-sort');
        }
        else {
            const items = dropname.querySelectorAll(' .dz-complete');

            if (items !== null && items.item(items.length - 1) !== null) {
                items.item(items.length - 1).setAttribute('data-file-id', file.id);
                items.item(items.length - 1).classList.add('file-sort');
            }
        }

        const node = document.createElement('input');
        node.setAttribute('type', 'hidden');
        node.setAttribute('name', name + '[]');
        node.setAttribute('value', file.id);
        node.classList.add('files-' + file.id);
        dropname.appendChild(node);

    }

    /**
     *
     */
    initDropZone() {
        const self = this;
        const data = this.data.get('data') && JSON.parse(this.data.get('data'));
        const storage = this.data.get('storage');
        const name = this.data.get('name');
        const loadInfo = this.loadInfo.bind(this);
        const dropname = this.dropname;
        const groups = this.data.get('groups');
        const uploadPath = this.data.get('path');
        const multiple = !!this.data.get('multiple');
        const prepend = !!this.data.get('prepend');
        const isMediaLibrary = this.data.get('is-media-library');

        const removeButtonTemplate = this.element.querySelector('#' + this.data.get('id') + '-remove-button').innerHTML.trim();
        const editButtonTemplate = this.element.querySelector('#' + this.data.get('id') + '-edit-button').innerHTML.trim();

        const controller = this;

        const urlDelete = this.prefix(`/systems/files/`);

        const resizeWidth = this.data.get('resize-width');
        const resizeHeight = this.data.get('resize-height');

        const shouldCompress = !!this.data.get('compress');
        const keepOriginalExtension = !!this.data.get('keep-original-extension');

        let maxFileSize = this.data.get('max-file-size');
        const maxFileSizeOriginal = maxFileSize;
        if (shouldCompress) {
            maxFileSize += 2;
        }

        let filesInited = false

        this.dropZone = new Dropzone(this.element.querySelector('#' + this.data.get('id')), {
            url: this.prefix('/systems/files'),
            method: 'post',
            uploadMultiple: true,
            maxFilesize: maxFileSize,
            maxFiles: multiple ? this.data.get('max-files') : 1,
            prepend: this.data.get('prepend'),
            timeout: this.data.get('timeout'),
            acceptedFiles: this.data.get('accepted-files'),
            resizeQuality: this.data.get('resize-quality'),
            resizeWidth: resizeWidth,
            resizeHeight: resizeHeight,
            paramName: 'files',

            previewsContainer: dropname.querySelector('.visual-dropzone'),
            addRemoveLinks: false,
            dictFileTooBig: 'File is big',
            autoDiscover: false,

            transformFile(file, done) {
                let self = this;

                if (
                  file.type.match(/image.*/) &&
                  !file.type.match(/svg/) &&
                  shouldCompress
                ) {
                    let options = {
                        quality: 0.8,
                        checkOrientation: true,
                        success(result) {
                            let new_size = result.size;
                            let old_size = file.size;

                            const maxFileSizeBytes = maxFileSizeOriginal * 1024 * 1024;
                            if (new_size > maxFileSizeBytes && old_size > maxFileSizeBytes) {
                                controller.alert('Erro de validação', 'O arquivo enviado e comprimido é muito pesado <br> Tamanho máximo permitido: ' + maxFileSizeOriginal + 'MB');
                                self.removeFile(file);
                                return;
                            }

                            // somente upa a imagem comprimida se ela for menor
                            if (new_size < old_size) {
                                done(result);
                            }
                            else {
                                done(file);
                            }
                        },
                        error(err) {
                            done(file)
                        },
                    };

                    if (!keepOriginalExtension) {
                        // obs: não funciona no safari, não sei qual vai ser o comportamento
                        // https://github.com/fengyuanchen/compressorjs?tab=readme-ov-file#mimetype
                        options.mimeType = "image/webp";
                    }

                    if (resizeWidth) {
                        options.maxWidth = resizeWidth;
                    }
                    if (resizeHeight) {
                        options.maxHeight = resizeHeight;
                    }

                    new Compressor(file, options);

                    // código original do dropzone para comprimir a imagem, retirado
                    /*return this.resizeImage(
                        file,
                        this.options.resizeWidth,
                        this.options.resizeHeight,
                        this.options.resizeMethod,
                        done
                    );
                    */
                } else {
                  return done(file);
                }
            },

            init: function () {

                this.on('addedfile', (e) => {
                    if (this.files.length > this.options.maxFiles) {
                        controller.alert('Erro de validação', 'Limite de arquivos atingido.');
                        this.removeFile(e);
                    }

                    const editButton = Dropzone.createElement(editButtonTemplate);
                    const removeButton = Dropzone.createElement(removeButtonTemplate);

                    removeButton.addEventListener('click', (event) => {
                        event.preventDefault();
                        event.stopPropagation();
                        this.removeFile(e);
                    });

                    editButton.addEventListener('click', () => {
                        loadInfo(e.data);

                        const attachmentModal = Bootstrap.Modal.getOrCreateInstance(dropname.querySelector(`.attachment.modal`));
                        attachmentModal.show();
                    });

                    e.previewElement.appendChild(removeButton);
                    e.previewElement.appendChild(editButton);

                    if (filesInited && prepend) {
                        // remove o preview do final da lista e adiciona depois do botão de 'upload'
                        // assim, o ultimo inserido fica em primeiro
                        let elementPreview =  $(e.previewElement);
                        let buttonAddFile = elementPreview.parent().find('div:first');
                        // elementPreview.remove();
                        // elementPreview.insertAfter(buttonAddFile)
                        elementPreview.detach().insertAfter(buttonAddFile)
                    }
                });

                this.on("maxfilesexceeded", (file) => {
                    controller.alert('Erro de validação', 'Limite de arquivos atingido.');
                    this.removeFile(file);
                });

                this.on('sending', (file, xhr, formData) => {
                    let token = document.querySelector('meta[name=\'csrf_token\']').getAttribute('content')
                    formData.append('_token', token);
                    formData.append('storage', storage);
                    formData.append('group', groups);
                    formData.append('path', uploadPath);
                });

                this.on('removedfile', file => {
                    if (file.hasOwnProperty('data') && file.data.hasOwnProperty('id')) {
                        let removeItem = dropname.querySelector(`.files-${file.data.id}`);
                        if (removeItem !== null && removeItem.parentNode !== null) {
                            removeItem.parentNode.removeChild(removeItem);
                        }
                        let url = urlDelete + file.data.id;

                        if (window.location.href.indexOf('duplicate=1') > 0) {
                            url += '?duplicate=1';
                        }

                        !isMediaLibrary && axios
                            .delete(url, {
                                storage: storage,
                            })
                            .then();
                    }
                });

                if (!multiple) {
                    this.hiddenFileInput.removeAttribute('multiple');
                }

                const images = data;

                if (images) {
                    Object.values(images).forEach((item) => {
                        const file = {
                            id: item.id,
                            name: item.original_name,
                            size: item.size,
                            type: item.mime,
                            status: Dropzone.ADDED,
                            url: `${item.url}`,
                            data: item,
                        };

                        this.emit('addedfile', file);
                        this.emit('thumbnail', file, file.url);
                        this.emit('complete', file);
                        this.files.push(file);
                        self.addSortDataAtributes(dropname, name, item);
                    });
                }

                let removeItem = dropname.querySelector(`.dz-progress`);
                if (removeItem !== null && removeItem.parentNode !== null) {
                    removeItem.parentNode.removeChild(removeItem);
                }

                filesInited = true
            },
            error(file, response) {
                
                // console.log(file, response, this.options)

                if (response === "You can't upload files of this type.") {
                    controller.alert('Erro de validação', "A extensão do arquivo é inválida.");
                } else if (response.message) {
                    controller.alert('Erro de validação', response.message);
                } else if (file.size > this.options.maxFilesize) {
                    controller.alert('Erro de validação', 'O arquivo enviado é muito pesado <br> Tamanho máximo permitido: ' + this.options.maxFilesize + 'MB');
                } else {
                    controller.alert('Erro de validação', 'Falha ao carregar seu arquivo');
                }

                this.removeFile(file);

                if (Object.prototype.toString.call(response).replace(/^\[object (.+)\]$/, '$1').toLowerCase() === 'string') {
                    return response;
                }
                return response.message;
            },
            success(file, response) {

                if (!Array.isArray(response)) {
                    response = [response];
                }

                response.forEach((item) => {
                    if (file.name === item.original_name) {
                        file.data = item;
                        return false;
                    }
                });

                self.addSortDataAtributes(dropname, name, file.data, file);
                self.resortElement();
            },
        });
    }

    /**
     *
     */
    openMedia() {
        const dropname = this.dropname;
        dropname.querySelector('.media-loader').style.display = "";
        dropname.querySelector('.media-results').style.display = "none";

        this.resetPage();
        this.loadMedia();
    }

    /**
     *
     */
    loadMore(event) {
        event.preventDefault();
        this.page++;
        this.loadMedia();
    }

    /**
     *
     */
    resetPage() {
        this.allMediaList = {}; // Reset all media list
        this.page = 1; // Reset page

        this.dropname.querySelector(`.media-results`).innerHTML = "";
    }

    /**
     *
     */
    loadMedia() {
        const self = this;
        const CancelToken = axios.CancelToken;
        const dropname = this.dropname;

        if (typeof this.cancelRequest === 'function') {
            this.cancelRequest();
        }

        let loadMediaModal = Bootstrap.Modal.getOrCreateInstance(dropname.querySelector(`.media.modal`));
        loadMediaModal.show();

        axios
            .post(this.prefix(`/systems/media?page=${this.page}`), {
                filter: {
                    disk: this.data.get('storage'),
                    original_name: this.searchTarget.value,
                    group: this.data.get('groups'),
                },
            }, {
                cancelToken: new CancelToken(function executor(c) {
                    self.cancelRequest = c;
                }),
            })
            .then((response) => {
                this.mediaList = response.data.data;
                // show/hide load more
                this.loadmoreTarget.classList.toggle('d-none', response.data.last_page === this.page);
                this.renderMedia();
            });
    }

    /**
     *
     */
    renderMedia() {
        this.mediaList.forEach((element, key) => {
            const index = this.page + '-' + key;

            const template = this.element
                .querySelector('#' + this.data.get('id') + '-media')
                .content
                .querySelector('.media-item')
                .cloneNode(true);

            template.innerHTML = template.innerHTML
                .replace(/{index}/, index)
                .replace(/{element.url}/, element.url)
                .replace(/{element.original_name}/, element.original_name)
                .replace(/{element.original_name}/, element.original_name);

            this.dropname.querySelector(`.media-results`).appendChild(template);
            this.allMediaList[index] = element;
        });

        this.dropname.querySelector('.media-loader').style.display = "none";
        this.dropname.querySelector('.media-results').style.display = "";
    }

    /**
     *
     */
    addFile(event) {
        const key = event.currentTarget.dataset.key;
        const file = this.allMediaList[key]

        this.addedExistFile(file);

        if (this.data.get('close-on-add')) {
            let loadMediaModal = Modal.getOrCreateInstance(this.dropname.querySelector(`.media.modal`));
            loadMediaModal.hide();
        }
    }

    /**
     *
     * @param attachment
     */
    addedExistFile(attachment) {
        const multiple = !!this.data.get('multiple');
        const maxFiles = multiple ? this.data.get('max-files') : 1;

        if (this.dropZone.files.length >= maxFiles) {
            this.alert('Max files exceeded');
            return;
        }

        /** todo: Дублируется дважды */
        const file = {
            id: attachment.id,
            name: attachment.original_name,
            size: attachment.size,
            type: attachment.mime,
            status: Dropzone.ADDED,
            url: `${attachment.url}`,
            data: attachment,
        };

        this.dropZone.emit('addedfile', file);
        this.dropZone.emit('thumbnail', file, file.url);
        this.dropZone.emit('complete', file);
        this.dropZone.files.push(file);
        this.addSortDataAtributes(this.dropname, this.data.get('name'), file);
        this.resortElement();
    }
}
