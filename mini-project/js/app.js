'use strict';

const btnMobile = document.getElementById('mobile-menu-btn');
const navMain = document.getElementById('main-nav');

btnMobile.addEventListener('click', () => {
    navMain.classList.toggle('tampil');
    const isExpanded = btnMobile.getAttribute('aria-expanded') === 'true';
    btnMobile.setAttribute('aria-expanded', !isExpanded);
});

const btnTheme = document.getElementById('theme-toggle');

btnTheme.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme');
    const isDark = document.body.classList.contains('dark-theme');
    btnTheme.textContent = isDark ? 'Tema Terang' : 'Tema HITAM';
});

const dataFitur = [
    { id: 1, judul: 'Belajar Dari 0', deskripsi: 'Materi disusun khusus bagi pemula pertahap.', kategori: 'pemula' },
    { id: 2, judul: 'Praktik Langsung', deskripsi: 'Latihan coding interaktif untuk mengasah keterampilan.', kategori: 'pemula' },
    { id: 3, judul: 'Bimbingan Mentor', deskripsi: 'Dapatkan bimbingan untuk mempercepat belajarmu.', kategori: 'lanjutan' },
    { id: 4, judul: 'Komunitas Aktif', deskripsi: 'Dukungan sesama anggota melalui grup diskusi.', kategori: 'lanjutan' }
];

const gridFitur = document.getElementById('fitur-grid');
const filterFitur = document.getElementById('filter-fitur');

function buatKartu(item) {
    const article = document.createElement('article');
    article.classList.add('card');
    
    const h3 = document.createElement('h3');
    h3.textContent = item.judul;
    
    const p = document.createElement('p');
    p.textContent = item.deskripsi;
    
    article.appendChild(h3);
    article.appendChild(p);
    return article;
}

function renderFitur(data) {
    gridFitur.replaceChildren();
    
    if (data.length === 0) {
        const p = document.createElement('p');
        p.textContent = 'Tidak ada fitur yang ditemukan.';
        gridFitur.appendChild(p);
        return;
    }
    
    const fragment = document.createDocumentFragment();
    data.forEach(item => {
        fragment.appendChild(buatKartu(item));
    });
    gridFitur.appendChild(fragment);
}

filterFitur.addEventListener('change', (e) => {
    const nilaiFilter = e.target.value;
    if (nilaiFilter === 'semua') {
        renderFitur(dataFitur);
    } else {
        const dataTersaring = dataFitur.filter(item => item.kategori === nilaiFilter);
        renderFitur(dataTersaring);
    }
});

renderFitur(dataFitur); 
const faqButtons = document.querySelectorAll('.faq-btn');

faqButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        const targetId = this.getAttribute('aria-controls');
        const contentTarget = document.getElementById(targetId);
        const isExpanded = this.getAttribute('aria-expanded') === 'true';
        faqButtons.forEach(btnLain => {
            btnLain.setAttribute('aria-expanded', 'false');
            const kontenLain = document.getElementById(btnLain.getAttribute('aria-controls'));
            kontenLain.classList.remove('tampil');
        });
        if (!isExpanded) {
            this.setAttribute('aria-expanded', 'true');
            contentTarget.classList.add('tampil');
        }
    });
});

const formPendaftaran = document.getElementById('form-pendaftaran');
const inputEmail = document.getElementById('email');
const formFeedback = document.getElementById('form-feedback');

formPendaftaran.addEventListener('submit', (e) => {
    e.preventDefault(); 
    
    const emailValue = inputEmail.value.trim();
    formFeedback.className = ''; 
    if (!emailValue) {
        formFeedback.textContent = 'Error: Email tidak boleh kosong.';
        formFeedback.classList.add('feedback-error');
        inputEmail.focus();
        return;
    }
    if (!emailValue.includes('@') || !emailValue.includes('.')) {
        formFeedback.textContent = 'Error: Format email tidak valid.';
        formFeedback.classList.add('feedback-error');
        inputEmail.focus();
        return;
    }
    formFeedback.textContent = `Pendaftaran berhasil! Instruksi telah dikirim ke: ${emailValue}`;
    formFeedback.classList.add('feedback-success');
    formPendaftaran.reset();
});

const btnBackToTop = document.getElementById('back-to-top');

window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        btnBackToTop.hidden = false;
    } else {
        btnBackToTop.hidden = true;
    }
});

btnBackToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});