import $ from 'jquery';
import * as Turbo from "@hotwired/turbo"
import Sortable from 'sortablejs';

export default function sort() {

    function initializeSortable() {
        if ($("tbody").length > 0) {
            Sortable.create($("tbody")[0], {
                animation: 150,
                handle: "[data-sortable-handle]",
                onEnd: function (evt) {
                    let array = {};
                    let url = $(evt.target).find("[data-sortable-url]").attr('data-sortable-url');
                    $(evt.target).find("[data-sortable-id]").each(function (index) {
                        array[$(this).data('sortable-id')] = index + 1;
                    })
                    evt.target.classList.add('pe-none', 'opacity-25');
                    axios
                        .post(url, {
                            params: {
                                data: array,
                                newIndex: evt.newIndex + 1,
                                oldIndex: evt.oldIndex + 1,
                            },
                        })
                        .then(function (response) {
                            if (response.data.error) {
                                console.error(response.data.message);
                                return;
                            }
                            evt.target.classList.remove('pe-none', 'opacity-25');
                            console.log(response.data.message);
                        })
                        .catch(function (error) {
                            evt.target.classList.remove('pe-none', 'opacity-25');
                            console.error("Ocorreu um erro interno.");
                        });
                },
            });
        }
    }

    document.addEventListener("turbo:load", function () {
        initializeSortable();
    });
}


