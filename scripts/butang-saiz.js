function ubahsaiz(gandaan) {
    //mendapatkan saiz semasa tulisan pada jadual
    var saiz = document.getElementById("saiz");
    var saiz_semasa = saiz.style.fontSize || 1;

    /* menyemak jika pengguna menekan butang, nilai yang akan dihantar
        butang reset - nilai 2 dihantar   - kembali kepada saiz asal tulisan
        butang +     - nilai 1 dihantar   - besarkan saiz tulisan
        butang -     - nilai -1 dihantar  - kecilkan saiz tulisan
     */
    if (gandaan == 2) {
        saiz.style.fontSize = "1em";
    }
    else {
        saiz.style.fontSize = (parseFloat(saiz_semasa) + (gandaan * 0.2)) + "em";
    }
}