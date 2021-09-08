document.querySelector("#update-cart").addEventListener("click", async (ev) => {
    ev.preventDefault();

    let form = document.querySelector("#form");
    let url = `${window.location.href}/update`;

    let formdata = new FormData(form);
    let warn = '';

    let numOrders = document.querySelectorAll('input[name="numOrders[]"');
    numOrders.forEach(node => {
        if (node.value == 0) {
            warn = "Some items will be removed";
        }
    });

    Swal.fire({
        title: "Update Cart",
        text: `${warn}`,
        icon: (warn == '') ? "question" : "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Update",
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
                    response.json().then(json => {
                        let cartIcon = document.querySelector('.js-show-cart');
                        let len = Object.keys(json).length;
                        cartIcon.setAttribute('data-notify', len);

                        let table = document.querySelector('.table-shopping-cart');
                        let rows = document.querySelectorAll('.table_row');

                        let with_orders = [];
                        Object.values(json).forEach(value => {
                            with_orders.push(value.id);
                        });

                        rows.forEach(row => {
                            let id = row.querySelector('.cs-id').value;
                            if (!with_orders.includes(id)) {
                                table.deleteRow(row.rowIndex);
                            }
                        });

                        compute_totals();
                    });
                })
                .catch((error) => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        },
        backdrop: true,
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((res) => {
        if (res.isConfirmed) {
            Swal.fire({
                title: "Success!",
                icon: "success",
                timer: 1000,
                timerProgressBar: true,
            });
        }
    });
});

document.querySelectorAll('.how-itemcart1').forEach(btn => {
    btn.addEventListener("click", async (ev) => {
        ev.preventDefault();

        let source = ev.target || ev.source;
        let table = document.querySelector('.table-shopping-cart');

        let row = source.parentElement.parentElement;
        let id = row.querySelector('.cs-id').value;

        let name = row.querySelector('.cs-name').innerHTML;
        let rowindex = row.rowIndex;
        let url = `${window.location.href}/remove/${id}`;

        Swal.fire({
            title: "Remove Item?",
            text: `${name}`,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Delete",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                return fetch(url, {
                    method: "POST",
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(response.statusText);
                        }
                        table.deleteRow(rowindex);

                        let cartIcon = document.querySelector('.js-show-cart');
                        let len = table.childElementCount;
                        cartIcon.setAttribute('data-notify', len);

                        compute_totals();
                    })
                    .catch((error) => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
            },
            backdrop: true,
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((res) => {
            if (res.isConfirmed) {
                Swal.fire({
                    title: "Success!",
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true,
                });
            }
        });
    });
});

document.querySelector('#checkout').addEventListener("click", async (ev) => {
    ev.preventDefault();

    Swal.fire({
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            container: 'myswal2'
        },
        didOpen: async () => {
            Swal.showLoading();

            let form = document.querySelector('#form');
            let formdata = new FormData(form);

            await fetch(`${window.location.href}/checkout`, {
                method: "POST",
                body: formdata
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }

                    Swal.clickConfirm();

                    response.json().then(json => {
                        let result = json['result'];

                        if (result == 'success') {
                            Swal.fire({
                                title: "Checked out",
                                text: `Your order has been placed`,
                                icon: "success",
                                timer: 1000,
                                timerProgressBar: true,
                                customClass: {
                                    container: 'myswal2'
                                },
                            });
                            window.location.reload();
                        } else {
                            Swal.fire({
                                title: result,
                                icon: "warning",
                                timer: 1000,
                                timerProgressBar: true,
                                customClass: {
                                    container: 'myswal2'
                                },
                            });
                        }
                    });
                })
                .catch((error) => {
                    Swal.showValidationMessage(`Request failed: ${error}`);
                });
        },
        backdrop: true,
        allowOutsideClick: () => !Swal.isLoading(),
    });
});


function compute_totals() {
    let table = document.querySelector('.table-shopping-cart');
    let subtotalNode = document.querySelector('.cs-subtotal');
    let totalNode = document.querySelector('.cs-total');

    let subtotal = 0;
    let total = 0;

    table.querySelectorAll('tr.table_row').forEach(node => {
        let price = node.querySelector('.cs-price').getAttribute('data-price');
        let quantity = node.querySelector('.cs-quantity').value;

        subtotal += parseFloat(price) * parseInt(quantity);
    });
    total = subtotal;

    subtotalNode.innerHTML = `₱${subtotal}`;
    totalNode.innerHTML = `₱${total}`;
}

compute_totals();