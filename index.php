<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktik Bootstrap - Manajemen Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-secondary text-white p-4">
        <h1 class="h3 m-0">Website Praktik</h1>
    </header>

    <nav class="bg-info text-white p-3">Navigasi</nav>
    <div class="container-fluid my-4">
        <div class="row min-vh-100">
            <aside class="col-md-3">
                <div class="bg-light border rounded p-3">
                    <h2>Menu</h2>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="index.html" class="text-decoration-none text-black">Dashboard</a></li>
                        <li class="list-group-item"><a href="index.php" class="text-decoration-none text-black">Daftar Buku</a></li>
                        <li class="list-group-item"><a href="#" class="text-decoration-none text-black">Form Peminjam</a></li>
                    </ul>
                </div>
            </aside>

            <main class="col-md-9">
                <!-- Section Form Tambah / Edit Buku -->
                <section class="border rounded p-3">
                    <h2 id="formTitle">Form Tambah Buku</h2>
                    <form action="" id="formBuku" novalidate>
                        <!-- Field Tersembunyi untuk menyimpan ID saat mode Edit -->
                        <input type="hidden" id="bookId" name="id" value="" />

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="judul" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" id="judul" name="judul" required minlength="3">
                                <div class="invalid-feedback">
                                    Judul buku harus diisi dan minimal 3 karakter.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="penulis" class="form-label">Penulis</label>
                                <input type="text" class="form-control" id="penulis" name="penulis" required minlength="3">
                                <div class="invalid-feedback">
                                    Penulis buku harus diisi dan minimal 3 karakter.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tahun" class="form-label">Tahun Terbit</label>
                                <input type="number" class="form-control" id="tahun" name="tahun" required min="1900" max="2026">
                                <div class="invalid-feedback">
                                    Tahun terbit harus diisi antara 1900 dan 2026.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" required min="0" step="1">
                                <div class="invalid-feedback">
                                    Stok harus diisi dan minimal 0.
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" id="btnSubmit" class="btn btn-primary">Submit</button>
                            <button type="button" id="btnCancel" class="btn btn-secondary d-none" onclick="resetForm()">Batal Edit</button>
                        </div>
                    </form>
                </section>

                <!-- Section Tabel Daftar Buku -->
                <section class="border rounded p-3 mt-4">
                    <h2>Daftar Buku</h2>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tahun Terbit</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="daftarBuku">
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </div>

    <footer class="bg-dark-subtle text-black text-center p-2 m-4">
        <p class="mb-0">Copyright &copy; 2023 Website Praktik. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let bukus = [
            { id: 1, judul: "Laskar Pelangi", penulis: "Andrea Hirata", tahun: 2005, stok: 10 },
            { id: 2, judul: "Seporsi Mie Ayam Sebelum Mati", penulis: "Brian Khrisna", tahun: 2025, stok: 5 },
            { id: 3, judul: "Bumi Manusia", penulis: "Pramoedya Ananta Toer", tahun: 1980, stok: 7 }
        ];
        let nextId = 4;

        const form = document.getElementById("formBuku");
        const formTitle = document.getElementById("formTitle");
        const btnSubmit = document.getElementById("btnSubmit");
        const btnCancel = document.getElementById("btnCancel");

        // Fungsi Render Tabel Buku
        function renderBuku() {
            const daftarBuku = document.getElementById("daftarBuku");
            daftarBuku.innerHTML = "";

            if (bukus.length === 0) {
                daftarBuku.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Belum ada data buku.</td></tr>`;
                return;
            }

            bukus.forEach((buku, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${buku.judul}</td>
                    <td>${buku.penulis}</td>
                    <td>${buku.tahun}</td>
                    <td>${buku.stok}</td>
                    <td>
                        <button class="btn btn-sm btn-warning me-1" onclick="editBuku(${buku.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteBuku(${buku.id})">Delete</button>
                    </td>
                `;
                daftarBuku.appendChild(row);
            });
        }

        // Fungsi Fitur Edit Buku
        function editBuku(id) {
            const buku = bukus.find(b => b.id === id);
            if (buku) {
                document.getElementById("bookId").value = buku.id;
                document.getElementById("judul").value = buku.judul;
                document.getElementById("penulis").value = buku.penulis;
                document.getElementById("tahun").value = buku.tahun;
                document.getElementById("stok").value = buku.stok;

                // Ubah UI Form ke mode Edit
                formTitle.textContent = "Form Edit Buku";
                btnSubmit.textContent = "Update Buku";
                btnSubmit.classList.replace("btn-primary", "btn-warning");
                btnCancel.classList.remove("d-none");

                // Scroll halus ke form
                form.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Fungsi Fitur Delete Buku
        function deleteBuku(id) {
            if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
                bukus = bukus.filter(buku => buku.id !== id);
                renderBuku();

                // Jika buku yang sedang diedit dihapus, reset form
                if (document.getElementById("bookId").value == id) {
                    resetForm();
                }
            }
        }

        // Fungsi Reset Form (Kembali ke mode Tambah)
        function resetForm() {
            form.reset();
            document.getElementById("bookId").value = "";
            formTitle.textContent = "Form Tambah Buku";
            btnSubmit.textContent = "Submit";
            btnSubmit.classList.replace("btn-warning", "btn-primary");
            btnCancel.classList.add("d-none");
            form.classList.remove("was-validated");
        }

        // Event Listener Form Submit (Tambah / Edit)
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            if (!form.checkValidity()) {
                form.classList.add("was-validated");
                return;
            }

            const id = parseInt(document.getElementById("bookId").value);
            const judul = document.getElementById("judul").value;
            const penulis = document.getElementById("penulis").value;
            const tahun = parseInt(document.getElementById("tahun").value);
            const stok = parseInt(document.getElementById("stok").value);

            if (id) {
                // Update Buku
                const bukuIndex = bukus.findIndex(buku => buku.id === id);
                if (bukuIndex !== -1) {
                    bukus[bukuIndex] = { id, judul, penulis, tahun, stok };
                }
            } else {
                // Tambah Buku Baru
                bukus.push({ id: nextId++, judul, penulis, tahun, stok });
            }

            renderBuku();
            resetForm();
        });

        // Jalankan render awal
        renderBuku();
    </script>
</body>

</html>