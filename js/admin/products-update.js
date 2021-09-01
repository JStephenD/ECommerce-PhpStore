document.querySelector("#submit").addEventListener("click", async (ev) => {
    ev.preventDefault();

    let form = document.querySelector("#form");
    let url = window.location.href;

    let formdata = new FormData(form);

    Swal.fire({
        title: "Update Product?",
        text: '',
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
                    window.location.reload();
                });
        }
    });
})

let input = document.querySelector("input[name='picture']");

input.addEventListener("input", (e) => {
    let file = input.files[0];
    let preview = document.querySelector("#preview");

    var reader = new FileReader();
    reader.onload = function (e) {
        preview.src = e.target.result;
    }
    reader.readAsDataURL(file);

    let imageChanged = document.querySelector("input[name='imageChanged']");
    imageChanged.value = true;
})

$(".select").select2();