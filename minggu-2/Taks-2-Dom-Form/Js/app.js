'use strict'; 
  
const peserta = [ 
  { id: 1, nama: 'Alya', prodi: 'Teknik Informatika' }, 
  { id: 2, nama: 'Bima', prodi: 'Sistem Informasi' }, 
]; 
  
const form = document.querySelector('#form-peserta'); 
const namaInput = document.querySelector('#nama'); 
const prodiInput = document.querySelector('#prodi'); 
const filterInput = document.querySelector('#filter-prodi'); 
const daftar = document.querySelector('#daftar-peserta'); 
const status = document.querySelector('#status'); 
const errorNama = document.querySelector('#error-nama'); 
const errorProdi = document.querySelector('#error-prodi'); 
  
function validasiPeserta(calon) { 
  const hasil = { valid: true, errorNama: '', errorProdi: '' };
  
  if (calon.nama.trim().length < 3) {
    hasil.valid = false;
    hasil.errorNama = 'Nama minimal 3 karakter.';
  }
  
  if (!calon.prodi) {
    hasil.valid = false;
    hasil.errorProdi = 'Program studi wajib dipilih.';
  }
  
  return hasil;
} 
  
function buatKartuPeserta(item) { 
  const article = document.createElement('article');
  article.classList.add('kartu');

  const h2 = document.createElement('h2');
  h2.textContent = item.nama;

  const p = document.createElement('p');
  p.textContent = item.prodi;

  article.appendChild(h2);
  article.appendChild(p);
  
  return article;
} 
  
function renderPeserta(data) { 
  daftar.replaceChildren(); 
  
  if (data.length === 0) {
    status.textContent = 'Tidak ada peserta';
  } else {
    status.textContent = ''; 
    const fragment = document.createDocumentFragment();
    data.forEach(item => {
      fragment.appendChild(buatKartuPeserta(item));
    });
    daftar.appendChild(fragment);
  }
} 
  
form.addEventListener('submit', (event) => { 
  event.preventDefault(); 
  
  const calon = {
    nama: namaInput.value,
    prodi: prodiInput.value
  };

  const hasilValidasi = validasiPeserta(calon);
  errorNama.textContent = hasilValidasi.errorNama;
  namaInput.setAttribute('aria-invalid', hasilValidasi.errorNama ? 'true' : 'false');
  errorProdi.textContent = hasilValidasi.errorProdi;
  prodiInput.setAttribute('aria-invalid', hasilValidasi.errorProdi ? 'true' : 'false');
  if (!hasilValidasi.valid) {
    return;
  }

  peserta.push({
    id: Date.now(),
    nama: calon.nama.trim(),
    prodi: calon.prodi
  });

  form.reset();
  namaInput.setAttribute('aria-invalid', 'false');
  prodiInput.setAttribute('aria-invalid', 'false');
  filterInput.value = 'semua';
  
  renderPeserta(peserta);
}); 
  
filterInput.addEventListener('change', () => { 
  const kriteria = filterInput.value;
  if (kriteria === 'semua') {
    renderPeserta(peserta);
  } else {
    const dataTersaring = peserta.filter(item => item.prodi === kriteria);
    renderPeserta(dataTersaring);
  }
}); 
  
renderPeserta(peserta);