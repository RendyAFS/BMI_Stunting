<div class="card shadow">
    <div class="card-header" id="calc-stunting">
        <h3 class="fw-bold">Input Data</h3>
    </div>

    <form action="{{ route('dbulanans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="d-flex ">
                <i class="bi bi-search fs-3 me-2"></i>
                <input type="text" id="searchInput" class="form-control mb-3 border border-dark-subtle"
                    placeholder="Cari Nama" onclick="selectAllText(this);" onfocus="selectAllText(this);" required>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-floating mb-3 d-none">
                        <input type="text"
                            class="form-control border border-dark-subtle @error('users_id') is-invalid @enderror"
                            id="users_id" name="users_id" placeholder="Masukkan NIK" required maxlength="16"
                            value="{{ Auth::user()->id }}">
                        <label for="users_id" class="">User_id:</label>
                        @error('users_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <select class="form-select mb-2 border border-dark-subtle" id="danaks_id" name="danaks_id" required
                        style="cursor: pointer">
                        <option class="fw-bold fs-5 mb-3 text-center bg-dark-subtle rounded-2" value="null">
                            Silahkan Pilih Nama
                        </option>

                        @foreach ($danaks->sortBy('nama_anak') as $data)
                            @php
                                $tanggal_lahir = new DateTime($data->tanggal_lahir);
                                $sekarang = new DateTime();
                                $umur = $tanggal_lahir->diff($sekarang);

                                $umurTotal = $umur->y;
                                $umurTotal2 = $umur->m;
                                $umurTotal3 = $umur->y . ' Tahun ' . $umur->m . ' Bulan';
                            @endphp
                            <option class="border border-dark-subtle mb-2 px-2 overflow-auto overflow-md-hidden"
                                value="{{ $data->id }}" {{-- untuk rumus stunting --}} data-jk="{{ $data->jk }}"
                                data-nama_posyandu="{{ $data->dposyandu->nama_posyandu }}"
                                data-umur="{{ $umurTotal }}" data-umur2="{{ $umurTotal2 }}"
                                data-umur3="{{ $umurTotal3 }}"> <!-- Menambahkan data-umur -->
                                {{ $data->nama_anak }} | {{ $data->nik_anak }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                {{-- Cara Ukur --}}
                <div class="mb-3 d-flex justify-content-center align-items-center">
                    <form>
                        <div class="form-check form-check-inline">
                            <button class="btn border border-dark" type="button" id="berdiriButton"
                                value="Berdiri">Berdiri</button>
                        </div>
                        <div class="form-check form-check-inline">
                            <button class="btn border border-dark" type="button" id="telentangButton"
                                value="Telentang">Telentang</button>
                        </div>
                    </form>
                </div>
                <input type="text" id="jk_anak" name="jk_anak" class="d-none" required placeholder="jk_anak">

                <div class="row mb-3 mt-2 px-3 ">
                    <div class="col-6 text-center">
                        <label for="" class="border-bottom border-3">Umur Tahun</label><br>
                        <span class="badge rounded-pill text-bg-success fs-5 mt-2" id="umur_tahun_badge">
                            0
                        </span>
                    </div>
                    <div class="col-6 text-center">
                        <label for="" class="border-bottom border-3">Umur Bulan</label><br>
                        <span class="badge rounded-pill text-bg-success fs-5 mt-2" id="umur_bulan_badge">
                            0
                        </span>
                    </div>
                </div>

                <input type="text" id="umur_tahun" name="umur_tahun" class="d-none " placeholder="umur_tahun"
                    required>
                <input type="text" id="umur_bulan" name="umur_bulan" class="d-none " placeholder="umur_bulan"
                    required>
                <input type="text" id="umur_periksa" name="umur_periksa" class="d-none" required
                    placeholder="umur_periksa">
                <input type="text" id="nama_posyandu" name='nama_posyandu' class="d-none" required
                    placeholder="nama_posyandu">
                <input type="text" id="c_ukur" name='c_ukur' class="d-none" required placeholder="c_ukur">
                <input type="text" id="h_imt" name='h_imt' class="d-none" required placeholder="h_imt">

                {{-- Cara Ukur --}}
                <div class="col-6">
                    {{-- Untuk Umur Periksa --}}

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border border-dark-subtle  " id="bb_anak"
                            name="bb_anak" placeholder="Masukan Berat Badan (KG)" value="0" required
                            onclick="selectAllText(this);" onfocus="selectAllText(this);">
                        <label class="d-md-block d-none" for="bb_anak">Berat Badan (KG)</label>
                        <label class="d-md-none d-block" for="bb_anak">Berat Badan</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border border-dark-subtle " id="tb_anak"
                            name="tb_anak" placeholder="Masukan Tinggi Badan (KG)" value="0" required
                            onclick="selectAllText(this);" onfocus="selectAllText(this);">
                        <label class="d-md-block d-none" for="tb_anak">Tinggi Badan (CM)</label>
                        <label class="d-md-none d-block" for="tb_anak">Tinggi Badan</label>
                    </div>
                </div>
                {{-- LIla --}}
                <div class="col-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border border-dark-subtle  " id="lk_anak"
                            name="lk_anak" placeholder="Masukan Lingkar Kepala (CM)" value="0" required
                            onclick="selectAllText(this);" onfocus="selectAllText(this);">
                        <label class="d-md-block d-none" for="lk_anak">Lingkar Kepala
                            (CM)</label>
                        <label class="d-md-none d-block" for="lk_anak">Lingkar Kepala</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border border-dark-subtle " id="ll_anak"
                            name="ll_anak" placeholder="Masukan Lingkar Lengan (CM)" value="0" required
                            onclick="selectAllText(this);" onfocus="selectAllText(this);">
                        <label class="d-md-block d-none" for="ll_anak">Lingkar Lengan
                            (CM)</label>
                        <label class="d-md-none d-block" for="ll_anak">Lingkar Lengan</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark-subtle" id="st_anak" name="st_anak"
                            placeholder="Status Anak" required readonly value="- Silahkan Masukan Data">
                        <label for="st_anak">Status Aanak</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control border-dark-subtle" id="gz_anak" name="gz_anak"
                            placeholder="Gizi Anak" required readonly value="- Silahkan Masukan Data">
                        <label for="gz_anak">Gizi Aanak</label>
                    </div>
                </div>
            </div>

            {{-- Button --}}
            <div class="row d-flex justify-content-center">
                <div class="col-md-3 col-4 d-grid">
                    <a id="reset" class="btn btn-danger shadow">Ulangi</a>
                </div>
                <div class="col-md-3 col-4 d-grid">
                    <button class="btn btn-success" id="liveToastBtn">Simpan</button>
                </div>
            </div>

            <div class="toast-container position-fixed bottom-0 end-0 p-3">
                <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header bg-warning">
                        <strong class="me-auto">Info</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                    <div class="toast-body bg-white">
                        Silahkan Pilih Cara Ukur Terlebih Dahulu
                    </div>
                </div>
            </div>
        </div>
    </form>
    <button onclick="getDataFromFirebase()" class="btn btn-outline-success"
        style="padding: 10px; margin: 0 auto 20px; width: 200px; display: block;">
        <label class="fw-bold pe-none">UKUR DENGAN ALAT</label>
    </button>
</div>
<!-- Bootstrap JS (popper.js and bootstrap.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.1/firebase-database.js"></script>


<script>
    // Konfigurasi Firebase
    var firebaseConfig = {
        apiKey: "AIzaSyCzJu9iRvAi4f08JHm61kq-KfsR6Z0FopA",
        authDomain: "connnectcarepediatrics.firebaseapp.com",
        databaseURL: "https://connnectcarepediatrics-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "connnectcarepediatrics",
        storageBucket: "connnectcarepediatrics.appspot.com",
        messagingSenderId: "982173600901",
        appId: "1:982173600901:web:c632d8788e40f55fc8adec"
    };
    firebase.initializeApp(firebaseConfig);
    const database = firebase.database();
    const timbanganRef = database.ref('/Timbangan');

//fungsi get data firebase
function getDataFromFirebase() {
    const toast = new bootstrap.Toast(document.getElementById('liveToast'));
    const cUkur = document.getElementById('c_ukur').value;

    if (cUkur === 'Berdiri' || cUkur === 'Telentang') {
        // Ambil data dari Firebase kalau di trigger button
        timbanganRef.once('value')
            .then((snapshot) => {
                const data = snapshot.val();
                if (data) {
                    const rawBerat = data.Berat || 0;
                    const tinggi = data.Tinggi || 0;
                    const panjang = data.Panjang || 0;

                    // Konversi nilai berat
                    const berat = (rawBerat / 1000).toFixed(2);

                    if (cUkur === 'Berdiri') {
                        document.getElementById('bb_anak').value = berat;
                        document.getElementById('tb_anak').value = tinggi;
                    } else if (cUkur === 'Telentang') {
                        document.getElementById('bb_anak').value = berat;
                        document.getElementById('tb_anak').value = panjang;
                    }
                    //debug di console
                    console.log('Data dari Firebase berhasil diambil:', { berat, tinggi, panjang });
                } else {
                    console.error('Data dari Firebase kosong.');
                }
            })
            .catch((error) => {
                console.error('Error fetching data from Firebase:', error);
            });
    } else {
        // kalau si kader belum pilih cara ukur muncul notif toast
        toast.show();
    }
}


    // Cara Ukur
    const berdiriButton = document.getElementById('berdiriButton');
    const telentangButton = document.getElementById('telentangButton');
    const cUkurInput = document.getElementById('c_ukur');

    berdiriButton.addEventListener('click', function() {
        berdiriButton.style.backgroundColor = '#42E6A4';
        telentangButton.style.backgroundColor = '';
        cUkurInput.value = 'Berdiri';
    });

    telentangButton.addEventListener('click', function() {
        telentangButton.style.backgroundColor = '#42E6A4';
        berdiriButton.style.backgroundColor = '';
        cUkurInput.value = 'Telentang';
    });
    // Toast
    document.addEventListener("DOMContentLoaded", function() {
        const berdiriButton = document.getElementById('berdiriButton');
        const telentangButton = document.getElementById('telentangButton');
        const cUkurInput = document.getElementById('c_ukur');
        const submitButton = document.getElementById('liveToastBtn');
        const toast = new bootstrap.Toast(document.getElementById('liveToast'));

        berdiriButton.addEventListener('click', function() {
            berdiriButton.style.backgroundColor = '#42E6A4';
            telentangButton.style.backgroundColor = '';
            cUkurInput.value = 'Berdiri';
        });

        telentangButton.addEventListener('click', function() {
            telentangButton.style.backgroundColor = '#42E6A4';
            berdiriButton.style.backgroundColor = '';
            cUkurInput.value = 'Telentang';
        });

        submitButton.addEventListener('click', function() {
            // Check if either "Berdiri" or "Telentang" is selected
            if (cUkurInput.value !== 'Berdiri' && cUkurInput.value !== 'Telentang') {
                toast.show();
            } else {
                // Otherwise, proceed with your form submission logic
                // Your form submission code here
            }
        });
    });





    // Mendapatkan elemen select dengan class 'form-select' dan id 'danaks_id'
    let select = document.getElementById('danaks_id');

    // Mendapatkan elemen input dengan id 'umur_tahun'
    let jkInput = document.getElementById('jk_anak');
    let umurInputt = document.getElementById('umur_tahun');
    let umurInputb = document.getElementById('umur_bulan');
    let umurInputa = document.getElementById('umur_periksa');
    let posyanduInput = document.getElementById('nama_posyandu');

    // Menambahkan event listener untuk mengubah nilai input saat opsi dipilih
    select.addEventListener('change', function() {
        // Mendapatkan umur dari data-umur pada opsi yang dipilih
        let selectedOption = select.options[select.selectedIndex];
        let jk = selectedOption.getAttribute('data-jk');
        let umurt = selectedOption.getAttribute('data-umur');
        let umurb = selectedOption.getAttribute('data-umur2');
        let umura = selectedOption.getAttribute('data-umur3');
        let posyandu = selectedOption.getAttribute('data-nama_posyandu');

        // Memasukkan nilai umur ke dalam input 'umur_tahun'
        jkInput.value = jk;
        umurInputt.value = umurt;
        umurInputb.value = umurb;
        umurInputa.value = umura;
        posyanduInput.value = posyandu;

        // Update nilai pada span Umur Tahun
        document.getElementById('umur_tahun_badge').innerText = `${umurt}`;

        // Update nilai pada span Umur Bulan
        document.getElementById('umur_bulan_badge').innerText = `${umurb}`;
    });

    // Stautus BMI RUMUS BESAR
    // Ambil elemen input bb_anak, tb_anak, dan st_anak
    let bb_anakInput = document.getElementById('bb_anak');
    let tb_anakInput = document.getElementById('tb_anak');
    let lk_anakInput = document.getElementById('lk_anak');
    let ll_anakInput = document.getElementById('ll_anak');
    let st_anakInput = document.getElementById('st_anak');
    let gz_anakInput = document.getElementById('gz_anak');
    let imt_anakInput = document.getElementById('h_imt');
    let danaksId = document.getElementById('danaks_id');

    // Tambahkan event listener untuk perubahan dropdown
    danaksId.addEventListener('change', updateStatusAnak);
    bb_anakInput.addEventListener('input', updateStatusAnak);
    tb_anakInput.addEventListener('input', updateStatusAnak);
    lk_anakInput.addEventListener('input', updateStatusAnak);
    ll_anakInput.addEventListener('input', updateStatusAnak);
    imt_anakInput.addEventListener('input', updateStatusAnak);

    function updateStatusAnak() {

        let selectedOption = danaksId.options[danaksId.selectedIndex];
        let jkValue = selectedOption.getAttribute('data-jk');

        let bb_anakValue = parseFloat(bb_anakInput.value);
        let tb_anakValue = parseFloat(tb_anakInput.value);
        let lk_anakValue = parseFloat(lk_anakInput.value);
        let ll_anakValue = parseFloat(ll_anakInput.value);
        let ut_anakValue = parseFloat(umurInputt.value);


        if (!isNaN(bb_anakValue) && !isNaN(tb_anakValue) && !isNaN(lk_anakValue) && !isNaN(ll_anakValue)) {
            // let st_anakValue = lk_anakValue + ll_anakValue;
            let tinggiMeter = tb_anakValue / 100; // Ubah tinggi ke meter
            let imt = bb_anakValue / (tinggiMeter * tinggiMeter); //mencari Indeks masa tubuh

            if (ut_anakValue < 5) {
                if (jkValue === 'L') {
                    if (imt < 9) {
                        st_anakInput.value = "Tinggi";
                        gz_anakInput.value = "Bawah Garis Merah";
                        imt_anakInput.value = imt;
                    } else if (imt >= 9 && imt < 11) {
                        st_anakInput.value = 'Tinggi';
                        gz_anakInput.value = 'Gizi Kurang';
                        imt_anakInput.value = imt;
                    } else if (imt >= 11 && imt < 19) {
                        st_anakInput.value = 'Normal';
                        gz_anakInput.value = 'Normal';
                        imt_anakInput.value = imt;
                    } else if (imt >= 19 && imt < 33) {
                        st_anakInput.value = 'Pendek';
                        gz_anakInput.value = 'Kelebihan Berat Badan';
                        imt_anakInput.value = imt;
                    } else {
                        st_anakInput.value = 'Pendek';
                        gz_anakInput.value = 'Obesitas';
                        imt_anakInput.value = imt;
                    }
                } else if (jkValue === 'P') {
                    if (imt < 9) {
                        st_anakInput.value = "Tinggi";
                        gz_anakInput.value = "Bawah Garis Merah";
                        imt_anakInput.value = imt;
                    } else if (imt >= 9 && imt < 11) {
                        st_anakInput.value = 'Tinggi';
                        gz_anakInput.value = 'Gizi Kurang';
                        imt_anakInput.value = imt;
                    } else if (imt >= 11 && imt < 19) {
                        st_anakInput.value = 'Normal';
                        gz_anakInput.value = 'Normal';
                        imt_anakInput.value = imt;
                    } else if (imt >= 19 && imt < 33) {
                        st_anakInput.value = 'Pendek';
                        gz_anakInput.value = 'Kelebihan Berat Badan';
                        imt_anakInput.value = imt;
                    } else {
                        st_anakInput.value = 'Pendek';
                        gz_anakInput.value = 'Obesitas';
                        imt_anakInput.value = imt;
                    }
                }
            } else {
                if (imt < 10) {
                    st_anakInput.value = 'Tinggi';
                    gz_anakInput.value = 'Gizi Buruk';
                } else if (imt >= 10 && imt < 25) {
                    st_anakInput.value = 'Normal';
                    gz_anakInput.value = 'Normal';
                } else if (imt >= 25 && imt < 30) {
                    st_anakInput.value = 'Pendek';
                    gz_anakInput.value = 'Kelebihan Berat Badan';
                } else {
                    st_anakInput.value = 'Pendek';
                    gz_anakInput.value = 'Obesitas';
                }
            }
            imt_anakInput.value = imt.toFixed(2);
        } else {
            st_anakInput.value = '- Inputan Tidak Valid';
        }
    }

    // Select
    function selectAllText(input) {
        input.select();
    };

    // Tabel Antrian
    function tampilkanTabel(button) {
        var badges = document.querySelectorAll('.badge.ku');

        // Remove 'active' class from all badges
        badges.forEach(function(badge) {
            badge.classList.remove('active');
        });

        // Add 'active' class to the clicked badge
        button.classList.add('active');

        // Display the table
        var tabel = document.getElementById("tabel_antrian");
        tabel.style.display = "table";
    }

    // Search
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const danaksSelect = document.getElementById("danaks_id");

        // Initially hide the select element
        danaksSelect.style.display = 'none';

        // Simpan opsi "Silahkan Pilih Nama" ke dalam variabel
        const placeholderOption = danaksSelect.querySelector('option[value="null"]');

        // Membuat daftar semua opsi (kecuali opsi "Silahkan Pilih Nama")
        const options = Array.from(danaksSelect.options).filter(option => option.value !== "null");

        // Menambahkan event listener untuk input pencarian
        searchInput.addEventListener("input", function() {
            const searchText = searchInput.value.toLowerCase();
            const filteredOptions = options.filter(option =>
                option.textContent.toLowerCase().includes(searchText)
            );

            // Mengosongkan dropdown
            danaksSelect.innerHTML = '';

            if (searchText.length > 0) {
                // Tampilkan select element jika ada teks dalam input
                danaksSelect.style.display = 'block';

                // Tambahkan kembali opsi "Silahkan Pilih Nama"
                danaksSelect.appendChild(placeholderOption);

                // Menampilkan opsi yang sesuai
                filteredOptions.forEach(option => {
                    danaksSelect.appendChild(option.cloneNode(true));
                });
            } else {
                // Sembunyikan select element jika input kosong
                danaksSelect.style.display = 'none';
            }
        });
    });


    // Reset
    document.addEventListener("DOMContentLoaded", function() {
        // Temukan elemen tombol reset
        let resetButton = document.getElementById("reset");

        // Temukan semua elemen input dalam formulir yang ingin di-reset, kecuali untuk input pencarian
        let inputElements = document.querySelectorAll('input[type="text"], input[type="number"]');
        // Kecualikan input pencarian dari daftar elemen input
        let searchInput = document.getElementById("searchInput");

        // Temukan elemen select yang ingin di-reset
        let danaksSelect = document.getElementById("danaks_id");

        // Temukan semua elemen radio
        let radioElements = document.querySelectorAll('input[type="radio"]');

        // Temukan semua elemen checkbox
        let checkboxElements = document.querySelectorAll('input[type="checkbox"]');

        // Simpan indeks pilihan awal
        let initialSelectedIndex = danaksSelect.selectedIndex;

        // Temukan elemen button Berdiri dan Telentang
        let berdiriButton = document.getElementById('berdiriButton');
        let telentangButton = document.getElementById('telentangButton');



        // Tambahkan event listener untuk tombol reset
        resetButton.addEventListener("click", function() {
            // Set .innerText to '0' for specific elements
            let elementToReset1 = document.getElementById('umur_tahun_badge');
            let elementToReset2 = document.getElementById('umur_bulan_badge');

            berdiriButton.style.backgroundColor = '';
            telentangButton.style.backgroundColor = '';
            // Loop melalui semua elemen input kecuali input pencarian dan reset nilainya
            inputElements.forEach(function(input) {
                if (input !== searchInput) {
                    if (input.type === "text") {
                        input.value = "";
                    } else if (input.type === "number") {
                        input.value = 0;
                    }
                }
            });

            // Reset pilihan pada elemen select ke opsi pertama (indeks 0)
            danaksSelect.selectedIndex = initialSelectedIndex;

            // Uncheck semua radio buttons
            radioElements.forEach(function(radio) {
                radio.checked = false;
            });

            // Uncheck semua checkbox
            checkboxElements.forEach(function(checkbox) {
                checkbox.checked = false;
            });

            if (umur_tahun_badge) {
                umur_tahun_badge.innerText = '0';
            }

            if (umur_bulan_badge) {
                umur_bulan_badge.innerText = '0';
            }
        });
    });
</script>
