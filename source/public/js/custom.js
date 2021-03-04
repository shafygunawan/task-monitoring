// dapatkan elemen tombol join dan input form pada join modal
let joinButton = document.querySelector('#joinModal .modal-footer button[type="submit"]');
let joinInput = document.querySelector('#joinModal .modal-body input');

// event ketika tombol join diklik
joinButton.addEventListener('click', () => {
    // ambil kode undangan dari input form pada join modal
    let invitationCode = joinInput.value;

    // lakukan ajax dan cek apakah kode undangan kantor benar
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {

            // cek apakah kode undangan tidak valid
            if (this.response == false) {
                joinInput.classList.add('is-invalid');
                return;
            }

            return window.location.href = '/offices/' + this.responseText;
        }
    };
    xhr.open('POST', '/offices/join', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send('invitationCode=' + invitationCode);

});