'use strict';

function validasiNilai(nilai) {
  return typeof nilai === 'number' && Number.isFinite(nilai) && nilai >= 0 && nilai <= 100;
}

function tentukanKategori(nilai) {
  if (!validasiNilai(nilai)) return null;
  if (nilai >= 85) return 'A';
  if (nilai >= 70) return 'B';
  if (nilai >= 60) return 'C';
  return 'D';
}

function tentukanStatus(nilai) {
  if (!validasiNilai(nilai)) return 'Data tidak valid';
  if (nilai >= 60) return 'Lulus';
  return 'Tidak lulus';
}

function buatRingkasan(nama, nilai) {
  return {
    nama: nama,
    nilai: nilai,
    kategori: tentukanKategori(nilai),
    status: tentukanStatus(nilai)
  };
}

const kasusUji = [
  { nama: 'Alya', nilai: 0 },
  { nama: 'Bima', nilai: 59 },
  { nama: 'Citra', nilai: 60 },
  { nama: 'Danu', nilai: 69 },
  { nama: 'Eka', nilai: 70 },
  { nama: 'Fani', nilai: 85 },
  { nama: 'Gilang', nilai: 101 },
  { nama: 'Hana', nilai: 84 }, 
  { nama: 'Iwan', nilai: -1 },   
  { nama: 'Joko', nilai: '80' }, 
  { nama: 'Kiki', nilai: NaN }   
];

const hasilUji = kasusUji.map(({ nama, nilai }) =>
  buatRingkasan(nama, nilai)
);

console.table(hasilUji);
console.log("\n--- Uji Terpisah validasiNilai ---");
console.log("Nilai -1   :", validasiNilai(-1));
console.log("Nilai 0    :", validasiNilai(0));
console.log("Nilai 100  :", validasiNilai(100));
console.log("Nilai 101  :", validasiNilai(101));
console.log("Nilai NaN  :", validasiNilai(NaN));
console.log("Teks '80'  :", validasiNilai('80'));