const campoCep = document.querySelector('[name="cep"]');
const camposEndereco = {
    logradouro: document.querySelector('[name="logradouro"]'),
    bairro: document.querySelector('[name="bairro"]'),
    cidade: document.querySelector("#cidade"),
    estado: document.querySelector('[name="estado"]')
};

campoCep.addEventListener("input", async () => {
    const cep = campoCep.value.replace(/\D/g, "");

    if (cep.length !== 8) {
        Object.values(camposEndereco).forEach(campo => campo.value = "");
        return;
    }

    try {
        const resposta = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const dados = await resposta.json();

        if (dados.erro) {
            Object.values(camposEndereco).forEach(campo => campo.value = "");
            return;
        }

        camposEndereco.logradouro.value = dados.logradouro || "";
        camposEndereco.bairro.value = dados.bairro || "";
        camposEndereco.cidade.value = dados.localidade || "";
        camposEndereco.estado.value = dados.uf || "";
    } catch (erro) {
        console.error("Erro ao consultar o CEP:", erro);
    }
});