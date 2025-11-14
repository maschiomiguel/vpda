import ActiveController from "./controllers/active_controller";
import UploadController from "./controllers/upload_controller";
import Sortable from "./controllers/sortable";
import PermissionsSelect from "./controllers/permissions_select";
import TinyMCE from "./controllers/tinymce_controller";
import selectAllCheckbox from "./controllers/select_all_checkbox";
import selectDisplay from "./controllers/select_display";

// Controllers do stimulus
application.register("tinymce", TinyMCE);
application.register("active", ActiveController);
application.register("upload", UploadController);

// Executa sortable quando framework turbo carregar
Sortable();

// Selecionar/deselecionar todas as permissões na tela de níveis
PermissionsSelect();

// Selecionar/deselecionar todas as checkbox
selectAllCheckbox();

selectDisplay();
