<body>

    <!-- other html -->
    Hi
    <button id="call">call</button>
    <script omi-sdk type="text/javascript" src="https://cdn.omicrm.com/sdk/2.0.0/sdk.min.js"></script>

    <script>
        function createAccount (email)
        {
            console.log(1);
            var formdata = new FormData();
        formdata.append("email", email);
        formdata.append("phone", '0' + Math.floor(100000000 + Math.random() * 900000000));
        formdata.append("password", "Hieuhala127!@#");
        formdata.append("password_confirmation", "Hieuhala127!@#");
        formdata.append("address", "Từ Sơn - Bắc Ninh");
        formdata.append("dob", "2022-07-12");
        formdata.append("first_name", "Nguyễn Văn");
        formdata.append("last_name", "Hiếu");

            var requestOptions = {
            method: 'POST',
            body: formdata,
            redirect: 'follow'
            };

            fetch("http://localhost/CVKMA/public/api/auth/register", requestOptions)
            .then(response => response.text())
            .then(result => console.log(result))
            .catch(error => console.log('error', error));
        }

        email = "testvanhieubn1235@gmail.com"

        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
        createAccount(email)
</script>

</body>
