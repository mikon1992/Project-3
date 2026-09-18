'use strict'; 
  
const status = document.querySelector('#status'); 
const daftar = document.querySelector('#daftar-materi'); 
const tombolMuat = document.querySelector('#muat'); 
const tombolCobaLagi = document.querySelector('#coba-lagi'); 
  
function aturState(state, pesan) { 
  status.dataset.state = state; 
  status.textContent = pesan; 
  tombolCobaLagi.hidden = state !== 'error'; 
} 
  
async function ambilMateri() { 
  const response = await fetch('data/features.json');
  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`);
  }
  
  return await response.json(); 
} 
  
function renderMateri(data) { 
  daftar.replaceChildren(); 
  
  const fragment = document.createDocumentFragment();
  data.forEach(item => {
    const article = document.createElement('article');
    article.classList.add('kartu'); 
    
    const h3 = document.createElement('h3');
    h3.textContent = item.judul; 
    
    const p = document.createElement('p');
    p.textContent = `Durasi: ${item.durasi}`; 
    
    article.appendChild(h3);
    article.appendChild(p);
    fragment.appendChild(article);
  });
  
  daftar.appendChild(fragment);
} 
  
async function muatData() { 
  aturState('loading', 'Memuat data...'); 
  tombolMuat.disabled = true; 
  daftar.replaceChildren(); 
  
  try { 
    const data = await ambilMateri(); 
    
    if (data.length === 0) {
      aturState('empty', 'Tidak ada data materi saat ini.');
    } else {
      aturState('success', 'Data berhasil dimuat.');
      renderMateri(data);
    }
  } catch (error) { 
    console.error('Terjadi kesalahan:', error); 
    aturState('error', 'Gagal memuat materi. Silakan coba lagi.'); 
  } finally { 
    tombolMuat.disabled = false; 
  } 
} 
  
tombolMuat.addEventListener('click', muatData); 
tombolCobaLagi.addEventListener('click', muatData);