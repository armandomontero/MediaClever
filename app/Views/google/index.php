<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport">
    <title>Test</title>
</head>

<body>

    <h2>Contectar Google</h2>
    <button onclick="generateLink()" id="generate_link">Conecta</button>
    <br>
   
    <h2>Agendar Evento</h2>
    <input type="email" name="email" id="email" />
    <button onclick="test();" id="crearevento">Agendar</button>
-
    <br>
    <script>
        const API = '<?php base_url()?>';
        const queryParams = new URLSearchParams(window.location.search);

         if(queryParams.get('code')){
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
                        if(response.status==true){
                            
                        }
                })
                .catch(error => console.log(error))
        }



        function createEvent() {
alert('assa');
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


        function test(){
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
</body>

</html>