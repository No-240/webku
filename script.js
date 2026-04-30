alert("Selamat datang")

const form = document.querySelector("form");

form.addEventListener("submit", function(e) {
    e.preventDefault(); 
    const nama = document.querySelector("input[type='text']").value;
    const harga = document.querySelector("input[type='harga']").value;

    if(nama === "" || harga === "") {
        alert("Harap isi semua data!");
    } else {
        alert("Data berhasil dikirim!");
    }
});