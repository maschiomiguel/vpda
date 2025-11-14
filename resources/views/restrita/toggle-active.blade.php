<div class="form-check form-switch d-flex p-0 align-items-center w-100 justify-content-center" data-controller="active">
    <input value="checked" type="checkbox" class="form-check-input m-0" id="{{ $id }}" {{ $checked ? "checked" : "" }}
        autocomplete="off"
        data-action="change->active#toggleActive"
        data-active-id-param="{{ $id }}"
        data-active-column-param="{{ $column }}"
        data-active-url-param="{{ route("platform.$url.edit", [$id, "toogleField"]) }}"
    >
</div>
