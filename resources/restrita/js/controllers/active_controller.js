import axios from "axios";

export default class extends window.Controller {
    toggleActive(event) {
        event.target.disabled = true;

        var self = this;
        let url = event.params.url;

        axios
            .post(url, {
                params: {
                    id: event.params.id ?? false,
                    column: event.params.column ?? false,
                    status: event.target.checked ?? false,
                },
            })
            .then(function (response) {
                if (response.data.error) {
                    self.alert("Erro", "Não foi possivel habilitar/desabilitar esse item, se o problema persistir, entre em contato com os administradores do site.", "danger");
                    console.error(response.data.message);
                    return;
                }
                self.alert("Sucesso", response.data.message, "success");
                console.log(self.alert("Sucesso", response.data.message, "success"));
                console.log(response.data.message);
                setTimeout(() => {
                    event.target.disabled = false;
                }, 3000)
            })
            .catch(function (error) {
                console.error("Ocorreu um erro interno.");
            });
    }
}
