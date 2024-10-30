import Swal from "sweetalert2";

const deleteButtons = document.querySelectorAll(".btn-delete");
deleteButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
        Swal.fire({
            title: "Delete",
            text: "Are you sure you want to delete this postback?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#rgb(166, 15, 20)",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                const form = btn.closest('.delete-form')
                sendDeleteRequest(form);
                btn.parentElement.parentElement.parentElement.remove()
            }
        });
    });
});
function sendDeleteRequest(form) {
    const xhr = new XMLHttpRequest();
    xhr.open(form.method, form.action);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function () {
        if (xhr.status === 200) {
            Swal.fire("Deleted!", "Postback has been deleted.");
        } else {
            Swal.fire("Error!", "Error");
        }
    };
    xhr.onerror = function () {
        console.error('Error');
    };
    xhr.send(new FormData(form));
}
