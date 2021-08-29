document.querySelector("#submit").addEventListener("click", async (ev) => {
    ev.preventDefault();

    let message = document.querySelector("textarea[name='message']").value;
    let email = document.querySelector("input[name='email']").value;

    let form = document.querySelector("#form");
    let url = window.location.href;

    let formdata = new FormData(form);

    Swal.fire({
        title: "Confirm Message?",
        text: `${email}: ${message}`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Proceed",
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            return fetch(url, {
                method: "POST",
                body: formdata,
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                })
                .catch((error) => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((res) => {
        if (res.isConfirmed) {
            Swal.fire({
                title: "Success!",
                icon: "success",
                timer: 1000,
                timerProgressBar: true,
            })
                .then((res) => {
                    document.querySelector("textarea[name='message']").value = "";
                    email = document.querySelector("input[name='email']").value = "";
                });
        }
    });
})