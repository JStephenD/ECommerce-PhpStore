document.querySelector("#submit").addEventListener("click", async (ev) => {
    ev.preventDefault();

    let category = document.querySelector("input[name='name']").value;

    let form = document.querySelector("#form");
    let url = window.location.href;

    let formdata = new FormData(form);

    Swal.fire({
        title: "Add New Category",
        text: `${category}`,
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
                    document.querySelector("input[name='name']").value = "";
                });
        }
    });
})