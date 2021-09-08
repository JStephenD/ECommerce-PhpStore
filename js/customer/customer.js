document.querySelectorAll('.c-showpass').forEach(node => {
    let div = node.parentElement;
    let input = div.querySelector('input');
    let i = div.querySelector('i');

    node.addEventListener('mouseover', (ev) => {
        input.type = "text";
        i.classList.replace('zmdi-eye-off', 'zmdi-eye');
    });
    node.addEventListener('mouseout', (ev) => {
        input.type = "password";
        i.classList.replace('zmdi-eye', 'zmdi-eye-off');
    });
});


document.querySelector('#login').addEventListener('click', async (ev) => {
    ev.preventDefault();

    let form = document.querySelector("#loginform");
    let url = `${window.location.href}/login`;

    let formdata = new FormData(form);

    Swal.fire({
        title: "Logging In",
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            container: 'myswal2'
        },
        didOpen: async () => {
            Swal.showLoading();

            await fetch(url, {
                method: 'POST',
                body: formdata
            }).then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }

                Swal.clickConfirm();

                response.json().then(json => {
                    if (json['result'] == "success") {
                        let logu = document.querySelector('#loginform input[name="username"]');

                        Swal.fire({
                            title: "Login Successful",
                            text: `Welcome ${logu.value}!`,
                            icon: "success",
                            timer: 1000,
                            timerProgressBar: true,
                            customClass: {
                                container: 'myswal2'
                            },
                        });
                        window.location.href = "/";
                    } else {
                        Swal.fire({
                            title: `${json['result']}`,
                            icon: "warning",
                            timer: 1000,
                            timerProgressBar: true,
                            customClass: {
                                container: 'myswal2'
                            },
                        });
                    }
                });
            }).catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        backdrop: true,
        allowOutsideClick: () => !Swal.isLoading(),
    });
});

document.querySelector('#register').addEventListener('click', async (ev) => {
    ev.preventDefault();

    let form = document.querySelector("#registerform");
    let url = `${window.location.href}/register`;

    let formdata = new FormData(form);

    Swal.fire({
        title: "Registering Account",
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            container: 'myswal2'
        },
        didOpen: async () => {
            Swal.showLoading();

            await fetch(url, {
                method: 'POST',
                body: formdata
            }).then(response => {
                Swal.clickConfirm();

                response.json().then(json => {
                    if (json['result'] == "success") {
                        let regu = document.querySelector('#registerform input[name="username"]');
                        let logu = document.querySelector('#loginform input[name="username"]');
                        let regp = document.querySelector('#registerform input[name="password"]');

                        regp.value = '';
                        logu.value = regu.value;
                        regu.value = '';

                        Swal.fire({
                            title: "Registration Successful",
                            text: "You can login now",
                            icon: "success",
                            timer: 1000,
                            timerProgressBar: true,
                            customClass: {
                                container: 'myswal2'
                            },
                        })
                    } else {
                        Swal.fire({
                            title: `${json['result']}`,
                            icon: "warning",
                            timer: 1000,
                            timerProgressBar: true,
                            customClass: {
                                container: 'myswal2'
                            },
                        })
                    }
                });
            }).catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
            });
        },
        backdrop: true,
        allowOutsideClick: () => !Swal.isLoading(),
    });
});