import $ from "jquery";

export default function permissionsSelect() {
    function changeCheckState(button, state) {
        $(button)
            .parents("form")
            .find('input[type="checkbox"]')
            .prop("checked", state);
    }

    function initializePermissionsSelect() {
        $("[data-select-all-permissions]").on("click", function () {
            changeCheckState(this, true);
        });
        $("[data-deselect-all-permissions]").on("click", function () {
            changeCheckState(this, false);
        });
    }

    document.addEventListener("turbo:load", function () {
        initializePermissionsSelect();
    });
}
