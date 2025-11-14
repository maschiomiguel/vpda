import $ from "jquery";

export default function selectAllCheckbox() {
    function changeCheckState(state) {
        $(".data-select-all-reports").each(function () {
            $(this).prop("checked", state);
        });
        showHideButton();
    }

    function initializePermissionsSelect() {
        $(".data-select-all-reports").on("change", function () {
            if (
                $(".data-select-all-reports:checked").length ==
                $(".data-select-all-reports").length
            ) {
                $(".select-all-report-checks").prop("checked", true);
            } else {
                $(".select-all-report-checks").prop("checked", false);
            }
            showHideButton();
        });

        $(".select-all-report-checks").on("click", function () {
            changeCheckState($(this).prop("checked"));
        });
    }

    document.addEventListener("turbo:load", function () {
        initializePermissionsSelect();
    });

    function showHideButton(){
        if($(".data-select-all-reports:checked").length >= 1){
            $(".remove-selected").show();
        }else{
            $(".remove-selected").hide();
        }
    }
    
    showHideButton();

}
