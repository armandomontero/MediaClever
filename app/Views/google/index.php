<main>

    <div id="spinner" class="spinner-overlay  d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="">Procesando...</span>
        </div>
        <span class="">Procesando...</span>
    </div>


    <div class="container-fluid px-4 covered">
        <div class="d-none" id="conectado">
            <div class="bg-success p-2 text-white mb-3 rounded text-center">
                <h5>Se ha sincronizado correctamente con Google Calendar, ya puede realizar notiticaciones con integración de Google Meets</h5>
            </div>
            <div class="mb-3 text-center">
                <a class="btn btn-primary" href="<?= base_url() ?>"><i class="fas fa-home"></i> Volver al Inicio</a>
                <a class="btn btn-primary" href="<?= base_url() ?>eventos"><i class="fas fa-calendar"></i> Ir a la Agenda General</a>
            </div>
        </div>
        <h4>Contectar con Google Calendar</h4>
        <p>Idealmente utilize la misma cuenta de correo asociada a su cuenta de usuario en plataforma MediaClever, la cual es: <span class="font-weight-bold"><?= $mail_usuario ?><span></p>
        <button class="btn btn-primary" onclick="generateLink()" id="generate_link"><i class="fas fa-wifi"></i> Conectar o reconectar</button>
        <br>


        -
        <br>
    </div>
</main>
<script>
    const API = '<?php base_url() ?>';
    const queryParams = new URLSearchParams(window.location.search);

    if (queryParams.get('code')) {
        storeToken();
    }


    function generateLink() {

        fetch(API + 'google/generate_link', {
                method: 'POST'
            })
            .then(response => {
                if (response.status === 200) {
                    return response.json();
                }
                throw response
            })
            .then(response => {
                if (response.link) {
                    window.location.href = response.link;
                }
            })
            .catch(error => console.log(error))
    }


    function storeToken() {
        $("#spinner").removeClass('d-none');
        fetch(API + 'google/storeToken', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    code: queryParams.get('code')
                })
            })
            .then(response => {

                if (response.status === 200) {
                    return response.json();
                }


                throw response
            })
            .then(response => {
                if (response.status == true);
                $("#spinner").addClass('d-none');
                $("#conectado").removeClass('d-none');

            })
            .catch(error => console.log(error))
    }






    function test() {
        //alert('assa');
        var email = document.getElementById('email').value;

        fetch(API + 'google/storeEvent', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: email
                })
            })
            .then(response => {
                if (response.status === 200) {
                    return response.json();
                }
                throw response
            })
            .then(response => {
                alert('evento agendado');
            })
            .catch(error => console.log(error))
    }
</script>