alert("Selamat datang")

const form = document.querySelector("form");

form.addEventListener("submit", function(e) {
    e.preventDefault(); 
    const nama = document.querySelector("input[type='text']").value;
    const email = document.querySelector("input[type='email']").value;

    if(nama === "" || email === "") {
        alert("Harap isi semua data!");
    } else {
        alert("Data berhasil dikirim!\nNama: " + nama + "\nEmail: " + email);
    }
});